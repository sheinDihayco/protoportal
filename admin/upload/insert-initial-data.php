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
    $studentID = $conn->real_escape_string($_POST['studentID']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);

    // Check if studentID already exists
    $checkQuery = "SELECT studentID FROM tbl_students WHERE studentID = '$studentID'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Student ID already exists, perform update
        $updateQuery = "UPDATE tbl_students 
                        SET fname = '$fname', lname = '$lname', course = '$course', year = '$year'
                        WHERE studentID = '$studentID' AND user_id = '$user_id'";

        if ($conn->query($updateQuery) === TRUE) {
            $_SESSION['initial_update'] = "Record updated successfully.";
        } else {
            $_SESSION['initial_update_error'] = "Error updating record: " . $conn->error;
        }
    } else {
        // Student ID does not exist, perform insert
        $insertQuery = "INSERT INTO tbl_students (user_id, fname, lname, studentID, course, year)
                        VALUES ('$user_id', '$fname', '$lname', '$studentID', '$course', '$year')";

        if ($conn->query($insertQuery) === TRUE) {
            $_SESSION['initial_update'] = "Record inserted successfully.";
        } else {
            $_SESSION['initial_update_error'] = "Error inserting record: " . $conn->error;
        }
    }

    // Redirect based on the result of the operation
    if (isset($_SESSION['initial_update'])) {
        header("Location: ../payment.php?register=success");
    } else {
        header("Location: ../admin/insert-initial-data.php");
    }

    // Close connection
    $conn->close();
}
