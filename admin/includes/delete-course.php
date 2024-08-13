<?php
include_once 'connection.php';

$response = array();

if (isset($_POST['course_id'])) {
    $course_id = intval($_POST['course_id']);

    // Initialize database connection
    $connection = new Connection();
    $conn = $connection->open();

    try {
        $stmt = $conn->prepare("DELETE FROM tbl_course WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();

        $response['status'] = 'success';
        $response['message'] = 'Course deleted successfully';
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = "Error: " . $e->getMessage();
    }

    $connection->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'No course ID provided';
}

echo json_encode($response);
