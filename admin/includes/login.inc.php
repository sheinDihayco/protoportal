<?php
include_once '../includes/connection.php'; 
session_start(); // Start session

// Create a new instance of the Connection class
$database = new Connection();
$conn = $database->open(); // Open the connection

if (isset($_POST["login"])) {
    $identifier = trim($_POST["identifier"]); // User input (username or student ID)
    $pass = trim($_POST["password"]); // User input (password)
    $remember = isset($_POST["remember"]); // Remember me checkbox

    // Check if the user exists in tbl_users (for admins and teachers)
    $statement = $conn->prepare("SELECT * FROM tbl_users WHERE user_name = :identifier");
    $statement->bindParam(':identifier', $identifier);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // If not found in tbl_users, check in tbl_students (for students)
    if (!$user) {
        $statement = $conn->prepare("SELECT * FROM tbl_students WHERE user_name = :identifier");
        $statement->bindParam(':identifier', $identifier);
        $statement->execute();
        $student = $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Either user or student found
    if ($user || $student) {
        $account = $user ? $user : $student;
        $password = $account["user_pass"];
        $checkpass = password_verify($pass, $password); // Use password_verify for hashed passwords

        // Check if password matches
        if ($checkpass === false) {
            header("location:../login.php?error=wrongpass");
            exit;
        } else {
            // Set up the session variables
            $_SESSION['login'] = $account["user_id"];
            $_SESSION['role'] = $account["user_role"];
            $_SESSION['success'] = true;
            $_SESSION['user_id'] = $account["user_id"];

            // Set cookies for "remember me" functionality if checked
            if ($remember) {
                setcookie("rememberedIdentifier", $identifier, time() + (86400 * 30), "/"); // 30-day cookie
                setcookie("rememberedPassword", $pass, time() + (86400 * 30), "/"); // Storing the raw password is not recommended for security reasons, you may hash it
            } else {
                // Unset cookies if "remember me" is not selected
                setcookie("rememberedIdentifier", "", time() - 3600, "/");
                setcookie("rememberedPassword", "", time() - 3600, "/");
            }

            // Redirect based on user role
            switch ($account["user_role"]) {
                case "admin":
                    header("location:../index.php");
                    break;
                case "teacher":
                    header("location:../index2.php");
                    break;
                case "student":
                    header("location:../index3.php");
                    break;
                default:
                    header("location:../login.php?error=unknownrole");
                    break;
            }
            exit;
        }
    } else {
        // If no user or student was found
        header("location:../login.php?error=nouser");
        exit;
    }
}

// Close the connection after the operations
$database->close();
?>
