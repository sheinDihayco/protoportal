<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooldb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize input
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $subject_id = $conn->real_escape_string($_POST['subject_id']);

    // Delete the assigned student record from tbl_student_instructors for the specific subject
    $sql = "DELETE FROM tbl_student_instructors WHERE student_id = '$user_id' AND subject_id = '$subject_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['delete_success'] = true; // Set session variable for SweetAlert
        header("Location: ../studentRecords.php");
        exit();
    } else {
        $_SESSION['delete_error'] = "Error deleting record: " . $conn->error;
        header("Location: ../studentRecords.php");
        exit();
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
