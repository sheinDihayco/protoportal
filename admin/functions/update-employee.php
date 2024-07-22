<?php
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
    $eid = $_POST["empid"];

    try {
        $database = new Connection();
        $conn = $database->open();

        $sql = "UPDATE `tbl_employee` SET 
                `first_name` = :fname,
                `last_name` = :lname,
                `date_of_birth` = :bdate,
                `gender` = :gender,
                `hire_date` = :dhire,
                `job_title` = :jobt,
                `department` = :dept,
                `phone_number` = :cnum,
                `address` = :add
                WHERE `employee_id` = :eid";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':bdate', $bdate);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':dhire', $dhire);
        $stmt->bindParam(':jobt', $jobt);
        $stmt->bindParam(':dept', $dept);
        $stmt->bindParam(':cnum', $cnum);
        $stmt->bindParam(':add', $add);
        $stmt->bindParam(':eid', $eid);

        $stmt->execute();

        echo "Record updated successfully";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        $database->close(); // close the database connection
    }

    header("location: ../employee.php?error=update-success");
} else {
    header("location: ../employee.php?error=update-error");
}
?>
