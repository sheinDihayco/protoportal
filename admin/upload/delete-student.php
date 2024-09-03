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

    $user_id = $conn->real_escape_string($_POST['user_id']);

    // Delete record
    $sql = "DELETE FROM tbl_students WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['delete_success'] = true; // Set session variable for SweetAlert
        header("Location: ../user-student.php");
        exit();
    } else {
        $_SESSION['delete_error'] = "Error deleting record: " . $conn->error;
        header("Location: ../user-student.php");
        exit();
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
