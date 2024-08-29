<?php
include_once "../templates/header3.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open();

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

$statements = $conn->prepare("SELECT COUNT(studentID) AS count_stud FROM tbl_students");
$statements->execute();
$studcount = $statements->fetch(PDO::FETCH_ASSOC);

$connection->close();
?>


<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">
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
                                            <th scope="row"><a href="#"><?php echo htmlspecialchars($row["studentID"]); ?></a></th>
                                            <td><?php echo htmlspecialchars($row["lname"]); ?>, <?php echo htmlspecialchars($row["fname"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["course"]); ?> - <?php echo htmlspecialchars($row["year"]); ?></td>
                                            <td>
                                                <form action="stud_profile.php" method="post">
                                                    <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['studentID']); ?>">
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
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"> Event List <span class="badge bg-success" style="color: white;">This month</span></h5>
                    <ul class="list-group">
                        <?php if (!empty($filteredEvents)) : ?>
                            <?php foreach ($filteredEvents as $event) : ?>
                                <li class="list-group-item">
                                    <h6 class="card-title"><?php echo htmlspecialchars($event['title']); ?> <span>
                                            <?php echo htmlspecialchars($event['date']); ?></span></h6>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="list-group-item">No events found for the current month.</li>
                        <?php endif; ?>
                    </ul>
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
                <?php foreach ($events as $event) : ?> {
                        title: '<?php echo $event['title']; ?>',
                        start: '<?php echo $event['date']; ?>',
                        description: '<?php echo $event['description']; ?>',
                        color: 'your_custom_color'
                    },
                <?php endforeach; ?>
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



<?php
include_once "../templates/footer.php";
?>