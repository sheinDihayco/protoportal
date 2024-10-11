<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooldb";

    // Create connection using mysqli
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Escape the user input for security
    $user_id = $conn->real_escape_string($_POST['user_id']);

    // SQL to delete the student record
    $sql = "DELETE FROM tbl_students WHERE user_id = '$user_id'";

    // Execute the SQL query
    if ($conn->query($sql) === TRUE) {
        // Set session variable to indicate success for SweetAlert
        $_SESSION['delete_success'] = true;
        header("Location: ../user-student.php"); // Redirect to user-student.php
        exit();
    } else {
        // Set session variable to indicate an error for SweetAlert
        $_SESSION['delete_error'] = "Error deleting record: " . $conn->error;
        header("Location: ../user-student.php"); // Redirect to user-student.php
        exit();
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
