<?php
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

    header("Location: ../event.php?error=delete-success");
    exit();
} else {
    header("Location: ../event.php?error=not-deleted");
    exit();
}
