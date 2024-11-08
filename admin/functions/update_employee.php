<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/connection.php";

// Check if a user_id has been passed or is in the session
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
  $_SESSION['user'] = $_POST['user_id'];
  $userid = $_POST['user_id'];
} elseif (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
  $_SESSION['user'] = $_GET['user_id'];
  $userid = $_GET['user_id'];
} elseif (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
  $userid = $_SESSION['user'];
} else {
  exit('No user ID provided');
}

// Fetch user details to confirm the user exists
$statement = $pdo->prepare("SELECT * FROM tbl_users WHERE user_id = :uid");
$statement->bindParam(':uid', $userid, PDO::PARAM_INT);
$statement->execute();
$userDetails = $statement->fetch(PDO::FETCH_ASSOC);

if (!$userDetails) {
  exit('User not found');
}

// Proceed to update the employee's details if the form is submitted
if (isset($_POST['submit'])) {
    // Sanitize and retrieve the form inputs
    $bdate = htmlspecialchars($_POST['bdate']);
    $dhire = htmlspecialchars($_POST['dhire']);
    $add = htmlspecialchars($_POST['add']);
    $email = htmlspecialchars($_POST['email']);
    $dept = htmlspecialchars($_POST['dept']);
    $cnum = htmlspecialchars($_POST['cnum']);
    $gender = htmlspecialchars($_POST['gender']);  // Retrieve gender input

    // Prepare the SQL update query
    $sql = "UPDATE tbl_users SET date_of_birth = :bdate, hire_date = :dhire, address = :add, 
            user_email = :email, department = :dept, phone_number = :cnum, gender = :gender 
            WHERE user_id = :user_id";

    try {
        $stmt = $pdo->prepare($sql);
        
        // Bind parameters and execute the query
        $stmt->bindParam(':bdate', $bdate);
        $stmt->bindParam(':dhire', $dhire);
        $stmt->bindParam(':add', $add);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dept', $dept);
        $stmt->bindParam(':cnum', $cnum);
        $stmt->bindParam(':gender', $gender);  // Bind the gender parameter
        $stmt->bindParam(':user_id', $userid);

        // Execute the query and check if the update was successful
        if ($stmt->execute()) {
            $_SESSION['employee_updated'] = true;
            header("Location: ../employee_profile.php?uid=$userid&status=success");
            exit();
        } else {
            $_SESSION['employee_updated'] = false;
            header("Location: ../user.php?uid=$userid&status=error");
            exit();
        }
    } catch (PDOException $e) {
        $_SESSION['employee_updated'] = false;
        header("Location: ../user.php?uid=$userid&status=error&message=" . $e->getMessage());
        exit();
    }
}

?>


