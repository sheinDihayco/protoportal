<?php
include_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

$response = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'] ?? null;

    if ($room_id) {
        try {
            $stmt = $conn->prepare("DELETE FROM tbl_rooms WHERE room_id = ?");
            $stmt->execute([$room_id]);
            $response = ['status' => 'success', 'message' => 'Room deleted successfully.'];
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
