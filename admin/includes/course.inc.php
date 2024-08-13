<?php
include_once 'connection.php';

$response = array();

if (isset($_POST['course_description']) && isset($_POST['course_year'])) {
    $course_id = isset($_POST['course_id']) ? intval($_POST['course_id']) : null;
    $course_description = $_POST['course_description'];
    $course_year = intval($_POST['course_year']);

    // Initialize database connection
    $connection = new Connection();
    $conn = $connection->open();

    try {
        if ($course_id) {
            // Update existing course
            $stmt = $conn->prepare("UPDATE tbl_course SET course_description = :course_description, course_year = :course_year WHERE course_id = :course_id");
            $stmt->bindParam(':course_id', $course_id, PDO::PARAM_INT);
        } else {
            // Insert new course
            $stmt = $conn->prepare("INSERT INTO tbl_course (course_description, course_year) VALUES (:course_description, :course_year)");
        }

        $stmt->bindParam(':course_description', $course_description);
        $stmt->bindParam(':course_year', $course_year);
        $stmt->execute();

        $response['status'] = 'success';
        $response['message'] = $course_id ? 'Course updated successfully' : 'Course added successfully';
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
