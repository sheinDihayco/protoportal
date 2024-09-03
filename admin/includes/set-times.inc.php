<?php
include_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $time_id = $_POST['time_id'] ?? null;
    $start_time = trim($_POST['start_time']);
    $end_time = trim($_POST['end_time']);

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Prepare the check query based on whether $time_id is set or not
        if ($time_id) {
            // Update existing time slot
            $checkStmt = $conn->prepare("SELECT * FROM tbl_sched_time WHERE start_time = ? AND end_time = ? AND time_id != ?");
            $checkStmt->execute([$start_time, $end_time, $time_id]);
        } else {
            // Insert new time slot
            $checkStmt = $conn->prepare("SELECT * FROM tbl_sched_time WHERE start_time = ? AND end_time = ?");
            $checkStmt->execute([$start_time, $end_time]);
        }

        // Log the results for debugging
        error_log("Query: " . $checkStmt->queryString);
        error_log("Start Time: $start_time, End Time: $end_time");
        error_log("Row Count: " . $checkStmt->rowCount());

        if ($checkStmt->rowCount() > 0) {
            $response = ['status' => 'error', 'message' => 'Duplicate time slot detected.'];
        } else {
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
        }

        // Commit transaction
        $conn->commit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();
        $response = ['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request.'];
}

$connection->close();

echo json_encode($response);
