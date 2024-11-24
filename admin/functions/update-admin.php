<?php
// Start session to access logged-in user's information
session_start();
include("../includes/connect.php");
include("../includes/connection.php");

// Check if the form was submitted
if (isset($_POST['submit'])) {
    // Retrieve the logged-in user's ID from the session
    $user_id = $_SESSION['login']; // Assuming 'login' stores the user's ID

    // Retrieve form data and sanitize input
    $bdate = htmlspecialchars($_POST['bdate']);
    $dhire = htmlspecialchars($_POST['dhire']);
    $add = htmlspecialchars($_POST['add']);
    $email = htmlspecialchars($_POST['email']);
    $dept = htmlspecialchars($_POST['dept']);
    $cnum = htmlspecialchars($_POST['cnum']);

    // Prepare the SQL statement using prepared statements
    $sql = "UPDATE tbl_users SET date_of_birth = :bdate, hire_date = :dhire, address = :add, 
            user_email = :email, department = :dept, phone_number = :cnum WHERE user_id = :user_id";

    // Prepare the statement and bind the parameters
    $stmt = $pdo->prepare($sql);

    // Bind the parameters to the SQL query
    $stmt->bindParam(':bdate', $bdate);
    $stmt->bindParam(':dhire', $dhire);
    $stmt->bindParam(':add', $add);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':dept', $dept);
    $stmt->bindParam(':cnum', $cnum);
    $stmt->bindParam(':user_id', $user_id);

    // Execute the query
    if ($stmt->execute()) {
        // Set session variable to indicate successful update
        $_SESSION['admin_updated'] = true;
        // Redirect or show a success message
        header("Location: ../user-profile-admin.php?status=success");
        exit();
    } else {
        // Redirect or show an error message
        header("Location: ../user-profile-admin.php?status=error");
        exit();
    }
} else {
    // Redirect back if the form wasn't submitted
    header("Location: ../user-profile-admin.php");
    exit();
}
