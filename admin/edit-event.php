<?php
ob_start(); // Start output buffering

include_once "../templates/header.php";
include_once 'includes/connection.php';

$connection = new Connection();
$pdo = $connection->open();

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    // Fetch the event details
    $sql = "SELECT * FROM tbl_events WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        echo "Event not found.";
        exit();
    }

    // Handle the form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['eventTitle'];
        $date = $_POST['eventDate'];
        $description = $_POST['eventDescription'];

        $updateSql = "UPDATE tbl_events SET title = :title, date = :date, description = :description WHERE id = :id";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([
            'title' => $title,
            'date' => $date,
            'description' => $description,
            'id' => $eventId
        ]);

        header("Location: ../admin/event.php?error=success");
        exit();
    }
} else {
    exit();
}

$connection->close();

ob_end_flush(); // End output buffering and flush the output
?>
<main id="main" class="main">
    <section class="section calendar"><!-- HTML Form to Edit Event -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Edit Event</h5>
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="eventTitle" name="eventTitle" value="<?php echo htmlspecialchars($event['title']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDate" class="form-label">Event Date</label>
                        <input type="date" class="form-control" id="eventDate" name="eventDate" value="<?php echo htmlspecialchars($event['date']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Event Description</label>
                        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="5" required><?php echo htmlspecialchars($event['description']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-sm btn-success">Save</button>
                    <button type="button" class="btn btn-sm btn-danger"><a href="../admin/event.php" style="text-decoration: none; color:white">Cancel</a></button>
                </form>
            </div>
        </div>
    </section>
</main>