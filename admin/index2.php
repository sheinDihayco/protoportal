<?php
include_once "../templates/header2.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open();

$sql = "SELECT * FROM tbl_events ORDER BY date DESC";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$today = date('Y-m-d');
$currentMonthStart = date('Y-m-01');
$currentMonthEnd = date('Y-m-t');
$todaysEvent = null;
$filteredEvents = [];
$filterTitle = '';
$showTodayEvent = true;

// Separate today's event and filter events within the current month
foreach ($events as $event) {
    if ($event['date'] === $today) {
        $todaysEvent = $event;
    }

    if ($event['date'] >= $currentMonthStart && $event['date'] <= $currentMonthEnd) {
        $filteredEvents[] = $event;
    }
}

// Filter events based on form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filterTitle = isset($_POST['title']) ? $_POST['title'] : '';

    if ($filterTitle) {
        $filteredEvents = array_filter($filteredEvents, function ($event) use ($filterTitle) {
            return stripos($event['title'], $filterTitle) !== false;
        });
        $showTodayEvent = false;
    }
}

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud FROM tbl_students");
$statements->execute();
$studcount = $statements->fetch(PDO::FETCH_ASSOC);

$connection->close();
?>
<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">

            <!-- Student Count Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Student <span>| Count</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?php echo $studcount['count_stud'] ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Student Count Card -->

            <!-- Student Count Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Student <span>| Count</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?php echo $studcount['count_stud'] ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Student Count Card -->
            <!-- Student Count Card -->
            <div class="col-xxl-4 col-md-6">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Student <span>| Count</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6><?php echo $studcount['count_stud'] ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Student Count Card -->


        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">
                            <div class="card-body">
                                <h5 class="card-title">Schedule <span>| set</span></h5>
                                <table id="scheduleTable" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Instructor</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Subject</th>
                                            <th scope="col">Room</th>
                                            <th scope="col">Time Slot</th>
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
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> Events <span class="badge bg-success" style="color: white;">This month</span></h5>
                        <ul class="list-group">
                            <?php if (!empty($filteredEvents)) : ?>
                                <?php foreach ($filteredEvents as $event) : ?>
                                    <li class="list-group-item">
                                        <h6 class="card-title"><?php echo htmlspecialchars($event['title']); ?> <span>
                                                <?php echo htmlspecialchars($event['date']); ?></span></h6>
                                    </li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <li class="list-group-item">No events found for the current month.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>

        </div>


    </section>

    </section>

</main><!-- End #main -->
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
<style>
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
<?php
include_once "../templates/footer.php";
?>