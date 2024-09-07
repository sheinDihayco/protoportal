<?php

include("../includes/connect.php");
include("../includes/connection.php");

session_start(); // Ensure session is started for using $_SESSION

$connection = new Connection();
$pdo = $connection->open();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['eventId'])) {
        $eventId = $_POST['eventId'];

        // Sanitize and validate input
        $title = htmlspecialchars($_POST['eventTitle']);
        $startDate = htmlspecialchars($_POST['eventStartDate']);
        $endDate = htmlspecialchars($_POST['eventEndDate']);
        $description = htmlspecialchars($_POST['eventDescription']);

        // Ensure the dates are not empty and properly formatted
        if (empty($startDate) || empty($endDate)) {
            echo "Start date or end date cannot be empty.";
            exit();
        }

        // Update the event
        $updateSql = "UPDATE tbl_events SET title = :title, start_date = :start_date, end_date = :end_date, description = :description WHERE id = :id";
        $stmt = $pdo->prepare($updateSql);
        $stmt->execute([
            'title' => $title,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'description' => $description,
            'id' => $eventId
        ]);

        // Check for errors
        if ($stmt->errorCode() != '00000') {
            echo "Error updating event: " . implode(", ", $stmt->errorInfo());
            exit();
        }

        // Set success session variable and redirect
        $_SESSION['event_edited'] = true;
        header("Location: ../event2.php");
        exit();
    } else {
        echo "Event ID is missing.";
        exit();
    }
} elseif (isset($_GET['id'])) {
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
} else {
    echo "No event ID provided.";
    exit();
}

$connection->close();
