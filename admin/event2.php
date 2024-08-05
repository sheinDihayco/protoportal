<?php include_once "../templates/header.php" ?>
<?php
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open();

$sql = "SELECT * FROM tbl_events ORDER BY date ASC"; // Order events by date (nearest to farthest)
$stmt = $pdo->query($sql);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);
$today = date('Y-m-d');
$todaysEvent = null;
$filteredEvents = [];
$filterTitle = '';
$showTodayEvent = true;

// Separate today's event
foreach ($events as $event) {
    if ($event['date'] === $today) {
        $todaysEvent = $event;
        break;
    }
}

// Filter events based on form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filterTitle = isset($_POST['title']) ? $_POST['title'] : '';

    if ($filterTitle) {
        $filteredEvents = array_filter($events, function ($event) use ($filterTitle) {
            return stripos($event['title'], $filterTitle) !== false;
        });
        $showTodayEvent = false;
    }
}

$connection->close();
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>School Calendar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Calendar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <?php if (isset($_GET['error'])) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['error'], ENT_QUOTES, 'UTF-8'); ?>
        </div>
    <?php endif; ?>

    <section class="section calendar">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Saved Events</h5>
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($filterTitle); ?>">
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button type="submit" class="btn btn-primary"><i class="ri-search-2-line"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="overflow-auto" style="max-height: 400px;">
                            <ul class="list-group">
                                <?php foreach ($events as $event) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="me-2 flex-grow-1">
                                            <h6><?php echo $event['title']; ?></h6>
                                            <p><?php echo $event['date']; ?></p>
                                            <p><?php echo $event['description']; ?></p>
                                        </div>
                                        <div class="d-flex flex-column">
                                            <a href="edit_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-warning mb-2">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <!-- Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-center mt-3">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Add New Event</h5>
                        <!-- Event Form -->
                        <form action="includes/event.inc.php" method="POST">
                            <div class="mb-3">
                                <label for="eventTitle" class="form-label">Event Title</label>
                                <input type="text" class="form-control" id="eventTitle" name="eventTitle" required>
                            </div>
                            <div class="mb-3">
                                <label for="eventDate" class="form-label">Event Date</label>
                                <input type="date" class="form-control" id="eventDate" name="eventDate" required>
                            </div>
                            <div class="mb-3">
                                <label for="eventDescription" class="form-label">Event Description</label>
                                <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Event</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">School Events Calendar</h5>
                        <!-- Display Calendar -->
                        <div id='calendar'></div>
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
                        title: '<?php echo addslashes(htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8')); ?>',
                        start: '<?php echo htmlspecialchars($event['date'], ENT_QUOTES, 'UTF-8'); ?>',
                        description: '<?php echo addslashes(htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8')); ?>',
                        color: 'your_custom_color' // specify your custom color here
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

<?php include_once "../templates/footer.php" ?>