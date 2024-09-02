<?php include_once "../templates/header.php"; ?>
<?php
include_once 'includes/connection.php';

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

// Function to fetch data for dropdowns
function fetchOptions($table, $valueField, $textField, $whereClause = '1')
{
    global $conn;
    $query = "SELECT $valueField, $textField FROM $table WHERE $whereClause";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch data for dropdowns
$instructors = fetchOptions('tbl_users', 'user_id', 'CONCAT(user_fname, " ", user_lname) AS name', 'user_role = "teacher"');
$courses = fetchOptions('tbl_course', 'course_id', 'CONCAT(course_description, " (Year ", course_year, ")") AS description');
$subjects = fetchOptions('tbl_subjects', 'id', 'description');
$rooms = fetchOptions('tbl_rooms', 'room_id', 'room_name');
$times = fetchOptions('tbl_sched_time', 'time_id', 'CONCAT(start_time, " - ", end_time) AS slot');
$days = fetchOptions('tbl_days', 'day_id', 'day_name');

// Function to fetch schedule data
function fetchSchedules($conn)
{
    $query = "SELECT ts.*, u.user_fname, u.user_lname, c.course_description, s.description AS subject_description, r.room_name, d.day_name, t.start_time
              FROM tbl_schedule ts
              JOIN tbl_users u ON ts.instructor_id = u.user_id 
              JOIN tbl_course c ON ts.course_id = c.course_id
              JOIN tbl_subjects s ON ts.subject_id = s.id
              JOIN tbl_rooms r ON ts.room_id = r.room_id
              JOIN tbl_days d ON ts.day_id = d.day_id
              JOIN tbl_sched_time t ON ts.time_id = t.time_id";

    $stmt = $conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Assuming $conn is defined elsewhere and passed to the function
$schedules = fetchSchedules($conn);

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

?>

<?php
if (isset($_SESSION['schedule_create']) && $_SESSION['schedule_create']) {
    echo "
        <div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
            Schedule created successfully!
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                setTimeout(function() {
                    var alert = document.querySelector('.alert');
                    if (alert) {
                        alert.style.opacity = '0';
                        setTimeout(function() {
                            alert.style.display = 'none';
                        }, 600);
                    }
                }, 5000);
            });
        </script>";
    unset($_SESSION['schedule_create']);
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Schedule Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#scheduleModal">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Accounts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Schedule Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered formal-schedule">
                                <thead>
                                    <tr>
                                        <th scope="col">Time Slot</th>
                                        <?php foreach ($daysOfWeek as $day): ?>
                                            <th scope="col"><?php echo htmlspecialchars($day); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Create time slots from 7:00 AM to 5:00 PM
                                    $startTime = strtotime('07:00');
                                    $endTime = strtotime('17:00');
                                    $timeInterval = 60 * 60; // 1-hour interval

                                    while ($startTime <= $endTime):
                                        $currentSlot = date('H:i', $startTime);
                                        $nextSlot = date('H:i', $startTime + $timeInterval);
                                    ?>
                                        <tr>
                                            <td><?php echo $currentSlot . ' - ' . $nextSlot; ?></td>
                                            <?php foreach ($daysOfWeek as $day): ?>
                                                <td>
                                                    <?php
                                                    // Ensure $schedules is an array and not null
                                                    if (!empty($schedules) && is_array($schedules)) {
                                                        foreach ($schedules as $schedule) {
                                                            if (
                                                                $schedule['day_name'] === $day &&
                                                                $schedule['start_time'] >= $currentSlot &&
                                                                $schedule['start_time'] < $nextSlot
                                                            ) {
                                                                echo htmlspecialchars($schedule['subject_description']) . "<br>" .
                                                                    htmlspecialchars($schedule['course_description']) . "<br>" .
                                                                    htmlspecialchars($schedule['user_lname']) . ", " .
                                                                    htmlspecialchars($schedule['user_fname']) . "<br>" .
                                                                    htmlspecialchars($schedule['room_name']) . "<hr>";
                                                            }
                                                        }
                                                    } else {
                                                        echo "No schedule data available.";
                                                    }
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php
                                        $startTime += $timeInterval;
                                    endwhile;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Section -->
        <div class="modal fade" id="scheduleModal" tabindex="-1">
            <div class="modal-dialog modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding: 25px;">
                        <form id="scheduleForm" action="./includes/submit-schedule.php" method="POST">
                            <div class="form-group">
                                <label for="instructor">Instructor</label>
                                <select id="instructor" name="instructor" class="form-control" required>
                                    <option value="" disabled selected>Select an Instructor</option>
                                    <?php foreach ($instructors as $instructor): ?>
                                        <option value="<?= htmlspecialchars($instructor['user_id']) ?>">
                                            <?= htmlspecialchars($instructor['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="course">Course</label>
                                <select id="course" name="course" class="form-control" required>
                                    <option value="" disabled selected>Select a Course</option>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= htmlspecialchars($course['course_id']) ?>">
                                            <?= htmlspecialchars($course['description']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="subject">Subject</label>
                                <select id="subject" name="subject" class="form-control" required>
                                    <option value="" disabled selected>Select a Subject</option>
                                    <?php foreach ($subjects as $subject): ?>
                                        <option value="<?= htmlspecialchars($subject['id']) ?>">
                                            <?= htmlspecialchars($subject['description']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="room">Room</label>
                                <select id="room" name="room" class="form-control" required>
                                    <option value="" disabled selected>Select a Room</option>
                                    <?php foreach ($rooms as $room): ?>
                                        <option value="<?= htmlspecialchars($room['room_id']) ?>">
                                            <?= htmlspecialchars($room['room_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="time">Time Slot</label>
                                <select id="time" name="time" class="form-control" required>
                                    <option value="" disabled selected>Select a Time Slot</option>
                                    <?php foreach ($times as $time): ?>
                                        <option value="<?= htmlspecialchars($time['time_id']) ?>">
                                            <?= htmlspecialchars($time['slot']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="day">Day</label>
                                <select id="day" name="day" class="form-control" required>
                                    <option value="" disabled selected>Select a Day</option>
                                    <?php foreach ($days as $day): ?>
                                        <option value="<?= htmlspecialchars($day['day_id']) ?>">
                                            <?= htmlspecialchars($day['day_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary btn-sm btn-block" style="margin-top: 10px;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editScheduleForm">
                            <input type="hidden" id="editScheduleId" name="schedule_id">
                            <div class="form-group">
                                <label for="editInstructor">Instructor</label>
                                <select id="editInstructor" name="instructor" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label for="editCourse">Course</label>
                                <select id="editCourse" name="course" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label for="editSubject">Subject</label>
                                <select id="editSubject" name="subject" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label for="editRoom">Room</label>
                                <select id="editRoom" name="room" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label for="editTime">Time Slot</label>
                                <select id="editTime" name="time" class="form-control" required></select>
                            </div>
                            <div class="form-group">
                                <label for="editDay">Day</label>
                                <select id="editDay" name="day" class="form-control" required></select>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm btn-block" style="margin-top: 10px;">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</main>

<?php include_once "../templates/footer.php"; ?>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


<script>
    $(document).ready(function() {
        function loadSchedules() {
            $.ajax({
                url: 'includes/fetch-schedules.php',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var tbody = $('#scheduleTable tbody');
                    tbody.empty();
                    $.each(response, function(index, schedule) {
                        tbody.append(`
                        <tr>
                            <td>${schedule.instructor_name}</td>
                            <td>${schedule.course_description}</td>
                            <td>${schedule.subject_description}</td>
                            <td>${schedule.room_name}</td>
                            <td>${schedule.time_slot}</td>
                            <td>${schedule.day_name}</td>
                            <td>
                                <button class="btn btn-sm btn-warning ri-edit-2-fill edit-btn" data-id="${schedule.schedule_id}"></button>
                                <button class="btn btn-sm btn-danger ri-delete-bin-6-line delete-btn" data-id="${schedule.schedule_id}"></button>
                            </td>
                        </tr>
                    `);
                    });
                },
                error: function() {
                    $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                    $('#toastTitle').text('Error');
                    $('#toastBody').text('Failed to load schedules.');
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                }
            });
        }

        function populateDropdowns() {
            $.ajax({
                url: 'includes/fetch-options.php',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    // Populate the edit form dropdowns
                    $('#editInstructor').html(data.instructors.map(instructor =>
                        `<option value="${instructor.user_id}">${instructor.name}</option>`).join(''));
                    $('#editCourse').html(data.courses.map(course =>
                        `<option value="${course.course_id}">${course.description}</option>`).join(''));
                    $('#editSubject').html(data.subjects.map(subject =>
                        `<option value="${subject.id}">${subject.description}</option>`).join(''));
                    $('#editRoom').html(data.rooms.map(room =>
                        `<option value="${room.room_id}">${room.room_name}</option>`).join(''));
                    $('#editTime').html(data.times.map(time =>
                        `<option value="${time.time_id}">${time.slot}</option>`).join(''));
                    $('#editDay').html(data.days.map(day =>
                        `<option value="${day.day_id}">${day.day_name}</option>`).join(''));
                }
            });
        }

        $('#scheduleForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                        $('#toastTitle').text('Error');
                        $('#toastBody').text(response.error);
                    } else {
                        $('#statusToast').removeClass('bg-danger').addClass('bg-success');
                        $('#toastTitle').text('Success');
                        $('#toastBody').text(response.success);
                        loadSchedules();
                        $('#scheduleForm')[0].reset();
                    }
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                },
                error: function() {
                    $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                    $('#toastTitle').text('Error');
                    $('#toastBody').text('Failed to add schedule.');
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                }
            });
        });

        $(document).on('click', '.edit-btn', function() {
            var scheduleId = $(this).data('id');
            $.ajax({
                url: 'includes/get-schedules.php',
                type: 'GET',
                data: {
                    schedule_id: scheduleId
                },
                dataType: 'json',
                success: function(schedule) {
                    if (schedule.error) {
                        $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                        $('#toastTitle').text('Error');
                        $('#toastBody').text(schedule.error);
                        var toast = new bootstrap.Toast($('#statusToast'));
                        toast.show();
                    } else {
                        $('#editScheduleId').val(schedule.schedule_id);
                        $('#editInstructor').val(schedule.instructor_id);
                        $('#editCourse').val(schedule.course_id);
                        $('#editSubject').val(schedule.subject_id);
                        $('#editRoom').val(schedule.room_id);
                        $('#editTime').val(schedule.time_id);
                        $('#editModal').modal('show');
                    }
                },
                error: function() {
                    $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                    $('#toastTitle').text('Error');
                    $('#toastBody').text('Failed to load schedule.');
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                }
            });
        });

        $('#editScheduleForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: 'includes/update-schedule.php',
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        $('#statusToast').removeClass('bg-danger').addClass('bg-success');
                        $('#toastTitle').text('Success');
                        $('#toastBody').text('Schedule has been updated.');
                        var toast = new bootstrap.Toast($('#statusToast'));
                        toast.show();
                        loadSchedules();
                        $('#editModal').modal('hide');
                    } else {
                        $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                        $('#toastTitle').text('Error');
                        $('#toastBody').text(response.message);
                        var toast = new bootstrap.Toast($('#statusToast'));
                        toast.show();
                    }
                },
                error: function() {
                    $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                    $('#toastTitle').text('Error');
                    $('#toastBody').text('Failed to update schedule.');
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                }
            });
        });


        $(document).on('click', '.delete-btn', function() {
            var scheduleId = $(this).data('id');
            if (confirm('Are you sure you want to delete this schedule?')) {
                $.ajax({
                    url: 'includes/delete-schedule.php',
                    type: 'POST',
                    data: {
                        schedule_id: scheduleId
                    },
                    success: function(response) {
                        if (response === 'Success') {
                            $('#statusToast').removeClass('bg-danger').addClass('bg-success');
                            $('#toastTitle').text('Success');
                            $('#toastBody').text('Schedule has been deleted.');
                            var toast = new bootstrap.Toast($('#statusToast'));
                            toast.show();
                            loadSchedules();
                        } else {
                            $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                            $('#toastTitle').text('Error');
                            $('#toastBody').text('Failed to delete schedule.');
                            var toast = new bootstrap.Toast($('#statusToast'));
                            toast.show();
                        }
                    },
                    error: function() {
                        $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                        $('#toastTitle').text('Error');
                        $('#toastBody').text('Failed to delete schedule.');
                        var toast = new bootstrap.Toast($('#statusToast'));
                        toast.show();
                    }
                });
            }
        });

        // Initial load
        loadSchedules();
        populateDropdowns();
    });
