<?php include_once "../templates/header3.php"; ?>

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

$connection->close();
?>


<main id="main" class="main" style="background-color: #e6ffe6;">
    <section class="section dashboard">
        <div class="row">

        <div class="col-lg-12">
                <div class="card recent-sales overflow-auto">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="../admin/bsit-payment.php">BSIT</a></li>
                            <li><a class="dropdown-item" href="../admin/bsba-payment.php">BSBA</a></li>
                            <li><a class="dropdown-item" href="../admin/bsoa-payment.php">BSOA</a></li>
                        </ul>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">Profile <span>| viewing</span></h5>

                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $database = new Connection();
                                $db = $database->open();

                                try {
                                    $sql = 'SELECT * FROM tbl_students WHERE user_id = :user_id ORDER BY lname ASC';

                                    $stmt = $db->prepare($sql);
                                    $stmt->bindParam(':user_id', $userid, PDO::PARAM_INT);
                                    $stmt->execute();

                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                        <tr>
                                            <th scope="row"><a href="#"><?php echo htmlspecialchars($row["user_name"]); ?></a></th>
                                            <td><?php echo htmlspecialchars($row["lname"]); ?>, <?php echo htmlspecialchars($row["fname"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["course"]); ?> - <?php echo htmlspecialchars($row["year"]); ?></td>
                                            <td>
                                                <form action="stud_profile.php" method="post">
                                                    <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-success" name="submit"><i class="ri-arrow-right-circle-fill"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                } catch (PDOException $e) {
                                    echo "There is some problem in connection: " . $e->getMessage();
                                }

                                $database->close();
                                ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div><!-- End Recent Sales -->

        </div>

        <div class="row">

         <!-- Start Event -->
            <div class="col-xxl-8 col-md-8">
                <div class="card info-card sales-card">
                    <div class="filter">
                        
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Today's Event</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-day"></i>
                            </div>
                            <div class="ps-3">
                                <?php if ($todaysEvent) : ?>
                                    <h6 style="font-size:12px"><?php echo htmlspecialchars($todaysEvent['start_date']); ?></h6>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div style="flex-grow: 1;">
                                            <h6 class="card-title"><?php echo htmlspecialchars($todaysEvent['title']); ?></h6>
                                            <!--<p>Description: <?php echo htmlspecialchars($todaysEvent['description']); ?></p>-->
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Event List <span class="badge bg-success" style="color: white;">This month</span></h5>
                        <ul class="list-group">
                            <?php if (!empty($events)) : ?>
                                <?php foreach ($events as $event) : ?>
                                    <li class="list-group-item">
                                        <h6 class="card-title"><?php echo htmlspecialchars($event['title'] ?? 'Untitled Event'); ?>
                                            <span><?php echo htmlspecialchars($event['start_date'] ?? 'Unknown Date'); ?></span>
                                        </h6>
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
</main><!-- End #main -->


<!-- Add required CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<!-- Add custom CSS to remove underlines -->


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
<?php include_once "../templates/footer.php"; ?>