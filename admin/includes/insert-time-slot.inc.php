<?php
include_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_id = $_POST['time_id'] ?? null;
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    try {
        if ($time_id) {
            // Update existing time slot
            $stmt = $conn->prepare("UPDATE tbl_sched_time SET start_time = ?, end_time = ? WHERE time_id = ?");
            $stmt->execute([$start_time, $end_time, $time_id]);
            $response = ['status' => 'success', 'message' => 'Time slot updated successfully.'];
        } else {
            // Insert new time slot
            $stmt = $conn->prepare("INSERT INTO tbl_sched_time (start_time, end_time) VALUES (?, ?)");
            $stmt->execute([$start_time, $end_time]);
            $response = ['status' => 'success', 'message' => 'Time slot added successfully.'];
        }
    } catch (PDOException $e) {
        $response = ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request.'];
}

$connection->close();

echo json_encode($response);
