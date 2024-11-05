<?php
include_once "../includes/connection.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $eventTitle = htmlspecialchars($_POST['eventTitle']);
    $eventStartDate = htmlspecialchars($_POST['eventStartDate']);
    $eventEndDate = htmlspecialchars($_POST['eventEndDate']);
    $eventDescription = htmlspecialchars($_POST['eventDescription']);

    $connection = new Connection();
    $pdo = $connection->open();

    $sql = "INSERT INTO tbl_events (title, start_date, end_date, description) VALUES (:title, :start_date, :end_date, :description)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'title' => $eventTitle,
        'start_date' => $eventStartDate,
        'end_date' => $eventEndDate,
        'description' => $eventDescription
    ]);

    $connection->close();

    // Set session variable for success
    $_SESSION['event_created'] = true;

    // Redirect to the page where the alert should be displayed
    header("Location: ../event.php");
    exit();
}
