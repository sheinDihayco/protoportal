<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schooldb";

// Create a new connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Start the session to get the user ID
session_start();
if (!isset($_SESSION["login"])) {
    header("location:login.php?error=loginfirst");
    exit;
}

$userid = $_SESSION["login"];

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Retrieve form data
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $renewPassword = $_POST['renewPassword'];

    // Validate form data
    if (empty($currentPassword) || empty($newPassword) || empty($renewPassword)) {
        die("All fields are required.");
    }

    if ($newPassword !== $renewPassword) {
        die("New passwords do not match.");
    }

    // Fetch the current password hash from the database
    $sql = "SELECT user_pass FROM tbl_users WHERE user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $userid);

        if ($stmt->execute()) {
            $stmt->bind_result($hashedPassword);
            $stmt->fetch();
            $stmt->close();

            // Verify the current password
            if (password_verify($currentPassword, $hashedPassword)) {
                // Hash the new password
                $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $updateSql = "UPDATE tbl_users SET user_pass = ? WHERE user_id = ?";

                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("ss", $newHashedPassword, $userid);

                    if ($updateStmt->execute()) {
                        $_SESSION['change-pass'] = true;
                        header("Location: ../payment1.php?changepass=success");
                        exit();
                    } else {
                        echo "Error updating password: " . $updateStmt->error;
                    }

                    $updateStmt->close();
                } else {
                    echo "Error preparing update statement: " . $conn->error;
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "Error executing statement: " . $stmt->error;
        }
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
