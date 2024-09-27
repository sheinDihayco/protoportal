
<?php
include_once "includes/connect.php";
include_once 'includes/connection.php';

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

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud FROM tbl_students");
$statements->execute();
$studcount = $statements->fetch(PDO::FETCH_ASSOC);


// Get current year and month
$currentYear = date('Y');
$currentMonth = date('m');

// Establish database connection
$connection = new Connection();
$pdo = $connection->open();

// Fetch events for the current month
$sql = "SELECT * FROM tbl_events WHERE (DATE_FORMAT(start_date, '%Y-%m') = :currentMonthYear OR DATE_FORMAT(end_date, '%Y-%m') = :currentMonthYear) ORDER BY start_date ASC";
$stmt = $pdo->prepare($sql);
$currentMonthYear = $currentYear . '-' . $currentMonth;
$stmt->bindParam(':currentMonthYear', $currentMonthYear, PDO::PARAM_STR);
$stmt->execute();

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize variables for counting and fetching assigned students
$assignedInstructor = [];
$instructorCount = 0;
$userid = $_SESSION["login"]; // Get the logged-in instructor's user ID

try {
    // Query to count the number of students assigned to the specific instructor
    $countSql = "SELECT COUNT(*) AS isntructor_count
                FROM tbl_student_instructors
                WHERE student_id = :student_id";
    $countStmt = $pdo->prepare($countSql);
    $countStmt->execute([':student_id' => $userid]);
    $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);
    $instructorCount = $countResult['isntructor_count'];

    // Query to get students assigned to the specific instructor
    $sql = "SELECT u.user_id, u.user_fname, u.user_lname
            FROM tbl_users u
            INNER JOIN tbl_student_instructors si ON u.user_id = si.student_id
            WHERE si.student_id = :student_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':student_id' => $userid]);
    $assignedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "There was an error: " . $e->getMessage();
}



$connection->close();
?>