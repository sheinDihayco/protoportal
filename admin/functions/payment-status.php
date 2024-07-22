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
    $studentID = $conn->real_escape_string($_POST['studentID']);
    $status = $conn->real_escape_string($_POST['payment_status']);

    // Prepare an update statement
    $sql = "UPDATE tbl_payments SET payment_status = '$status' WHERE studentID = '$studentID'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../stud_profile.php?error=success");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
