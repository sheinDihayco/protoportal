<?php include_once "../templates/header.php"; ?>
<?php include_once 'includes/connection.php';

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
    $query = "SELECT ts.*, u.user_fname, u.user_lname, c.course_description, s.description AS subject_description, r.room_name, d.day_name, t.start_time, c.course_year
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

$schedules = fetchSchedules($conn);

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

?>

<main id="main" class="main" >

    <div class="pagetitle">
        <h1>Schedule Records</h1>
        <button type="button" class="ri-add-line tablebutton" data-bs-toggle="modal" data-bs-target="#scheduleModal">
        </button>
        <button type="button" class="ri-time-fill tablebutton" onclick="window.location.href='../admin/set-slots.php';">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Schedules</li>
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
                                                <td class="schedule-cell">
                                                    <?php
                                                    if (!empty($schedules) && is_array($schedules)) {
                                                        foreach ($schedules as $schedule) {
                                                            if (
                                                                $schedule['day_name'] === $day &&
                                                                $schedule['start_time'] >= $currentSlot &&
                                                                $schedule['start_time'] < $nextSlot
                                                            ) {
                                                    ?>
                                                                <div class="schedule-container">
                                                                    <?php
                                                                    echo htmlspecialchars($schedule['subject_description']) . "<br>" .
                                                                        htmlspecialchars($schedule['course_description'])  .  "( " . htmlspecialchars($schedule['course_year']) . " )" . "<br>" .
                                                                        htmlspecialchars($schedule['user_lname']) . ", " .
                                                                        htmlspecialchars($schedule['user_fname']) . "<br>" .
                                                                        htmlspecialchars($schedule['room_name']);
                                                                    ?>

                                                                    <div class="action-buttons">
                                                                        <button class="btn btn-sm btn-warning edit-btn ri-edit-2-fill" data-id="<?php echo $schedule['schedule_id']; ?>"></button>
                                                                        <button class="btn btn-sm btn-danger delete-btn ri-delete-bin-6-line" data-id="<?php echo $schedule['schedule_id']; ?>"></button>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                    <?php
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
        <div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="scheduleModalLabel">Create New Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color:#e6ffe6;">
                        <div class="card-body p-4">
                            <form id="scheduleForm" action="./includes/submit-schedule.php" method="POST">
                                <!-- Instructor Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="instructor" class="form-label">Instructor</label>
                                        <select id="instructor" name="instructor" class="form-select" required>
                                            <option value="" disabled selected>Select an Instructor</option>
                                            <?php foreach ($instructors as $instructor): ?>
                                                <option value="<?= htmlspecialchars($instructor['user_id']) ?>">
                                                    <?= htmlspecialchars($instructor['name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please select an instructor.</div>
                                    </div>
                                    <!-- Course Selection -->
                                    <div class="col-md-6">
                                        <label for="course" class="form-label">Course</label>
                                        <select id="course" name="course" class="form-select" required>
                                            <option value="" disabled selected>Select a Course</option>
                                            <?php foreach ($courses as $course): ?>
                                                <option value="<?= htmlspecialchars($course['course_id']) ?>">
                                                    <?= htmlspecialchars($course['description']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please select a course.</div>
                                    </div>
                                </div>

                                <!-- Subject Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="subject" class="form-label">Subject</label>
                                        <select id="subject" name="subject" class="form-select" required>
                                            <option value="" disabled selected>Select a Subject</option>
                                            <?php foreach ($subjects as $subject): ?>
                                                <option value="<?= htmlspecialchars($subject['id']) ?>">
                                                    <?= htmlspecialchars($subject['description']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please select a subject.</div>
                                    </div>

                                    <!-- Room Selection -->
                                    <div class="col-md-6">
                                        <label for="room" class="form-label">Room</label>
                                        <select id="room" name="room" class="form-select" required>
                                            <option value="" disabled selected>Select a Room</option>
                                            <?php foreach ($rooms as $room): ?>
                                                <option value="<?= htmlspecialchars($room['room_id']) ?>">
                                                    <?= htmlspecialchars($room['room_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please select a room.</div>
                                    </div>
                                </div>

                                <!-- Time Slot & Day Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="time" class="form-label">Time Slot</label>
                                        <select id="time" name="time" class="form-select" required>
                                            <option value="" disabled selected>Select a Time Slot</option>
                                            <?php foreach ($times as $time): ?>
                                                <option value="<?= htmlspecialchars($time['time_id']) ?>">
                                                    <?= htmlspecialchars($time['slot']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please select a time slot.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="day" class="form-label">Day</label>
                                        <select id="day" name="day" class="form-select" required>
                                            <option value="" disabled selected>Select a Day</option>
                                            <?php foreach ($days as $day): ?>
                                                <option value="<?= htmlspecialchars($day['day_id']) ?>">
                                                    <?= htmlspecialchars($day['day_name']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <div class="invalid-feedback">Please select a day.</div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color:#e6ffe6;">
                        <div class="card-body p-4">
                            <form id="editScheduleForm" method="POST" action="./includes/update-schedule.php">
                                <input type="hidden" id="editScheduleId" name="schedule_id">

                                <!-- Instructor Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="editInstructor" class="form-label">Instructor</label>
                                        <select id="editInstructor" name="instructor" class="form-select" required>
                                            <option value="" disabled selected>Select an Instructor</option>
                                            <!-- Instructor options populated dynamically -->
                                        </select>
                                        <div class="invalid-feedback">Please select an instructor.</div>
                                    </div>
                                    <!-- Course Selection -->
                                    <div class="col-md-6">
                                        <label for="editCourse" class="form-label">Course</label>
                                        <select id="editCourse" name="course" class="form-select" required>
                                            <option value="" disabled selected>Select a Course</option>
                                            <!-- Course options populated dynamically -->
                                        </select>
                                        <div class="invalid-feedback">Please select a course.</div>
                                    </div>
                                </div>

                                <!-- Subject Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="editSubject" class="form-label">Subject</label>
                                        <select id="editSubject" name="subject" class="form-select" required>
                                            <option value="" disabled selected>Select a Subject</option>
                                            <!-- Subject options populated dynamically -->
                                        </select>
                                        <div class="invalid-feedback">Please select a subject.</div>
                                    </div>
                                    <!-- Room Selection -->
                                    <div class="col-md-6">
                                        <label for="editRoom" class="form-label">Room</label>
                                        <select id="editRoom" name="room" class="form-select" required>
                                            <option value="" disabled selected>Select a Room</option>
                                            <!-- Room options populated dynamically -->
                                        </select>
                                        <div class="invalid-feedback">Please select a room.</div>
                                    </div>
                                </div>

                                <!-- Time Slot & Day Selection -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="editTime" class="form-label">Time Slot</label>
                                        <select id="editTime" name="time" class="form-select" required>
                                            <option value="" disabled selected>Select a Time Slot</option>
                                            <!-- Time slot options populated dynamically -->
                                        </select>
                                        <div class="invalid-feedback">Please select a time slot.</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="editDay" class="form-label">Day</label>
                                        <select id="editDay" name="day" class="form-select" required>
                                            <option value="" disabled selected>Select a Day</option>
                                            <!-- Day options populated dynamically -->
                                        </select>
                                        <div class="invalid-feedback">Please select a day.</div>
                                    </div>
                                </div>

                                <!-- Update Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {
        // Show action buttons on hover
        $('.schedule-cell').hover(
            function() {
                $(this).find('.action-buttons').show();
            },
            function() {
                $(this).find('.action-buttons').hide();
            }
        );

        $('.edit-btn').on('click', function() {
            var scheduleId = $(this).data('id');
        });

        $('.delete-btn').on('click', function() {
            var scheduleId = $(this).data('id');
            X
        });
    });
</script>

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

        $('#scheduleForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        // Show conflict or other error alert
                        Swal.fire({
                            title: 'Conflict!',
                            text: response.error,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Show success alert
                        Swal.fire({
                            title: 'Success!',
                            text: 'Schedule created successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to set-schedule.php after confirmation
                                window.location.href = '../admin/set-schedule.php';
                            }
                        });
                    }
                },
                error: function() {
                    // Show error in toast
                    $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                    $('#toastTitle').text('Error');
                    $('#toastBody').text('Failed to add schedule.');
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                }
            });
        });

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
                        // Show error in toast
                        $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                        $('#toastTitle').text('Error');
                        $('#toastBody').text(response.error);
                    } else {
                        // Show success alert using SweetAlert2
                        Swal.fire({
                            title: 'Success!',
                            text: 'Schedule created successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to set-schedule.php after confirmation
                                window.location.href = '../admin/set-schedule.php';
                            }
                        });
                    }
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                },
                error: function() {
                    // Show error in toast
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
                        $('#editDay').val(schedule.day_id);
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
                        // Show success alert using SweetAlert2
                        Swal.fire({
                            title: 'Success!',
                            text: 'Schedule has been updated successfully.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Redirect to set-schedule.php
                                window.location.href = '../admin/set-schedule.php';
                            }
                        });
                    } else {
                        // Show error in toast
                        $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                        $('#toastTitle').text('Error');
                        $('#toastBody').text(response.message);
                        var toast = new bootstrap.Toast($('#statusToast'));
                        toast.show();
                    }
                },
                error: function() {
                    // Show error in toast
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

            // SweetAlert2 confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete this schedule?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'includes/delete-schedule.php',
                        type: 'POST',
                        data: {
                            schedule_id: scheduleId
                        },
                        success: function(response) {
                            if (response === 'Success') {
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'Schedule has been deleted successfully.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '../admin/set-schedule.php';
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Failed to delete schedule.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                title: 'Error!',
                                text: 'An error occurred while deleting the schedule.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });

        // Initial load
        loadSchedules();
        populateDropdowns();
    });
</script>

<style>
    /* Container styling for the schedule */
    .schedule-container {
        position: relative;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #c0c0c0;
        border-radius: 10px;
        background-color: #ffffff;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Action button styling with improved visibility */
    .schedule-container .action-buttons {
        display: none;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.7);
        padding: 12px;
        border-radius: 6px;
        color: #ffffff;
    }

    .schedule-container:hover .action-buttons {
        display: block;
    }

    /* Formal table styling with emphasis on structure */
    .formal-schedule {
        background-color: #ffffff;
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        overflow: hidden;
    }

    /* Header styling with refined color and uppercase text */
    .formal-schedule th {
        background-color: #1a1a2e;
        color: #ffffff;
        font-weight: 700;
        font-size: 16px;
        padding: 16px;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* Body cell styling for a structured appearance */
    .formal-schedule td {
        border-top: 1px solid #dddddd;
        font-size: 14px;
        color: #333333;
        padding: 14px;
        text-align: center;
        background-color: #f9f9f9;
    }

    /* Alternating row background for readability */
    .formal-schedule tr:nth-child(even) {
        background-color: #f3f3f3;
    }

    /* Hover effect for rows to improve focus */
    .formal-schedule tr:hover {
        background-color: #eaeaea;
        cursor: pointer;
    }

    /* Table and cell adjustments */
    .table th,
    .table td {
        padding: 16px;
        vertical-align: middle;
        font-size: 15px;
    }

    /* Responsive adjustments for smaller screens */
    @media (max-width: 768px) {
        .formal-schedule th,
        .formal-schedule td {
            font-size: 13px;
            padding: 10px;
        }
    }

    /* Link styling for a consistent, formal appearance */
    a {
        text-decoration: none !important;
        color: inherit;
    }

    .breadcrumb-item a,
    .breadcrumb-item.active,
    .navbar-brand {
        text-decoration: none !important;
        color: #4a4a4a;
        font-weight: 600;
    }

</style>



<?php include_once "../templates/footer.php"; ?>