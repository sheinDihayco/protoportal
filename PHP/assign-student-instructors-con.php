<?php
ob_start(); // Start output buffering

include_once "../templates/header.php";
include_once "includes/connect.php";
include_once "includes/connection.php";

$instructor_id = $_GET['instructor_id'] ?? '';
$course = $_GET['course'] ?? '';
$year = $_GET['year'] ?? 'all';
$semester = $_GET['semester'] ?? 'all';

$years = ['1' => 'First Year', '2' => 'Second Year', '3' => 'Third Year', '4' => 'Fourth Year' , '11' => 'Grade 11' , '12' => "Grade 12"]; // Initialize $years array
$semesters = ['1' => '1st Semester', '2' => '2nd Semester']; // Initialize $semesters array

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignStudents'])) {
    $instructor_id = $_POST['instructor_id']; // The user_id of the instructor
    $student_ids = isset($_POST['student_ids']) ? $_POST['student_ids'] : []; // Array of student_ids

    $database = new Connection();
    $db = $database->open();

    try {
        // Begin transaction
        $db->beginTransaction();

        // Insert new student assignments, if not already assigned
        $sql_check = "SELECT COUNT(*) FROM tbl_student_instructors WHERE student_id = :student_id AND instructor_id = :instructor_id";
        $sql_insert = "INSERT INTO tbl_student_instructors (student_id, instructor_id) VALUES (:student_id, :instructor_id)";
        $stmt_check = $db->prepare($sql_check);
        $stmt_insert = $db->prepare($sql_insert);

        foreach ($student_ids as $student_id) {
            // Check if student is already assigned
            $stmt_check->execute([':student_id' => $student_id, ':instructor_id' => $instructor_id]);
            $already_assigned = $stmt_check->fetchColumn();

            if (!$already_assigned) {
                // Insert new record
                $stmt_insert->execute([':student_id' => $student_id, ':instructor_id' => $instructor_id]);
            }
        }

        // Commit transaction
        $db->commit();

        // Show SweetAlert and redirect on success
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Students have been successfully assigned.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../admin/assign-student-instructors.php';
                }
            });
        </script>";
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $db->rollBack();
        echo "There was an error: " . $e->getMessage();
    }

    $database->close();
}
?>
