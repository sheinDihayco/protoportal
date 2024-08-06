<?php
session_start(); // Ensure session_start() is called at the beginning

include("../includes/connect.php");
include("../includes/connection.php");

if (isset($_POST["submit"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $bdate = $_POST["bdate"];
    $gender = $_POST["gend"];
    $dhire = $_POST["dhire"];
    $jobt = $_POST["title"];
    $dept = $_POST["dept"];
    $cnum = $_POST["cnum"];
    $add = $_POST["add"];

    try {
        $database = new Connection();
        $dbs = $database->open();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO `tbl_employee`(`first_name`, `last_name`, `date_of_birth`, `gender`, `hire_date`, `job_title`, `department`, `phone_number`, `address`) VALUES ('$fname','$lname','$bdate','$gender','$dhire','$jobt','$dept','$cnum','$add')";
        $conn->exec($sql);
        $_SESSION['employee_created'] = true;
        header("location: ../employee.php");
        exit;
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
    header("location: ../employee.php?error=error");
} else {
    header("location: ../employee.php?error=error");
}
