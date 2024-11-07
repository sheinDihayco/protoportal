<?php
include_once "../templates/header.php";
include_once 'includes/connection.php';
include_once '../PHP/event-con.php' ?>
<?php include('modals/add-event.php'); ?>
<?php include('modals/edit-event.php'); ?>

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

    </section>
</main>

<?php include_once "../templates/footer.php" ?>