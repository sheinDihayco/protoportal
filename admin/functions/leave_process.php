<?php

include("../includes/connect.php");
include("../includes/connection.php");

function showAlertAndRedirect($message, $formAction, $hiddenInputName, $hiddenInputValue) {
    echo '<form id="myForm" action="' . $formAction . '" method="post">';
    echo '<input type="hidden" name="' . $hiddenInputName . '" value="' . $hiddenInputValue . '">';
    echo '</form>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("myForm").submit();
            });
          </script>';
}

if(isset($_POST["submit"])) {
    $empid = $_POST["emp_id"];
    $start = $_POST["startDate"];
    $type = $_POST["leaveType"];
    $end = $_POST["endDate"];
    $dur = $_POST["leaveDuration"];
    $filed = $_POST["leaveFiled"];
    $status = 'Approved';

    try {
        $database = new Connection();
        $conn = $database->open();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert new record
        $sql = "INSERT INTO `tbl_leave`(`employee_id`, `leave_type`, `leave_start`, `leave_end`, `leave_duration`, `leave_status`, `leave_filed`) 
                VALUES ('$empid', '$type', '$start', '$end', '$dur', '$status', '$filed')";

        $conn->exec($sql);
        showAlertAndRedirect("Created Successfully", "../profile.php?error=successsfiling", "emps_id", $empid);
    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    } finally {
        $conn = null;
    }
} else {
    header("location: ../profile.php?error=error");
}
?>
