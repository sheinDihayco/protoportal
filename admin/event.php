<?php
include_once "../templates/header.php";
include_once 'includes/connection.php';
include_once '../PHP/event-con.php'
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>School Calendar</h1>
        <button type="button" class="ri-calendar-2-line tablebutton" data-bs-toggle="modal" data-bs-target="#addEventModal"></button>
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
                <div class="modal-body" style="background-color:#e6ffe6;">
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
                                        <div style="display: flex; align-items: flex-start;">
                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editEventModal<?php echo htmlspecialchars($event['id']); ?>" style="margin-right: 5px;">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form id="deleteForm<?php echo htmlspecialchars($event['id']); ?>" method="POST" action="../admin/upload/delete_event.php" style="display:inline;">
                                                <input type="hidden" name="event_id" value="<?php echo htmlspecialchars($event['id']); ?>">
                                                <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo htmlspecialchars($event['id']); ?>)">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
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
                        <div class="modal-body" style="background-color:#e6ffe6;">
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

<?php include_once "../templates/footer.php" ?>