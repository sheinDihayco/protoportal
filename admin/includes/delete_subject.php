<?php
include_once "../includes/connect.php";

if (isset($_GET['id'])) {
    $subjectId = $_GET['id'];

    // Prepare the SQL statement to delete the subject
    $sql = "DELETE FROM tbl_subjects WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $subjectId, PDO::PARAM_INT);

    // Execute the statement and set session messages accordingly
    if ($stmt->execute()) {
        $_SESSION['subject_deleted'] = true;
    } else {
        $_SESSION['subject_deleted'] = false;
    }

    // Redirect to the subject page with a success message
    header("Location:../subject.php?error=delete-success");
    exit();
}
