<?php
include("../includes/connect.php");
include("../includes/connection.php");

session_start();

if (isset($_POST['register'])) {
    $database = new Connection();
    $db = $database->open();

    // Retrieve the data from the form
    $user_id = $_POST['user_id'] ?? null;
    $instructor_id = $_POST['instructor_id'];
    $id = $_POST['subject'] ?? null;
    $year = $_POST['year'] ?? null;
    $semester = $_POST['semester'] ?? null;
    $sy = $_POST['sy'] ?? null;
    $term = $_POST['term'] ?? null;
    $grade = $_POST['grade'] ?? null;

    // Ensure none of the required fields are missing
    if ($user_id && $instructor_id && $id && $year && $semester && $sy && $term && $grade) {
        // Prepare and execute the insert query
        try {
            $sql = "INSERT INTO tbl_grades (user_id, instructor_id, year, semester, sy , term, grade, id) VALUES (:user_id, :instructor_id, :year, :semester, :sy,  :term, :grade, :id)";
            $stmt = $db->prepare($sql); 

            // Bind the parameters
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
            $stmt->bindParam(':sy', $sy, PDO::PARAM_STR);
            $stmt->bindParam(':term', $term, PDO::PARAM_STR);
            $stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                $_SESSION['grade_created'] = true;
                header("Location: ../studentRecords.php"); // Redirect to display SweetAlert
                exit();
            } else {
                $_SESSION['grade_error'] = 'Failed to add grade';
                header("Location: ../studentRecords.php"); // Redirect to display SweetAlert
                exit();
            }
        } catch (PDOException $e) {
            $_SESSION['grade_error'] = 'There was an error: ' . $e->getMessage();
            header("Location: ../studentRecords.php"); // Redirect to display SweetAlert
            exit();
        }
    } else {
        $_SESSION['grade_error'] = 'Please fill in all required fields.';
        header("Location: ../studentRecords.php"); // Redirect to display SweetAlert
        exit();
    }

    $database->close();
}
