<?php
include_once "includes/connect.php";
include_once 'includes/connection.php';

// Initialize database connection
$connection = new Connection();
$pdo = $connection->open();

// Get user ID from session
$userid = $_SESSION["login"];

// Fetch student information
function getStudentInfo($user_id)
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT course, year FROM tbl_students WHERE user_id = :userid");
    $stmt->bindParam(':userid', $user_id, PDO::PARAM_INT);
    if (!$stmt->execute()) {
        // Log error and return false
        error_log("Failed to execute query in getStudentInfo");
        return false;
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Fetch schedules based on course and year
function fetchSchedules($course, $year)
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
        WHERE s.course_id = (SELECT course_id FROM tbl_course WHERE course_description = :course AND course_year = :year)
        ORDER BY d.day_id, t.start_time
    ");
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':year', $year);
    if (!$stmt->execute()) {
        // Log error and return false
        error_log("Failed to execute query in fetchSchedules");
        return false;
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get student info
$studentInfo = getStudentInfo($userid);
if (!$studentInfo) {
    echo "Failed to retrieve student information.";
    exit;
}

// Extract course and year from student info
$course = $studentInfo['course'];
$year = $studentInfo['year'];

// Fetch schedules
$schedules = fetchSchedules($course, $year);
if ($schedules === false) {
    echo "Failed to retrieve schedules.";
    exit;
}

$daysOfWeek = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
?>


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
