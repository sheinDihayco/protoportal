<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
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

    // Collect and sanitize form data
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);
    $semester = $conn->real_escape_string($_POST['semester']);
    $status = $conn->real_escape_string($_POST['status']);

    // Check if user_id already exists
    $checkQuery = "SELECT user_id FROM tbl_students WHERE user_id = '$user_id'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Student ID already exists, perform update
        $updateQuery = "UPDATE tbl_students 
                        SET fname = '$fname', lname = '$lname', course = '$course', year = '$year', status = '$status', semester = '$semester'
                        WHERE user_id = '$user_id'";

        if ($conn->query($updateQuery) === TRUE) {
            $_SESSION['initial_update'] = "Record updated successfully.";
        } else {
            $_SESSION['initial_update_error'] = "Error updating record: " . $conn->error;
        }
    } else {
        // Student ID does not exist, perform insert
        $insertQuery = "INSERT INTO tbl_students (user_id, fname, lname, course, year, semster, status)
                        VALUES ('$user_id', '$fname', '$lname', '$course', '$year', '$semester', '$status')";

        if ($conn->query($insertQuery) === TRUE) {
            $_SESSION['initial_update'] = "Record inserted successfully.";
        } else {
            $_SESSION['initial_update_error'] = "Error inserting record: " . $conn->error;
        }
    }

    // Redirect based on the result of the operation
    if (isset($_SESSION['initial_update'])) {
        header("Location: ../user-student.php?register=success");
    } else {
        header("Location: ../admin/insert-initial-data.php");
    }

    // Close connection
    $conn->close();
}
