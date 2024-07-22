<?php
include("../includes/connect.php");
include("../includes/connection.php");

if(isset($_POST["submit"])) {
    $employee_id = $_POST["employee_id"];
    $basic_pay = $_POST["basic_pay"];
    $sss = $_POST["sss"];
    $pagibig = $_POST["pagibig"];
    $philhealth = $_POST["philhealth"];

   

    try {
        $database = new Connection();
        $conn = $database->open();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if the employee already has a deduction record
        $existingDeductionQuery = "SELECT * FROM `tbl_compensation` WHERE `employee_id` = :employee_id";
        $existingDeductionStmt = $conn->prepare($existingDeductionQuery);
        $existingDeductionStmt->bindParam(':employee_id', $employee_id);
        $existingDeductionStmt->execute();

        if($existingDeductionStmt->rowCount() > 0) {
            // Deduction record exists, update the record
            $sql = "UPDATE `tbl_compensation` SET 
                `basic_pay` = '$basic_pay',
                `sss` = '$sss',
                `pagibig` = '$pagibig',
                `philhealth` = '$philhealth'
                WHERE `employee_id` = :employee_id";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':employee_id', $employee_id);
            $stmt->execute();

            echo "Deduction record updated successfully";
        } else {
            // Deduction record doesn't exist, insert a new record
            $sql = "INSERT INTO `tbl_compensation`(`employee_id`, `basic_pay`, `sss`, `pagibig`, `philhealth`) 
                    VALUES ('$employee_id', '$basic_pay', '$sss', '$pagibig', '$philhealth')";
            
            $conn->exec($sql);
            echo "New deduction record created successfully";
        }

        echo '<script>alert("Changes saved successfully!");</script>';
        echo '<form id="myForm" action="../profile.php" method="post">';
        echo '<input type="hidden" name="emps_id" value="'.$employee_id.'">';
        echo '</form>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("myForm").submit();
                });
              </script>';
                

    } catch(PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    } finally {
        $conn = null;
    }


    // header("location: ../profile.php?error=success");
} else {
    header("location: ../profile.php?error=error");
}
?>
