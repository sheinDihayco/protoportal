<?php
require_once 'connection.php';

// Initialize response array
$response = ['status' => 'error', 'message' => ''];

// Create a new instance of the Connection class
$connection = new Connection();

// Open the database connection
$conn = $connection->open();

// Prepare data for insertion or update
$room_id = isset($_POST['room_id']) ? $_POST['room_id'] : null;
$room_name = $_POST['room_name'];

try {
    // Check for duplicate rooms
    if ($room_id) {
        // Update existing room
        $checkStmt = $conn->prepare("SELECT * FROM tbl_rooms WHERE room_name = ? AND room_id != ?");
        $checkStmt->execute([$room_name, $room_id]);
    } else {
        // Insert new room
        $checkStmt = $conn->prepare("SELECT * FROM tbl_rooms WHERE room_name = ?");
        $checkStmt->execute([$room_name]);
    }

    if ($checkStmt->rowCount() > 0) {
        $response = ['status' => 'error', 'message' => 'Duplicate room name detected.'];
    } else {
        if ($room_id) {
            // Update existing room
            $stmt = $conn->prepare("UPDATE tbl_rooms SET room_name = :room_name WHERE room_id = :room_id");
            $stmt->bindParam(':room_name', $room_name);
            $stmt->bindParam(':room_id', $room_id);
        } else {
            // Insert new room
            $stmt = $conn->prepare("INSERT INTO tbl_rooms (room_name) VALUES (:room_name)");
            $stmt->bindParam(':room_name', $room_name);
        }
        $stmt->execute();
        $response['status'] = 'success';
        $response['message'] = 'Room saved successfully';
    }
} catch (PDOException $e) {
    $response['message'] = $e->getMessage();
}

// Close the connection
$connection->close();

// Return the response as JSON
echo json_encode($response);
?>
