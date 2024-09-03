<?php
session_start(); // Ensure you start the session

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
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $status = $conn->real_escape_string($_POST['payment_status']);
    $semester = $conn->real_escape_string($_POST['semester']);
    $paymentPeriod = $conn->real_escape_string($_POST['paymentPeriod']);

    // Check if user_id exists in tbl_students
    $checkStudentQuery = "SELECT user_id FROM tbl_students WHERE user_id = ?";
    $stmt = $conn->prepare($checkStudentQuery);
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Prepare an insert statement
        $insertQuery = "INSERT INTO tbl_payments (user_id, payment_status, semester, paymentPeriod) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ssss", $user_id, $status, $semester, $paymentPeriod);

        if ($stmt->execute()) {
            // Set session variable for the user_id
            $_SESSION['stud'] = $user_id;
            // Redirect to student_profile.php with user_id parameter
            header("Location: ../student_profile.php?user_id=" . urlencode($user_id) . "&success=created");
            exit();
        } else {
            echo "Error: " . $insertQuery . "<br>" . $conn->error;
        }
    } else {
        echo "Error: Student ID does not exist.";
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
