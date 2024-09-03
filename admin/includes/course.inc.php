<?php
include_once 'connection.php';
session_start();  // Start the session to use $_SESSION

$response = array();

if (isset($_POST['course_description']) && isset($_POST['course_year'])) {
    $course_description = $_POST['course_description'];
    $course_year = intval($_POST['course_year']);

    // Initialize database connection
    $connection = new Connection();
    $conn = $connection->open();

    try {
        // Check if course with the same description and year already exists
        $stmt = $conn->prepare("SELECT * FROM tbl_course WHERE course_description = :course_description AND course_year = :course_year");
        $stmt->bindParam(':course_description', $course_description);
        $stmt->bindParam(':course_year', $course_year);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $response['status'] = 'error';
            $response['message'] = 'Course already exists';
            echo json_encode($response);
            $connection->close();
            exit();
        }

        // Insert new course
        $stmt = $conn->prepare("INSERT INTO tbl_course (course_description, course_year) VALUES (:course_description, :course_year)");
        $stmt->bindParam(':course_description', $course_description);
        $stmt->bindParam(':course_year', $course_year);
        $stmt->execute();

        // Set session variable to indicate successful creation
        $_SESSION['course_created'] = true;

        $response['status'] = 'success';
        $response['message'] = 'Course added successfully';
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
