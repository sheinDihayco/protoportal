<?php
include_once "includes/connect.php";
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open(); // Use $pdo instead of $db for consistency
$userid = $_SESSION["login"];

$connection = new Connection();
$pdo = $connection->open();

// Fetch events from the database ordered by title and start date
$sql = "SELECT * FROM tbl_events ORDER BY title, start_date ASC";
$stmt = $pdo->query($sql);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process events to group by title and aggregate date ranges
$eventGroups = [];
foreach ($events as $event) {
    $title = $event['title'];
    if (!isset($eventGroups[$title])) {
        $eventGroups[$title] = [
            'id' => $event['id'], // Capture ID
            'start_date' => $event['start_date'],
            'end_date' => $event['end_date'],
            'description' => $event['description']
        ];
    } else {
        // Update the end date if necessary
        $eventGroups[$title]['end_date'] = max($eventGroups[$title]['end_date'], $event['end_date']);
    }
}

/// Get today's date
$today = date('Y-m-d');

// Fetch events happening today from the database
$sql = "SELECT * FROM tbl_events WHERE :today BETWEEN start_date AND end_date ORDER BY title ASC";
$stmt = $pdo->prepare($sql);
$stmt->execute(['today' => $today]);

// Fetch the first event happening today (if any)
$todaysEvent = $stmt->fetch(PDO::FETCH_ASSOC);

// Handle filtering logic
$filteredEvents = [];
$filterTitle = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filterTitle = isset($_POST['title']) ? $_POST['title'] : '';

    if ($filterTitle) {
        // Filter events by title
        $filteredEvents = array_filter($eventGroups, function ($event, $title) use ($filterTitle) {
            return stripos($title, $filterTitle) !== false;
        }, ARRAY_FILTER_USE_BOTH);
    } else {
        // No filter, show all events
        $filteredEvents = $eventGroups;
    }
} else {
    $filteredEvents = $eventGroups;
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



$connection->close();
?>

<!-- Optional: AJAX for dynamic updates (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
