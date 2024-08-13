<?php
include_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

$response = [];

try {
    $stmt = $conn->prepare("SELECT * FROM tbl_sched_time ORDER BY start_time, end_time");
    $stmt->execute();
    $timeSlots = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $response = ['status' => 'success', 'data' => $timeSlots];
} catch (PDOException $e) {
    $response = ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
}

$connection->close();

echo json_encode($response);
