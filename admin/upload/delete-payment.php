<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $payment_id = $conn->real_escape_string($_POST['payment_id']);

    // Delete record
    $sql = "DELETE FROM tbl_payments WHERE payment_id = '$payment_id'";

    if ($conn->query($sql) === TRUE) {
        // Return success response
        echo json_encode(['status' => 'success']);
    } else {
        // Return error response
        echo json_encode(['status' => 'error', 'message' => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