</script>

<style>
    .formal-schedule {
        background-color: #ffffff;
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .formal-schedule th,
    .formal-schedule td {
        border: 1px solid #dddddd;
        text-align: center;
        padding: 12px;
        vertical-align: middle;
    }

    .formal-schedule th {
        background-color: #2c3e50;
        color: #ffffff;
        font-weight: bold;
        font-size: 16px;
    }

    .formal-schedule td {
        font-size: 14px;
        color: #2c3e50;
        background-color: #f9f9f9;
    }

    .formal-schedule tr:nth-child(even) {
        background-color: #f1f1f1;
    }

    .formal-schedule tr:hover {
        background-color: #e1e1e1;
        cursor: pointer;
    }

    /* Styling for table header cells */
    .table th {
        font-weight: bold;
        background-color: #2c3e50;
        color: white;
    }

    /* Padding and alignment */
    .table th,
    .table td {
        padding: 15px;
        text-align: center;
        vertical-align: middle;
    }

    /* Responsive styling */
    @media (max-width: 768px) {

        .formal-schedule th,
        .formal-schedule td {
            font-size: 12px;
            padding: 8px;
        }
    }

    a {
        text-decoration: none !important;
    }

    .breadcrumb-item a {
        text-decoration: none !important;
    }

    .breadcrumb-item.active {
        text-decoration: none;
    }

    .navbar-brand {
        text-decoration: none !important;
    }

    .alert {
        padding: 20px;
        background-color: #4CAF50;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
        border-radius: 4px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 5000;
        width: 300px;
    }
</style>
<?php include_once "../templates/footer.php"; ?>