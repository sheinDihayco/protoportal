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
        // Student ID already exists
        $_SESSION['initial_update_error'] = "Error: A record with the student ID $studentID already exists.";
        header("Location: ../admin/insert-initial-data.php");
    } else {
        // SQL insert statement
        $sql = "INSERT INTO tbl_students (user_id, fname, lname, studentID, course, year)
                VALUES ('$user_id', '$fname', '$lname','$studentID', '$course', '$year')";

        if ($conn->query($sql) === TRUE) {
            $_SESSION['initial_update'] = true;
            header("location:../payment.php?register=success?register=success");
        } else {
            $_SESSION['initial_update_error'] = "Error: " . $sql . "<br>" . $conn->error;
            header("Location: ../admin/insert-initial-data.php");
        }
    }

    // Close connection
    $conn->close();
}
