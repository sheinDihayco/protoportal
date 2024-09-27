<?php
include_once 'includes/connection.php';

// Initialize database connection
$connection = new Connection();
$conn = $connection->open();

// Fetch initial data for courses
$courses = [];

try {
    $stmt = $conn->prepare("SELECT * FROM tbl_course ORDER BY course_description");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection->close();
?>