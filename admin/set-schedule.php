<?php include_once "../templates/header.php"; ?>
<?php include_once '../PHP/set-schedule-con.php' ?>
<?php include('modals/add-schedule.php'); ?>
<?php include('modals/edit-schedule.php'); ?>

<main id="main" class="main" >

    <div class="pagetitle">
        <h1>Schedule Records</h1>
        <button type="button" class="ri-add-line tablebutton" data-bs-toggle="modal" data-bs-target="#scheduleModal">
        </button>
        <button type="button" class="ri-time-fill tablebutton" onclick="window.location.href='../admin/set-slots.php';">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Schedules</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Schedule Table -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered formal-schedule">
                                <thead>
                                    <tr>
                                        <th scope="col">Time Slot</th>
                                        <?php foreach ($daysOfWeek as $day): ?>
                                            <th scope="col"><?php echo htmlspecialchars($day); ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Create time slots from 7:00 AM to 5:00 PM
                                    $startTime = strtotime('07:00');
                                    $endTime = strtotime('17:00');
                                    $timeInterval = 60 * 60; // 1-hour interval

                                    while ($startTime <= $endTime):
                                        $currentSlot = date('H:i', $startTime);
                                        $nextSlot = date('H:i', $startTime + $timeInterval);
                                    ?>
                                        <tr>
                                            <td><?php echo $currentSlot . ' - ' . $nextSlot; ?></td>
                                            <?php foreach ($daysOfWeek as $day): ?>
                                                <td class="schedule-cell">
                                                    <?php
                                                    if (!empty($schedules) && is_array($schedules)) {
                                                        foreach ($schedules as $schedule) {
                                                            if (
                                                                $schedule['day_name'] === $day &&
                                                                $schedule['start_time'] >= $currentSlot &&
                                                                $schedule['start_time'] < $nextSlot
                                                            ) {
                                                    ?>
                                                                <div class="schedule-container">
                                                                    <?php
                                                                    echo htmlspecialchars($schedule['subject_description']) . "<br>" .
                                                                        htmlspecialchars($schedule['course_description'])  .  "( " . htmlspecialchars($schedule['course_year']) . " )" . "<br>" .
                                                                        htmlspecialchars($schedule['user_lname']) . ", " .
                                                                        htmlspecialchars($schedule['user_fname']) . "<br>" .
                                                                        htmlspecialchars($schedule['room_name']);
                                                                    ?>

                                                                    <div class="action-buttons">
                                                                        <button class="btn btn-sm btn-warning edit-btn ri-edit-2-fill" data-id="<?php echo $schedule['schedule_id']; ?>"></button>
                                                                        <button class="btn btn-sm btn-danger delete-btn ri-delete-bin-6-line" data-id="<?php echo $schedule['schedule_id']; ?>"></button>
                                                                    </div>
                                                                </div>
                                                                <hr>
                                                    <?php
                                                            }
                                                        }
                                                    } else {
                                                        echo "No schedule data available.";
                                                    }
                                                    ?>
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php
                                        $startTime += $timeInterval;
                                    endwhile;
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include_once "../templates/footer.php"; ?>