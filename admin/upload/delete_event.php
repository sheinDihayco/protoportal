<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/connection.php";

if (isset($_GET['id'])) {
    $eventId = $_GET['id'];

    $connection = new Connection();
    $pdo = $connection->open();

    $sql = "DELETE FROM tbl_events WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id' => $eventId]);

    $connection->close();

    $_SESSION['event_deleted'] = true;
    header("Location: ../event2.php");
    exit();
} else {
    $_SESSION['event_not_deleted'] = true;
    header("Location: ../event2.php");
    exit();
}
