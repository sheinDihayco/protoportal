<?php
include_once "connect.php";
session_start(); // Start the session

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

    // Prepare SQL statement
    if ($role == 'student') {
        $schoolid = $_POST["schoolid"];
        $statement = $conn->prepare("INSERT INTO tbl_students (fname, lname, email, user_name, user_pass, user_role) VALUES (:firstName, :lastName, :email, :userName, :password, :role)");
        $statement->bindParam(':userName', $schoolid);  // Ensure that 'schoolid' is used for students
    } else {
        $username = $_POST["username"];
        $statement = $conn->prepare("INSERT INTO tbl_users (user_fname, user_lname, user_email, user_name, user_pass, user_role) VALUES (:firstName, :lastName, :email, :userName, :password, :role)");
        $statement->bindParam(':userName', $username);  // Ensure that 'username' is used for non-students
    }

    // Bind parameters for both queries
    $statement->bindParam(':firstName', $firstName);
    $statement->bindParam(':lastName', $lastName);
    $statement->bindParam(':email', $email);
    $statement->bindParam(':password', $hashedPassword);  // Bind the hashed password
    $statement->bindParam(':role', $role);

    // Execute the query
    if ($statement->execute()) {
        $_SESSION['user_created'] = true;

        // Determine redirection based on user role
        if ($role == 'student') {
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
