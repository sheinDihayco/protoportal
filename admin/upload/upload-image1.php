<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schooldb";

// Create connection using PDO
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
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

// Debugging: Check if $userid is set correctly
if (empty($userid)) {
    die("User ID is not set.");
}

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
            $sql = "UPDATE tbl_students SET user_image = :user_image WHERE user_id = :userid";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':user_image', $targetFile);
            $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header("Location: ../user-profile.php?error=success");
                exit;
            } else {
                echo "Failed to update database.";
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    } else {
        echo "Error uploading file: " . $file['error'];
    }
}

// Close the connection
$conn = null;
?>
