<?php include_once "../templates/header2.php"; ?>
<?php include_once "../PHP/schedule-teacher-con.php"; ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Schedule Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Accounts</li>
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
                                            <th scope="col"><?php echo $day; ?></th>
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
                                                <td>
                                                    <?php
                                                    foreach ($schedules as $schedule) {
                                                        if (
                                                            $schedule['day_name'] === $day &&
                                                            $schedule['start_time'] >= $currentSlot &&
                                                            $schedule['start_time'] < $nextSlot
                                                        ) {
                                                            echo htmlspecialchars($schedule['subject_description']) . "<br>" .
                                                                htmlspecialchars($schedule['room_name']) . "<br>" .
                                                                htmlspecialchars($schedule['course_description']);
                                                        }
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

<?php
include_once "../templates/footer.php";
?>