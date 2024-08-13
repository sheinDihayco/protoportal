<?php include_once "../templates/header.php"; ?>
<?php
include_once 'includes/connection.php';

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

// Fetch data for dropdowns
function fetchOptions($table, $valueField, $textField)
{
    global $conn;
    $options = [];
    $stmt = $conn->prepare("SELECT $valueField, $textField FROM $table");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options[] = $row;
    }
    return $options;
}

$instructors = fetchOptions('tbl_employee', 'employee_id', 'CONCAT(first_name, " ", last_name) AS name');
$courses = fetchOptions('tbl_course', 'course_id', 'CONCAT(course_description, " (Year ", course_year, ")") AS description');
$subjects = fetchOptions('tbl_subjects', 'id', 'description');
$rooms = fetchOptions('tbl_rooms', 'room_id', 'room_name');
$times = fetchOptions('tbl_sched_time', 'time_id', 'CONCAT(start_time, " - ", end_time) AS slot');
?>

<main id="main" class="main">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">

                    <h2 class="card-title">Set Schedule</h2>
                    <form id="scheduleForm" action="./includes/submit-schedule.php" method="POST">
                        <div class="form-group">
                            <label for="instructor">Instructor</label>
                            <select id="instructor" name="instructor" class="form-control" required>
                                <option value="" disabled selected>Select an Instructor</option>
                                <?php foreach ($instructors as $instructor): ?>
                                    <option value="<?= htmlspecialchars($instructor['employee_id']) ?>">
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

                        <button type="submit" class="btn btn-primary btn-sm btn-block" style="margin-top: 10px;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Schedule <span>| set</span></h5>
                        <table id="scheduleTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Instructor</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Subject</th>
                                    <th scope="col">Room</th>
                                    <th scope="col">Time Slot</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Data will be loaded here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
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
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="statusToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <strong id="toastTitle" class="me-auto">Notification</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastBody">
                <!-- Message will be loaded here by JavaScript -->
            </div>
        </div>
    </div>
</main>

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
                            <td>${schedule.schedule_id}</td>
                            <td>${schedule.instructor_name}</td>
                            <td>${schedule.course_description}</td>
                            <td>${schedule.subject_description}</td>
                            <td>${schedule.room_name}</td>
                            <td>${schedule.time_slot}</td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" data-id="${schedule.schedule_id}">Edit</button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${schedule.schedule_id}">Delete</button>
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
                        `<option value="${instructor.employee_id}">${instructor.name}</option>`).join(''));
                    $('#editCourse').html(data.courses.map(course =>
                        `<option value="${course.course_id}">${course.description}</option>`).join(''));
                    $('#editSubject').html(data.subjects.map(subject =>
                        `<option value="${subject.id}">${subject.description}</option>`).join(''));
                    $('#editRoom').html(data.rooms.map(room =>
                        `<option value="${room.room_id}">${room.room_name}</option>`).join(''));
                    $('#editTime').html(data.times.map(time =>
                        `<option value="${time.time_id}">${time.slot}</option>`).join(''));
                }
            });
        }

        $('#scheduleForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#statusToast').removeClass('bg-danger').addClass('bg-success');
                    $('#toastTitle').text('Success');
                    $('#toastBody').text('Schedule has been added.');
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                    loadSchedules();
                    $('#scheduleForm')[0].reset();
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
<?php include_once "../templates/footer.php"; ?>