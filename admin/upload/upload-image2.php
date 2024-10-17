<?php
// Database connection
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

// Start session to access user login data
session_start();

// Check if user is logged in
if (!isset($_SESSION['login'])) {
    header("Location: ../login.php?error=loginfirst");
    exit;
}

// Get logged-in user's ID from session
$userid = $_SESSION['login'];

// Handle file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];

    // Check if file is uploaded without errors
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $targetDir = "../admin/upload/upload-files/";
        $targetFile = $targetDir . $fileName;

        // Ensure the target directory exists
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Save the file path in the database
            $sql = "UPDATE tbl_users SET user_image = ? WHERE user_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $targetFile, $userid);

            if ($stmt->execute()) {
                $_SESSION['profile_updated'] = true;
                header("Location: ../user-profile-instructor.php?error=success");
                exit;
            } else {
                echo "Failed to update database.";
            }

            $stmt->close();
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Error uploading file: " . $file['error'];
    }
}

$conn->close();
?>