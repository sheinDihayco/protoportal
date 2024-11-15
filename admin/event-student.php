<?php include_once "../templates/header3.php";?>
<?php include_once "../PHP/event-student-con.php"; ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>School Calendar</h1>
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

<?php include_once "../templates/footer.php"; ?>

<style>
/* Basic table styling */
.overflow-auto ul.list-group-item {
    font-size: 16px;
}

/* Responsive styling */
@media (max-width: 1200px) {
    .pagetitle h1 {
        font-size: 1.8rem;
    }
    .breadcrumb-item a,
    .breadcrumb-item.active {
        font-size: 0.95rem;
    }
}

@media (max-width: 992px) {
    .pagetitle h1 {
        font-size: 1.5rem;
    }

    .modal-content,
    .form-control {
        font-size: 0.9rem;
    }
}

@media (max-width: 768px) {
    .breadcrumb-item a,
    .breadcrumb-item.active {
        font-size: 0.85rem;
    }

    .overflow-auto ul.list-group-item h6.card-title {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .pagetitle h1 {
        font-size: 1.3rem;
    }

    .overflow-auto ul.list-group-item h6.card-title {
        font-size: 0.9rem;
    }

    .modal-content {
        padding: 10px;
    }

    .calendar,
    #calendar {
        overflow-x: auto;
    }
}
</style>
