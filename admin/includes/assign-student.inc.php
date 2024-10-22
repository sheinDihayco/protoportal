<?php
session_start();
header('Content-Type: application/json');

include_once "connect.php";
include_once "connection.php";

$response = ['status' => 'error', 'message' => ''];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignStudents'])) {
    $instructor_id = $_POST['instructor_id'];
    $student_ids = isset($_POST['student_ids']) ? $_POST['student_ids'] : [];
    $subject_id = isset($_POST['subject_id']) ? $_POST['subject_id'] : null;

    $database = new Connection();
    $db = $database->open();

    try {
        // Begin transaction
        $db->beginTransaction();

        // Insert new student assignments, preventing duplicate entries
        $sql = "INSERT INTO tbl_student_instructors (student_id, instructor_id, subject_id) 
                VALUES (:student_id, :instructor_id, :subject_id)
                ON DUPLICATE KEY UPDATE subject_id = :subject_id";
        $stmt = $db->prepare($sql);

        foreach ($student_ids as $student_id) {
            // Execute the query for each student
            $stmt->execute([
                ':student_id' => $student_id,
                ':instructor_id' => $instructor_id,
                ':subject_id' => $subject_id,
            ]);
        }

        // Commit transaction
        $db->commit();

        // Set session variable for success message
        $_SESSION['class_assigned'] = true;

        // Redirect to the success page
        header('Location: ../assign-student-instructors.php');
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $db->rollBack();
        $response['message'] = 'Error: ' . $e->getMessage();

        // Set session variable for failure message
        $_SESSION['class_not_assigned'] = true;
        header('Location: ../assign-student-instructors.php');
        exit();
    }

    $database->close();
}

// Return the response as JSON
echo json_encode($response);

?>
