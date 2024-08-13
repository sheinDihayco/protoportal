<?php
include_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_id = $_POST['time_id'] ?? null;

    if ($time_id) {
        try {
            $stmt = $conn->prepare("DELETE FROM tbl_sched_time WHERE time_id = ?");
            $stmt->execute([$time_id]);
            $response = ['status' => 'success', 'message' => 'Time slot deleted successfully.'];
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Invalid request.'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request.'];
}

$connection->close();

echo json_encode($response);
