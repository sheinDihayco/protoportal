<?php 
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open();

$sql = "SELECT * FROM tbl_events ORDER BY title, start_date ASC";
$stmt = $pdo->query($sql);

$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Process events to aggregate by title and compute date ranges
$eventGroups = [];
foreach ($events as $event) {
    $title = $event['title'];
    if (!isset($eventGroups[$title])) {
        $eventGroups[$title] = [
            'id' => $event['id'], // Ensure ID is captured
            'start_date' => $event['start_date'],
            'end_date' => $event['end_date'],
            'description' => $event['description']
        ];
    } else {
        $eventGroups[$title]['end_date'] = max($eventGroups[$title]['end_date'], $event['end_date']);
    }
}

$today = date('Y-m-d');
$filteredEvents = [];
$filterTitle = '';

// Filter events based on form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filterTitle = isset($_POST['title']) ? $_POST['title'] : '';

    if ($filterTitle) {
        $filteredEvents = array_filter($eventGroups, function ($event, $title) use ($filterTitle) {
            return stripos($title, $filterTitle) !== false;
        }, ARRAY_FILTER_USE_BOTH);
    } else {
        $filteredEvents = $eventGroups;
    }
} else {
    $filteredEvents = $eventGroups;
}

$connection->close();
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['event_created']) && $_SESSION['event_created'] === true) : ?>
            Swal.fire({
                icon: 'success',
                title: 'Event Created',
                text: 'The event has been successfully created!',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    <?php unset($_SESSION['event_created']); ?> // Clear session variable
                }
            });
        <?php endif; ?>
    });
</script>

<!-- Handle Edit/Delete Alerts -->
<?php if (isset($_SESSION['event_edited'])) : ?>
    <script>
        Swal.fire({
            title: "Event Edited!",
            text: "The event has been successfully updated.",
            icon: "success",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "event2.php";
            }
        });
    </script>
<?php unset($_SESSION['event_edited']);
endif; ?>

<!-- Display Error if Event Not Deleted -->
<?php if (isset($_SESSION['event_not_deleted'])) : ?>
    <script>
        Swal.fire({
            title: "Error!",
            text: "The event could not be deleted.",
            icon: "error",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "event2.php";
            }
        });
    </script>
<?php unset($_SESSION['event_not_deleted']);
endif; ?>


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

 
<!-- Add required CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css' rel='stylesheet' />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css" rel="stylesheet">
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
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
                <?php
                $displayEvents = $filterTitle ? $filteredEvents : $events;
                $first = true;
                foreach ($displayEvents as $event) {
                    if (!$first) echo ",";
                    $first = false;
                ?> {
                        title: '<?php echo addslashes(htmlspecialchars($event['title'], ENT_QUOTES, 'UTF-8')); ?>',
                        start: '<?php echo htmlspecialchars($event['start_date'], ENT_QUOTES, 'UTF-8'); ?>',
                        end: '<?php echo htmlspecialchars($event['end_date'], ENT_QUOTES, 'UTF-8'); ?>',
                        description: '<?php echo addslashes(htmlspecialchars($event['description'], ENT_QUOTES, 'UTF-8')); ?>',
                        color: 'your_custom_color' // specify your custom color here
                    }
                <?php
                }
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
    });
</script>
