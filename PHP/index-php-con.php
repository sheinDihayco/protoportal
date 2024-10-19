<?php
include_once "includes/connect.php";
include_once 'includes/connection.php'; // Assuming this is where $conn is defined

// Prepare and execute SQL queries to count employees and students
$statements = $conn->prepare("SELECT COUNT(user_id) AS count_emp FROM tbl_users");
$statements->execute();
$empcount = $statements->fetch(PDO::FETCH_ASSOC);

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud FROM tbl_students");
$statements->execute();
$studcount = $statements->fetch(PDO::FETCH_ASSOC);

// Establish database connection
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

$connection->close();
?>

<!-- Link to Bootstrap JS and its dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Check if the session variable 'user_created' is set
  <?php if (isset($_SESSION['success']) && $_SESSION['success']): ?>
    // Show SweetAlert success message with OK button
    Swal.fire({
      icon: 'success',
      title: 'Login successful!',
      text: ' You have successfully logged into the system.',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect to the student page when OK is clicked
        window.location.href = '../admin/index.php';
      }
    });

    // Unset the session variable to prevent repeated alerts
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
</script>
