<?php include_once "../templates/header.php" ?>
<?php include_once "../PHP/set-slots-con.php"; ?>
<?php include('modals/add-rooms.php'); ?>
<?php include('modals/add-set-slots.php'); ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1> Time Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#timeSlotModal">
        </button>
        <button type="button" class="ri-arrow-go-back-fill tablebutton" onclick="window.location.href='../admin/set-schedule.php';">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Time </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <section class="section dashboard">
        <div class="row">

            <!-- Recent Sales -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Time <span>| Available</span></h5>

                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($timeSlots as $slot): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($slot['start_time']); ?></td>
                                        <td><?php echo htmlspecialchars($slot['end_time']); ?></td>

                                        <td>
                                            <button class="btn btn-sm btn-warning ri-edit-2-fill edit-time" data-id="<?php echo $slot['time_id']; ?>" data-start="<?php echo htmlspecialchars($slot['start_time']); ?>" data-end="<?php echo htmlspecialchars($slot['end_time']); ?>"></button>

                                            <button class="btn btn-sm btn-danger ri-delete-bin-6-line delete-time" data-id="<?php echo $slot['time_id']; ?>"></button>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div><!-- End Recent Sales -->


            <div class="pagetitle">
                <h1> Room Records</h1>
                <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#roomModal">
                </button>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Room</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <!-- Recent Sales -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Room <span>| Available</span></h5>

                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rooms as $room): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($room['room_name']); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning ri-edit-2-fill edit-room"
                                                data-id="<?php echo $room['room_id']; ?>"
                                                data-name="<?php echo htmlspecialchars($room['room_name']); ?>"></button>

                                            <button class="btn btn-sm btn-danger ri-delete-bin-6-line delete-room"
                                                data-id="<?php echo $room['room_id']; ?>"></button>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div><!-- End Recent Sales -->

        </div><!-- End Left side columns -->
    </section>
</main>

<?php include_once "../templates/footer.php" ?>