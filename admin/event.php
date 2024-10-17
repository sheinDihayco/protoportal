<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/event-con.php"; ?>

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
    
    <div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalTitle"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="eventModalDate"></p>
                    <p id="eventModalDescription"></p>
                </div>
            </div>
        </div>
    </div>

    <section class="section calendar">
        <div class="row">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Event</h5>
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
                        <ul class="list-group">
                            <?php if ($showTodayEvent && $todaysEvent) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div style="flex-grow: 1;">
                                        <h6 class="card-title"><?php echo htmlspecialchars($todaysEvent['title']); ?> <span class="badge bg-success" style="color: white;">Today's Event</span></h6>
                                        <p><?php echo htmlspecialchars($todaysEvent['date']); ?></p>
                                        <p><?php echo htmlspecialchars($todaysEvent['description']); ?></p>
                                    </div>
                                    <div style="display: flex; align-items: flex-start;">
                                        <a href="../admin/edit-event.php?id=<?php echo $todaysEvent['id']; ?>" class="btn btn-sm btn-warning" style="margin-right: 5px;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="../admin/upload/delete_event.php?id=<?php echo $todaysEvent['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </li>
                            <?php elseif (!$showTodayEvent && count($filteredEvents) > 0) : ?>
                                <?php foreach ($filteredEvents as $event) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div style="flex-grow: 1;">
                                            <h6 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h6>
                                            <p><?php echo htmlspecialchars($event['date']); ?></p>
                                            <p><?php echo htmlspecialchars($event['description']); ?></p>
                                        </div>
                                        <div style="display: flex; align-items: flex-start;">
                                            <a href="../admin/edit-event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-warning" style="margin-right: 5px;">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="../admin/upload/delete_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?');">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </div>
                                    </li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <li class="list-group-item">No events today.</li>
                            <?php endif; ?>
                        </ul>
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
                            <button type="submit" class="btn btn-sm btn-primary">Insert</button>
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

<?php include_once "../templates/footer.php"; ?>