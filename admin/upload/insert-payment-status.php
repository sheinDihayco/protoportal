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

    // Check if studentID exists in tbl_students
    $checkStudentQuery = "SELECT studentID FROM tbl_students WHERE studentID = '$studentID'";
    $result = $conn->query($checkStudentQuery);

    if ($result->num_rows > 0) {
        // Check if studentID already exists in tbl_payments
        $checkPaymentQuery = "SELECT studentID FROM tbl_payments WHERE studentID = '$studentID'";
        $paymentResult = $conn->query($checkPaymentQuery);

        if ($paymentResult->num_rows > 0) {
            // Student ID already exists in tbl_payments
            echo "Error: Payment record already exists for this student.";
        } else {
            // Prepare an insert statement
            $sql = "INSERT INTO tbl_payments (studentID, payment_status) VALUES ('$studentID', '$status')";

            if ($conn->query($sql) === TRUE) {
                header("location: ../stud_profile?error=success");
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        echo "Error: Student ID does not exist.";
    }

    // Close connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
