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
    $middleInitial = $conn->real_escape_string($_POST['middleInitial']);
    $contact = $conn->real_escape_string($_POST['contact']);
    $studentID = $conn->real_escape_string($_POST['studentID']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);

    // SQL insert statement
    $sql = "INSERT INTO tbl_student_records (fname, lname, middleInitial , contact,studentID, course, year)
    VALUES ('$fname', '$lname', '$middleInitial', '$contact', '$studentID', '$course', '$year')";

    if ($conn->query($sql) === TRUE) {
        header("location: ../studentRecords1.php?error=success");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
