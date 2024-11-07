<?php
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
<!-- Optional: AJAX for dynamic updates (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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