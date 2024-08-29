<?php
include_once "../templates/header2.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open(); // Use $pdo instead of $db for consistency

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

// Initialize variables for counting and fetching assigned students
$assignedStudents = [];
$studentCount = 0;
$userid = $_SESSION["login"]; // Get the logged-in instructor's user ID

try {
    // Query to count the number of students assigned to the specific instructor
    $countSql = "SELECT COUNT(*) AS student_count
                FROM tbl_student_instructors
                WHERE instructor_id = :instructor_id";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute([':instructor_id' => $userid]);
    $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);
    $studentCount = $countResult['student_count'];

    // Query to get students assigned to the specific instructor
    $sql = "SELECT s.user_id, s.lname, s.fname, s.course, s.year, s.status, s.user_name
            FROM tbl_students s
            INNER JOIN tbl_student_instructors si ON s.user_id = si.student_id
            WHERE si.instructor_id = :instructor_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':instructor_id' => $userid]);
    $assignedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "There was an error: " . $e->getMessage();
}

// Close database connection
$connection->close();
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
                                <h6> <?php echo htmlspecialchars($studentCount); ?></p>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Student Count Card -->

            <!-- Start Event -->
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
                        <h5 class="card-title">Today's Event <span style="margin-left: 10px;"><?php echo htmlspecialchars($todaysEvent['date']); ?></span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-day"></i>
                            </div>
                            <div class="ps-3">
                                <?php if ($todaysEvent) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div style="flex-grow: 1;">
                                            <h6><?php echo htmlspecialchars($todaysEvent['title']); ?> </h6>
                                            <!-- <p><?php echo htmlspecialchars($todaysEvent['description']); ?></p>-->
                                        </div>
                                    </li>
                                <?php else : ?>
                                    <p>No events scheduled for today.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Event -->

        </div>

        <div class="row">
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


        </div>


    </section>

    </section>

</main><!-- End #main -->
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