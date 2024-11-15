<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/schedule-students-con.php"; ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Schedule Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Schedule Records</li>
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
                                        <th scope="col">Schedule Details</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Loop through each day
                                    foreach ($daysOfWeek as $day):
                                        $hasEvent = false; // Flag to check if there is an event for this day
                                    ?>
                                        <tr class="day-header">
                                            <td colspan="2"><strong><?php echo htmlspecialchars($day); ?></strong></td>
                                        </tr>
                                        <?php
                                        // Loop through each time slot
                                        $startTime = strtotime('07:00');
                                        $endTime = strtotime('17:00');
                                        $timeInterval = 60 * 60; // 1-hour interval

                                        while ($startTime <= $endTime):
                                            $currentSlot = date('H:i', $startTime);
                                            $nextSlot = date('H:i', $startTime + $timeInterval);
                                            $hasSchedule = false; // Reset the flag for each time slot

                                            foreach ($schedules as $schedule) {
                                                if ($schedule['day_name'] === $day &&
                                                    $schedule['start_time'] >= $currentSlot &&
                                                    $schedule['start_time'] < $nextSlot) {
                                                    $hasSchedule = true;
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($currentSlot . ' - ' . $nextSlot); ?></td>
                                                        <td>
                                                            <div class="schedule-container">
                                                                <?php
                                                                    echo htmlspecialchars($schedule['instructor_name']) . "<br>" .
                                                                         "(" . htmlspecialchars($schedule['course_description']) . ") " . "<br>" .
                                                                         htmlspecialchars($schedule['subject_description']) . "<br>" .
                                                                         htmlspecialchars($schedule['room_name']);
                                                                ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                }
                                            }

                                            // If there is no schedule for this time slot, skip to the next time slot
                                            $startTime += $timeInterval; // Move to the next time slot
                                        endwhile;
                                    endforeach;
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

<style>
/* Base styles for the table */
.table.table-bordered.formal-schedule {
    width: 100%;
    font-size: 16px;
    text-align: center;
}

/* Responsive styles */
@media (max-width: 1200px) {
    .table.table-bordered.formal-schedule {
        font-size: 14px;
    }
}

@media (max-width: 992px) {
    .table.table-bordered.formal-schedule {
        font-size: 13px;
    }

    .table thead th,
    .table tbody td {
        padding: 8px;
    }
}

@media (max-width: 768px) {
    .table-responsive {
        overflow-x: auto;
    }

    /* Change layout for smaller screens */
    .table.table-bordered.formal-schedule {
        font-size: 12px;
        display: block;
    }

    /* Hide the time slots when no schedule is available */
    .day-header {
        display: table-row;
    }

    .table thead {
        display: none;
    }

    .table tbody,
    .table tbody tr,
    .table tbody td {
        display: block;
        width: 100%;
    }

    .table tbody td {
        text-align: left;
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    .table tbody td[data-label]::before {
        content: attr(data-label);
        font-weight: bold;
        display: inline-block;
        width: 40%;
        margin-right: 10px;
    }

    /* Only show time slots when there are schedules */
    .table tbody td {
        display: block;
        width: 100%;
    }
}

@media (max-width: 576px) {
    .pagetitle h1 {
        font-size: 1.5rem;
    }

    .breadcrumb-item a,
    .breadcrumb-item.active {
        font-size: 0.9rem;
    }
}
</style>
