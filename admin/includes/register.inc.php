<?php
include_once '../includes/connect.php';  // Use connect.php for $pdo connection
session_start(); // Start the session

if (!isset($pdo)) {
    die("Database connection error.");
}

if (isset($_POST["register"])) {
    $role = $_POST["role"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $repeatPassword = $_POST["repeatPassword"];

    // Validate password
    if ($password !== $repeatPassword) {
        header("location:../register.php?error=passwordmismatch");
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement based on role
    if ($role === 'student') {
        $schoolid = $_POST["schoolid"];
        $statement = $pdo->prepare("INSERT INTO tbl_students (fname, lname, email, user_name, user_pass, user_role) VALUES (:firstName, :lastName, :email, :userName, :password, :role)");
        $statement->bindParam(':userName', $schoolid);  // Use schoolid for students
    } else {
        $username = $_POST["username"];
        $statement = $pdo->prepare("INSERT INTO tbl_users (user_fname, user_lname, user_email, user_name, user_pass, user_role) VALUES (:firstName, :lastName, :email, :userName, :password, :role)");
        $statement->bindParam(':userName', $username);  // Use username for non-students
    }

    // Bind parameters common to both queries
    $statement->bindParam(':firstName', $firstName);
    $statement->bindParam(':lastName', $lastName);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $hashedPassword);
    $statement->bindParam(':role', $role);

    // Execute the query
    if ($statement->execute()) {
        $_SESSION['user_created'] = true;

        // Redirect based on user role
        if ($role === 'student') {
            header("location:../user-student.php?register=success");
        } else {
            header("location:../user.php?register=success");
        }
    } else {
        print_r($statement->errorInfo());
        header("location:../register.php?error=sqlerror");
    }
    exit;
}
?>
