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

    $user_id = $conn->real_escape_string($_POST['user_id']);

    // Delete record
    $sql = "DELETE FROM tbl_students WHERE user_id = '$user_id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../user-student.php?error=delete-success");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
