<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Database connection details
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
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $studentID = $conn->real_escape_string($_POST['studentID']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);
    $contact = $conn->real_escape_string($_POST['contact']);

    // Check if studentID already exists
    $checkQuery = "SELECT studentID FROM tbl_students WHERE studentID = '$studentID'";
    $result = $conn->query($checkQuery);

    if ($result->num_rows > 0) {
        // Student ID already exists
        echo "Error: A record with the student ID $studentID already exists.";
    } else {
        // SQL insert statement
        $sql = "INSERT INTO tbl_students (fname, lname, studentID, course, year, contact)
                VALUES ('$fname', '$lname', '$studentID', '$course', '$year', '$contact')";

        if ($conn->query($sql) === TRUE) {
            echo "Record inserted successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Close connection
    $conn->close();
}
