<?php include_once "../templates/header2.php"; ?>
<?php
include_once 'includes/connection.php';

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

session_start();
$userid = $_SESSION["login"];

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

$instructors = fetchOptions('tbl_users', 'user_id', 'CONCAT(user_fname, " ", user_lname) AS name');
$courses = fetchOptions('tbl_course', 'course_id', 'CONCAT(course_description, " (Year ", course_year, ")") AS description');
$subjects = fetchOptions('tbl_subjects', 'id', 'description');
$rooms = fetchOptions('tbl_rooms', 'room_id', 'room_name');
$times = fetchOptions('tbl_sched_time', 'time_id', 'CONCAT(start_time, " - ", end_time) AS slot');

// Fetch schedules for the logged-in user
function fetchSchedules($user_id)
{
    global $conn;
    $stmt = $conn->prepare("
        SELECT s.schedule_id, 
               CONCAT(u.user_fname, ' ', u.user_lname) AS instructor_name,
               CONCAT(c.course_description, ' (Year ', c.course_year, ')') AS course_description,
               sb.description AS subject_description,
               r.room_name,
               CONCAT(t.start_time, ' - ', t.end_time) AS time_slot
        FROM tbl_schedule s
        JOIN tbl_users u ON s.instructor_id = u.user_id
        JOIN tbl_course c ON s.course_id = c.course_id
        JOIN tbl_subjects sb ON s.subject_id = sb.id
        JOIN tbl_rooms r ON s.room_id = r.room_id
        JOIN tbl_sched_time t ON s.time_id = t.time_id
        WHERE s.instructor_id = :userid
    ");
    $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
$schedules = fetchSchedules($userid);
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Schedule Records</h1>
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Schedules</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
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
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($schedules as $schedule): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($schedule['schedule_id']) ?></td>
                                            <td><?= htmlspecialchars($schedule['instructor_name']) ?></td>
                                            <td><?= htmlspecialchars($schedule['course_description']) ?></td>
                                            <td><?= htmlspecialchars($schedule['subject_description']) ?></td>
                                            <td><?= htmlspecialchars($schedule['room_name']) ?></td>
                                            <td><?= htmlspecialchars($schedule['time_slot']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Optional: AJAX for dynamic updates (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Load schedules initially
        function loadSchedules() {
            $.ajax({
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

        loadSchedules(); // Load schedules when document is ready
    });
</script>

<?php include_once "../templates/footer.php"; ?>