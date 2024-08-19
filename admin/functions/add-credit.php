<?php

include("../includes/connect.php");
include("../includes/connection.php");

function showAlertAndRedirect($message, $formAction, $hiddenInputName, $hiddenInputValue)
{
    echo '<form id="myForm" action="' . $formAction . '" method="post">';
    echo '<input type="hidden" name="' . $hiddenInputName . '" value="' . $hiddenInputValue . '">';
    echo '</form>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("myForm").submit();
            });
          </script>';
}


if (isset($_POST["submit"])) {
    $amount = $_POST["amount"];
    $stat = $_POST["stat"];
    $date = $_POST["date"];
    $type = $_POST["othersInput"];
    $emp_id = $_POST["emp_id"];

    try {
        $database = new Connection();
        $conn = $database->open();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check total credit and debit amounts
        $totalCreditQuery = "SELECT SUM(amount) AS total_credit FROM tbl_borrows WHERE employee_id = '$emp_id' AND status = 'credit'";
        $totalDebitQuery = "SELECT SUM(amount) AS total_debit FROM tbl_borrows WHERE employee_id = '$emp_id' AND status = 'debit'";

        $totalCreditStmt = $conn->query($totalCreditQuery);
        $totalDebitStmt = $conn->query($totalDebitQuery);

        $totalCredit = $totalCreditStmt->fetchColumn();
        $totalDebit = $totalDebitStmt->fetchColumn();

        // If there are no records and the new record is debit, do not proceed
        if ($stat === 'Debit' && $totalDebit === 0) {
            showAlertAndRedirect("Success", "../profile.php?error=nodebit", "emps_id", $emp_id);
            exit();
        }

        // Calculate the remaining balance (credit - debit)
        $remainingBalance = $totalCredit - $totalDebit;

        // If the remaining balance is less than the new debit amount, do not proceed
        if ($stat === 'Debit' && $amount > $remainingBalance) {


            showAlertAndRedirect("Invalid Amount", "../profile.php?error=exceed", "emps_id", $emp_id);
            // header("location: ../compensation.php?error=payment_exceed");
            exit();
        }

        // Insert new record
        $sql = "INSERT INTO `tbl_borrows`(`employee_id`, `amount`, `type`, `status`, `date`) 
                VALUES ('$emp_id', '$amount', '$type', '$stat', '$date')";

        $conn->exec($sql);
        showAlertAndRedirect("Created Successfully", "../profile.php?error=success", "emps_id", $emp_id);
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    } finally {
        $conn = null;
    }
} else {
    header("location: ../profile.php?error=error");
}
