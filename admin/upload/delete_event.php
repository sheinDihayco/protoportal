<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/connection.php";

// Check if form was submitted using POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['event_id'])) {
        $eventId = $_POST['event_id'];

        $connection = new Connection();
        $pdo = $connection->open();

        // Prepare and execute delete statement
        $sql = "DELETE FROM tbl_events WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $eventId]);

        $connection->close();

        // Redirect with a success parameter
        header("Location: ../event2.php?deleted=true");
        exit();
    } else {
        // Redirect with failure parameter
        header("Location: ../event2.php?deleted=false");
        exit();
    }
} else {
    // Redirect with failure parameter
    header("Location: ../event2.php?deleted=false");
    exit();
}
