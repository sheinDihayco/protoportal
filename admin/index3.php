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

$connection->close();
?>


<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Event <span class="badge bg-success" style="color: white;">Today's Event</span></h5>
                        <ul class="list-group">
                            <?php if ($showTodayEvent && $todaysEvent) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div style="flex-grow: 1;">
                                        <h6 class="card-title"><?php echo htmlspecialchars($todaysEvent['title']); ?></h6>
                                        <p><?php echo htmlspecialchars($todaysEvent['date']); ?></p>
                                        <p><?php echo htmlspecialchars($todaysEvent['description']); ?></p>
                                    </div>

                                </li>
                            <?php else : ?>
                                <li class="list-group-item">No events today.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"> Events <span class="badge bg-success" style="color: white;">This month</span></h5>
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