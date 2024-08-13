<?php
include_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_id = $_POST['time_id'] ?? null;

    if ($time_id) {
        try {
            // Check if the time slot is referenced in any table, e.g., tbl_schedule
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM tbl_schedule WHERE time_id = ?");
            $checkStmt->execute([$time_id]);
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                // Prevent deletion if time slot is referenced
                $response = ['status' => 'error', 'message' => 'Cannot delete time slot because it is referenced in a schedule.'];
            } else {
                // Proceed with deletion
                $stmt = $conn->prepare("DELETE FROM tbl_sched_time WHERE time_id = ?");
                $stmt->execute([$time_id]);
                $response = ['status' => 'success', 'message' => 'Time slot deleted successfully.'];
            }
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
