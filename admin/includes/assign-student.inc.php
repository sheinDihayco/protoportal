<?php
header('Content-Type: application/json');

include_once "connect.php";
include_once "connection.php";

$response = ['status' => 'error', 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignStudents'])) {
    $instructor_id = $_POST['instructor_id']; // The user_id of the instructor
    $student_ids = isset($_POST['student_ids']) ? $_POST['student_ids'] : []; // Array of student_ids

    $database = new Connection();
    $db = $database->open();

    try {
        // Begin transaction
        $db->beginTransaction();

        // Delete existing student assignments for this instructor
        $sql = "DELETE FROM tbl_student_instructors WHERE instructor_id = :instructor_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
        $stmt->execute();

        // Insert new student assignments
        $sql = "INSERT INTO tbl_student_instructors (student_id, instructor_id) VALUES (:student_id, :instructor_id)";
        $stmt = $db->prepare($sql);
        foreach ($student_ids as $student_id) {
            $stmt->execute([
                ':student_id' => $student_id,
                ':instructor_id' => $instructor_id
            ]);
        }

        // Commit transaction
        $db->commit();

        // Set response status to success
        $response['status'] = 'success';
        $response['message'] = 'Students assigned successfully';
    } catch (PDOException $e) {
        // Rollback transaction on error
        $db->rollBack();
        $response['message'] = 'Error: ' . $e->getMessage();
    }

    $database->close();
}

// Return the response as JSON
echo json_encode($response);
