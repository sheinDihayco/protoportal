<?php
include_once 'connection.php';

$response = array();

if (isset($_POST['course_id']) && isset($_POST['course_description']) && isset($_POST['course_year'])) {
    $course_id = intval($_POST['course_id']);
    $course_description = $_POST['course_description'];
    $course_year = intval($_POST['course_year']);

    // Initialize database connection
    $connection = new Connection();
    $conn = $connection->open();

    try {
        // Check if the course exists
        $stmt = $conn->prepare("SELECT * FROM tbl_course WHERE course_id = :course_id");
        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $response['status'] = 'error';
            $response['message'] = 'Course not found';
        } else {
            // Update existing course
            $stmt = $conn->prepare("UPDATE tbl_course SET course_description = :course_description, course_year = :course_year WHERE course_id = :course_id");
            $stmt->bindParam(':course_description', $course_description);
            $stmt->bindParam(':course_year', $course_year, PDO::PARAM_INT);
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
            $stmt->execute();

            $response['status'] = 'success';
            $response['message'] = 'Course updated successfully';
        }
    } catch (PDOException $e) {
        $response['status'] = 'error';
        $response['message'] = "Error: " . $e->getMessage();
    }

    $connection->close();
} else {
    $response['status'] = 'error';
    $response['message'] = 'Incomplete data';
}

echo json_encode($response);
