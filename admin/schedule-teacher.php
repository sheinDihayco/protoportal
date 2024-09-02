<?php
include_once "../templates/header2.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open();

$userid = $_SESSION["login"];

// Fetch schedules for the logged-in user
function fetchSchedules($user_id)
{
    global $pdo;
    $stmt = $pdo->prepare("
        SELECT s.schedule_id, 
               CONCAT(u.user_fname, ' ', u.user_lname) AS instructor_name,
               CONCAT(c.course_description, ' (Year ', c.course_year, ')') AS course_description,
               sb.description AS subject_description,
               r.room_name,
               CONCAT(t.start_time, ' - ', t.end_time) AS time_slot,
               s.day_id,
               d.day_name,
               t.start_time
        FROM tbl_schedule s
        JOIN tbl_users u ON s.instructor_id = u.user_id
        JOIN tbl_course c ON s.course_id = c.course_id
        JOIN tbl_subjects sb ON s.subject_id = sb.id
        JOIN tbl_rooms r ON s.room_id = r.room_id
        JOIN tbl_sched_time t ON s.time_id = t.time_id
        JOIN tbl_days d ON s.day_id = d.day_id
        WHERE s.instructor_id = :userid
        ORDER BY d.day_id, t.start_time
    ");
    $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$schedules = fetchSchedules($userid);
$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Schedule Records</h1>
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
                                            <th scope="col"><?php echo $day; ?></th>
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
                                                    foreach ($schedules as $schedule) {
                                                        if (
                                                            $schedule['day_name'] === $day &&
                                                            $schedule['start_time'] >= $currentSlot &&
                                                            $schedule['start_time'] < $nextSlot
                                                        ) {
                                                            echo htmlspecialchars($schedule['subject_description']) . "<br>" .
                                                                htmlspecialchars($schedule['course_description']) . "<br>" .
                                                                htmlspecialchars($schedule['room_name']);
                                                        }
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
    </section>
</main>

<!-- Optional: AJAX for dynamic updates (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<style>
    body {
        font-family: "Arial", sans-serif;
        background-color: #f4f4f4;
    }

    .card-title {
        font-family: "Times New Roman", serif;
        font-size: 24px;
        color: #2c3e50;
        margin-bottom: 20px;
    }

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
<?php
include_once "../templates/footer.php";
?>