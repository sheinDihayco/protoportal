<?php
require_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

try {
    // Example: update to use correct column names
    $stmt = $conn->prepare("SELECT * FROM tbl_rooms ORDER BY room_name"); // Replace with the correct column
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$connection->close();
?>
