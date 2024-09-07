<?php
include_once "../templates/header2.php";
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


<main id="main" class="main">
    <div class="pagetitle">
        <h1>School Calendar</h1>
        <!-- <button type="button" class="ri-calendar-2-line tablebutton" data-bs-toggle="modal" data-bs-target="#addEventModal"></button>-->
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Calendar</li>
            </ol>
        </nav>
    </div>


    <!-- Add Event Modal -->
    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Event Form -->
                    <form action="includes/event.inc.php" method="POST">
                        <div class="mb-3">
                            <label for="eventTitle" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="eventTitle" name="eventTitle" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventStartDate" class="form-label">Event Start Date</label>
                            <input type="date" class="form-control" id="eventStartDate" name="eventStartDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventEndDate" class="form-label">Event End Date</label>
                            <input type="date" class="form-control" id="eventEndDate" name="eventEndDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="eventDescription" class="form-label">Event Description</label>
                            <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3"></textarea>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Add Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Display Filtered Events -->
    <section class="section calendar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Saved Events</h5>
                        <form method="POST" action="">
                            <div class="row mb-3">
                                <div class="col-md-10">
                                    <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($filterTitle); ?>" placeholder="Search by Event Title">
                                </div>
                                <div class="col-md-2 align-self-end">
                                    <button type="submit" class="btn btn-primary"><i class="ri-search-2-line"></i></button>
                                </div>
                            </div>
                        </form>
                        <div class="overflow-auto" style="max-height: 400px;">
                            <ul class="list-group">
                                <?php foreach ($filteredEvents as $title => $event) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div class="me-2 flex-grow-1">
                                            <h6 class="card-title">
                                                <?php echo htmlspecialchars($title); ?>
                                                <span>
                                                    <?php
                                                    if ($event['start_date'] === $event['end_date']) {
                                                        echo htmlspecialchars($event['start_date']);
                                                    } else {
                                                        echo htmlspecialchars($event['start_date']) . ' to ' . htmlspecialchars($event['end_date']);
                                                    }
                                                    ?>
                                                </span>
                                            </h6>
                                            <p><?php echo htmlspecialchars($event['description']); ?></p>
                                        </div>
                                        <!--<div style="display: flex; align-items: flex-start;">
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editEventModal<?php echo htmlspecialchars($event['id']); ?>" style="margin-right: 5px;">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form id="deleteForm<?php echo htmlspecialchars($event['id']); ?>" method="POST" action="../admin/upload/delete_event.php" style="display:inline;">
                                                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['id']); ?>">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo htmlspecialchars($event['id']); ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>-->
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
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

        <!-- Edit Event Modal (Dynamically Generated) -->
        <?php foreach ($filteredEvents as $title => $event) : ?>
            <div class="modal fade" id="editEventModal<?php echo htmlspecialchars($event['id']); ?>" tabindex="-1" aria-labelledby="editEventModalLabel<?php echo htmlspecialchars($event['id']); ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editEventModalLabel<?php echo htmlspecialchars($event['id']); ?>">Edit Event</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Edit Event Form -->
                            <form action="../admin/includes/update-event.php" method="POST">
                                <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($event['id']); ?>">

                                <div class="mb-3">
                                    <label for="editEventTitle<?php echo htmlspecialchars($event['id']); ?>" class="form-label">Event Title</label>
                                    <input type="text" class="form-control" id="editEventTitle<?php echo htmlspecialchars($event['id']); ?>" name="eventTitle" value="<?php echo htmlspecialchars($title); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editEventStartDate<?php echo htmlspecialchars($event['id']); ?>" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="editEventStartDate<?php echo htmlspecialchars($event['id']); ?>" name="eventStartDate" value="<?php echo htmlspecialchars($event['start_date']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editEventEndDate<?php echo htmlspecialchars($event['id']); ?>" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="editEventEndDate<?php echo htmlspecialchars($event['id']); ?>" name="eventEndDate" value="<?php echo htmlspecialchars($event['end_date']); ?>" required>
                                </div>

                                <div class="mb-3">
                                    <label for="editEventDescription<?php echo htmlspecialchars($event['id']); ?>" class="form-label">Event Description</label>
                                    <textarea class="form-control" id="editEventDescription<?php echo htmlspecialchars($event['id']); ?>" name="eventDescription" rows="3"><?php echo htmlspecialchars($event['description']); ?></textarea>
                                </div>

                                <!-- Modal Footer -->
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Update Event</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        <?php endforeach; ?>
    </section>
</main>

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

<!-- Date Picker Modal -->
<div class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="datePickerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="datePickerModalLabel">Choose Date</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="datepicker" style="width: 100%;"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check URL parameters for deletion status
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('deleted')) {
            const deleted = urlParams.get('deleted');
            if (deleted === 'true') {
                Swal.fire({
                    title: 'Deleted!',
                    text: 'The event has been deleted.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            } else if (deleted === 'false') {
                Swal.fire({
                    title: 'Error!',
                    text: 'The event could not be deleted.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        }
    });

    function confirmDelete(eventId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Locate the form and submit it
                var form = document.getElementById('deleteForm' + eventId);
                if (form) {
                    form.submit();
                } else {
                    Swal.fire('Error', 'Form not found!', 'error');
                }
            }
        });
    }
</script>

<?php include_once "../templates/footer.php" ?>