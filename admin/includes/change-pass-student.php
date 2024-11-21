<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schooldb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed."]));
}

session_start();
if (!isset($_SESSION["login"])) {
    header("location:login.php?error=loginfirst");
    exit;
}

$userid = $_SESSION["login"];

// Ensure the user is a student
$roleSql = "SELECT user_role FROM tbl_students WHERE user_id = ?";
if ($roleStmt = $conn->prepare($roleSql)) {
    $roleStmt->bind_param("s", $userid);

    if ($roleStmt->execute()) {
        $roleStmt->bind_result($userRole);
        $roleStmt->fetch();
        $roleStmt->close();

        if ($userRole !== 'student') {
            die(json_encode(["status" => "error", "message" => "Unauthorized access."]));
        }
    } else {
        die(json_encode(["status" => "error", "message" => "Error fetching user role."]));
    }
} else {
    die(json_encode(["status" => "error", "message" => "Error preparing role statement."]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    header('Content-Type: application/json');

    $currentPassword = trim($_POST['currentPassword']);
    $newPassword = trim($_POST['newPassword']);
    $renewPassword = trim($_POST['renewPassword']);

    // Validate input fields
    if (empty($currentPassword) || empty($newPassword) || empty($renewPassword)) {
        echo json_encode(["status" => "error", "message" => "All fields are required."]);
        exit;
    }

    if ($newPassword !== $renewPassword) {
        echo json_encode(["status" => "error", "message" => "New passwords do not match."]);
        exit;
    }

    // Fetch the current hashed password
    $passwordSql = "SELECT user_pass FROM tbl_students WHERE user_id = ?";
    if ($stmt = $conn->prepare($passwordSql)) {
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
                $updateSql = "UPDATE tbl_students SET user_pass = ? WHERE user_id = ?";
                if ($updateStmt = $conn->prepare($updateSql)) {
                    $updateStmt->bind_param("ss", $newHashedPassword, $userid);

                    if ($updateStmt->execute()) {
                        $_SESSION['change_password'] = true;
                        header("Location: ../account-settings.php?changepass=success");
                        echo json_encode(["status" => "success", "message" => "Password updated successfully."]);
                        exit;
                    } else {
                        $_SESSION['change_password'] = true;
                        header("Location: ../account-settings.php?changepass=success");
                        echo json_encode(["status" => "error", "message" => "Error updating password."]);
                        exit;
                    }

                    $updateStmt->close();
                } else {
                    echo json_encode(["status" => "error", "message" => "Error preparing update statement."]);
                    exit;
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Current password is incorrect."]);
                exit;
            }
        } else {
            echo json_encode(["status" => "error", "message" => "Error executing statement."]);
            exit;
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing statement."]);
        exit;
    }

    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
    exit;
}
?>
