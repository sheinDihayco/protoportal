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
    // Collect value of each input field
    $studentID = $_POST['studentID'];
    $status = $_POST['payment_status'];

    // Prepare an update statement
    $sql = "UPDATE tbl_payments SET payment_status = ? WHERE studentID = ?";

    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ss", // Both parameters are strings
            $status, // First parameter
            $studentID // Second parameter
        );

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../payment.php?error=update-success");
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
