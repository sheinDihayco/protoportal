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

<!-- Optional: AJAX for dynamic updates (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function hideWelcomeMessage() {
        var message = document.getElementById('message');
        if (message) {
            message.style.display = 'none';
        }
    }
    setTimeout(hideWelcomeMessage, 60000);
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
    footer{
        background-color: #e6ffe6;
    }
</style>

<!-- Add required JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
            if(calendarEl){
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    customButtons: {
                        datePicker: {
                            text: '',
                            icon: 'bi bi-calendar',
                            click: function() {
                                $('#datePickerModal').modal('show');
                            }
                        }
                    },
                    headerToolbar: {
                        left: 'datePicker',
                        center: 'title',
                        right: 'today dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    events: [
                            <?php 
                            $eventData = [];
                            foreach ($events as $event) {
                                $eventData[] = "{
                                    title: '" . addslashes($event['title']) . "',
                                    start: '" . $event['date'] . "',
                                    description: '" . addslashes($event['description']) . "',
                                    color: 'your_custom_color'
                                }";
                            }
                            echo implode(",", $eventData);
                            ?>
                        ],
                    eventClick: function(info) {
                        alert(info.event.title + "\n" + info.event.start.toLocaleDateString() + "\n" + info.event.extendedProps.description);
                    }
                });
                calendar.render();

                // Initialize date picker
                $('#datepicker').datepicker({
                    format: 'yyyy-mm-dd',
                    autoclose: true
                }).on('changeDate', function(e) {
                    var date = e.format('yyyy-mm-dd');
                    calendar.gotoDate(date);
                    $('#datePickerModal').modal('hide');
                });
                calendar.render();
            }
        });
</script>

<!-- Date Picker Modal -->
<div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="datePickerModalLabel">Choose Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="datepicker"></div>
            </div>
        </div>
    </div>
</div>

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
    })
    // Unset the session variable to prevent repeated alerts
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>
</script>
