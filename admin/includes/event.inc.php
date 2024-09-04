<?php

session_start();
include_once 'connection.php';

function sanitizeInput($data)
{
    return htmlspecialchars(strip_tags(trim($data)), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitizeInput($_POST['eventTitle']);
    $date = sanitizeInput($_POST['eventDate']);
    $description = sanitizeInput($_POST['eventDescription']);

    $connection = new Connection();
    $pdo = $connection->open();

    // Check if an event with the same title (case insensitive) already exists
    $sql = "SELECT COUNT(*) FROM tbl_events WHERE LOWER(title) = LOWER(:title)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['title' => $title]);
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        // Event with the same title already exists
        header('Location: ../event.php?error=Event with this title already exists');
        exit();
    } else {
        // Insert the new event
        $sql = "INSERT INTO tbl_events (title, date, description) VALUES (:title, :date, :description)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['title' => $title, 'date' => $date, 'description' => $description]);

        $connection->close();
        $_SESSION['event_created'] = true;
        header('Location: ../event2.php');
        exit();
    }
}
