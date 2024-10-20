<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schooldb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $payment_id = $_POST['payment_id'];
    $user_id = $_POST['user_id'];
    $status = $_POST['payment_status'];
    $semester = $_POST['semester'];
    $paymentPeriod = $_POST['paymentPeriod'];

    $sql = "UPDATE tbl_payments SET semester = ?, paymentPeriod = ?, payment_status = ? WHERE payment_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssss",
            $semester,
            $paymentPeriod,
            $status,
            $payment_id
        );

        if ($stmt->execute()) {
            header("Location: ../student_profile.php?user_id=" . urlencode($user_id) . "&success=updated");
            exit();
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
