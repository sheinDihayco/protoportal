<?php
include_once 'connection.php';

// Initialize database connection
$connection = new Connection();
$conn = $connection->open();

$response = array();

try {
    $stmt = $conn->prepare("SELECT * FROM tbl_course ORDER BY course_id");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $response['status'] = 'success';
    $response['data'] = $courses;
} catch (PDOException $e) {
    $response['status'] = 'error';
    $response['message'] = "Error: " . $e->getMessage();
}

$connection->close();
echo json_encode($response);
