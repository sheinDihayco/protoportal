<?php
include_once "../templates/header2.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open();

$sql = "SELECT * FROM tbl_events ORDER BY date DESC";
$stmt = $pdo->query($sql);
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$today = date('Y-m-d');
$currentMonthStart = date('Y-m-01');
$currentMonthEnd = date('Y-m-t');
$todaysEvent = null;
$filteredEvents = [];
$filterTitle = '';
$showTodayEvent = true;

// Separate today's event and filter events within the current month
foreach ($events as $event) {
    if ($event['date'] === $today) {
        $todaysEvent = $event;
    }

    if ($event['date'] >= $currentMonthStart && $event['date'] <= $currentMonthEnd) {
        $filteredEvents[] = $event;
    }
}

// Filter events based on form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $filterTitle = isset($_POST['title']) ? $_POST['title'] : '';

    if ($filterTitle) {
        $filteredEvents = array_filter($filteredEvents, function ($event) use ($filterTitle) {
            return stripos($event['title'], $filterTitle) !== false;
        });
        $showTodayEvent = false;
    }
}

$connection->close();
?>
<main id="main" class="main">
    <section class="section dashboard">

        <section class="section dashboard">
            <div class="row">

                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Event <span class="badge bg-success" style="color: white;">Today's Event</span></h5>
                            <ul class="list-group">
                                <?php if ($showTodayEvent && $todaysEvent) : ?>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div style="flex-grow: 1;">
                                            <h6 class="card-title"><?php echo htmlspecialchars($todaysEvent['title']); ?></h6>
                                            <p><?php echo htmlspecialchars($todaysEvent['date']); ?></p>
                                            <p><?php echo htmlspecialchars($todaysEvent['description']); ?></p>
                                        </div>

                                    </li>
                                <?php else : ?>
                                    <li class="list-group-item">No events today.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"> Events <span class="badge bg-success" style="color: white;">This month</span></h5>
                            <ul class="list-group">
                                <?php if (!empty($filteredEvents)) : ?>
                                    <?php foreach ($filteredEvents as $event) : ?>
                                        <li class="list-group-item">
                                            <h6 class="card-title"><?php echo htmlspecialchars($event['title']); ?> <span>
                                                    <?php echo htmlspecialchars($event['date']); ?></span></h6>
                                        </li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li class="list-group-item">No events found for the current month.</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </section>

</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>