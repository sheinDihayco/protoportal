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

    $studentID = $_POST['studentID'];
    $status = $_POST['payment_status'];
    $semester = $_POST['semester'];
    $paymentPeriod = $_POST['paymentPeriod'];

    $sql = "UPDATE tbl_payments SET semester = ?, paymentPeriod = ?, payment_status = ? WHERE studentID = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssss",
            $semester,
            $paymentPeriod,
            $status,
            $studentID

        );

        if ($stmt->execute()) {
            header("Location: ../payment.php?error=update-success");
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
