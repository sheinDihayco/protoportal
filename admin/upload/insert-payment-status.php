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
    $semester = $conn->real_escape_string($_POST['semester']);

    // Check if studentID exists in tbl_students
    $checkStudentQuery = "SELECT studentID FROM tbl_students WHERE studentID = ?";
    $stmt = $conn->prepare($checkStudentQuery);
    $stmt->bind_param("s", $studentID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check if studentID already exists in tbl_payments
        $checkPaymentQuery = "SELECT studentID FROM tbl_payments WHERE studentID = ?";
        $stmt = $conn->prepare($checkPaymentQuery);
        $stmt->bind_param("s", $studentID);
        $stmt->execute();
        $paymentResult = $stmt->get_result();

        if ($paymentResult->num_rows > 0) {
            // Student ID already exists in tbl_payments
            echo "Error: Payment record already exists for this student.";
        } else {
            // Prepare an insert statement
            $insertQuery = "INSERT INTO tbl_payments (studentID, payment_status,semester) VALUES (?, ?,?)";
            $stmt = $conn->prepare($insertQuery);
            $stmt->bind_param("sss", $studentID, $status, $semester);

            if ($stmt->execute()) {
                // Redirect to payment.php after successful insertion
                header("Location: ../payment.php?error=success");
                exit();
            } else {
                echo "Error: " . $insertQuery . "<br>" . $conn->error;
            }
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
