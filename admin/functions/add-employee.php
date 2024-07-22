<?php
include("../includes/connect.php");
include("../includes/connection.php");

    if(isset($_POST["submit"])){
        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $bdate = $_POST["bdate"];
        $gender = $_POST["gend"];
        $dhire = $_POST["dhire"];
        $jobt = $_POST["title"];
        $dept = $_POST["dept"];
        $cnum = $_POST["cnum"];
        $add = $_POST["add"];

        // $sql = "SELECT * FROM tbl_sched WHERE room_id = '$room' AND day_id = '$day' AND  ('$st' BETWEEN start_time AND end_time
        //         OR '$en' BETWEEN start_time AND end_time OR '$st' >= end_time AND '$en' <= end_time)";
        // $stmt = $dbs->query($sql);
        // $result = $stmt->fetchAll();
        // if(empty($result)){
        // }else{
        // }

        try {
            $database = new Connection();
            $dbs = $database->open();
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO `tbl_employee`(`first_name`, `last_name`, `date_of_birth`, `gender`, `hire_date`, `job_title`, `department`, `phone_number`, `address`) VALUES ('$fname','$lname','$bdate','$gender','$dhire','$jobt','$dept','$cnum','$add')";
            $conn->exec($sql);
            echo "New record created successfully";
        } catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
        }

        $conn = null;
        header("location: ../employee.php?error=success");
    }else{
        header("location: ../employee.php?error=error");
    }
?>