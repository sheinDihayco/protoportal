<?php
include_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'] ?? null;

    if ($room_id) {
        try {
            // Check if the room is referenced in any table, e.g., tbl_schedule
            $checkStmt = $conn->prepare("SELECT COUNT(*) FROM tbl_schedule WHERE room_id = ?");
            $checkStmt->execute([$room_id]);
            $count = $checkStmt->fetchColumn();

            if ($count > 0) {
                // Prevent deletion if room is referenced
                $response = ['status' => 'error', 'message' => 'Cannot delete room because it is referenced in a schedule.'];
            } else {
                // Proceed with deletion
                $stmt = $conn->prepare("DELETE FROM tbl_rooms WHERE room_id = ?");
                $stmt->execute([$room_id]);
                $response = ['status' => 'success', 'message' => 'Room deleted successfully.'];
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
