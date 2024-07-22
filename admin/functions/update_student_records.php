<?php

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input data
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $studentID = intval($_POST['studentID']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);
    $contact = $conn->real_escape_string($_POST['contact']);

    // Prepare an update statement
    $sql = "UPDATE tbl_student_records SET 
                fname = ?, 
                lname = ?, 
                course = ?, 
                year = ?,
                contact = ?
            WHERE studentID = ?";

    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters. All fields are strings except studentID, which is an integer.
        $stmt->bind_param(
            "sssssi",
            $fname,
            $lname,
            $course,
            $year,
            $contact,
            $studentID
        );

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../tbl_student_records.php?error=update-success");
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
