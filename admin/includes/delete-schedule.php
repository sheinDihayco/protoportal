<?php
include_once 'connection.php';

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedule_id = $_POST['schedule_id'];

    $query = "DELETE FROM tbl_schedule WHERE schedule_id = :schedule_id";

    $stmt = $conn->prepare($query);
    $stmt->execute([':schedule_id' => $schedule_id]);

    echo 'Success';
}
