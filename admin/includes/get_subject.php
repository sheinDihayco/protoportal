<?php
require_once 'connection.php';

$connection = new Connection();
$conn = $connection->open();

header('Content-Type: application/json'); // Ensure the content type is set to JSON

try {
    $stmt = $conn->prepare("SELECT * FROM tbl_subjects ORDER BY id"); // Retrieve all subjects
    $stmt->execute();
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $data]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

$connection->close();
