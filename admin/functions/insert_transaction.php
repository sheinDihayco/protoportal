<?php
include("../includes/connect.php");
include("../includes/connection.php");

if (isset($_POST["submit"])) {
    $emp_id = $_POST['emp_id'];
    $period = $_POST['period'];
    $month = substr($period, 5, 2);
    $year = substr($period, 0, 4);
    $periodValue = $year . '-' . $month;
    $days = $_POST['days'];
    $gross_sal = $_POST['gross_sal'];
    $abs_total = $_POST['abs_total'];
    $late_total = $_POST['late_total'];
    $sss_ded = $_POST['sss_ded'];
    $pag_ded = $_POST['pag_ded'];
    $ph_ded = $_POST['ph_ded'];
    $others_type = $_POST['others_type'];
    $others_amt = $_POST['others_amount'];
    $others_desc = $_POST['others_desc'];
    $grossp = $_POST['gross_salary'];
    $netp = $_POST['net_pay'];

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if a record with the same period already exists
        $checkPeriodSql = "SELECT COUNT(*) FROM tbl_transaction WHERE employee_id = :employee_id AND period = :period";
        $stmtCheckPeriod = $conn->prepare($checkPeriodSql);
        $stmtCheckPeriod->bindParam(':employee_id', $emp_id);
        $stmtCheckPeriod->bindParam(':period', $periodValue);
        $stmtCheckPeriod->execute();
        $recordCount = $stmtCheckPeriod->fetchColumn();

        if ($recordCount > 0) {
            // A record with the same period already exists, handle accordingly
            echo "Record with the same period already exists!";
            echo '<form id="myForm" action="../profile.php?error=exist" method="post">';
            echo '<input type="hidden" name="emps_id" value="' . $emp_id . '">';
            echo '</form>';
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                        document.getElementById("myForm").submit();
                    });
                  </script>';
        } else {
            // Record with the same period doesn't exist, proceed with the insertion
            // SQL query to insert data into tbl_transaction
            $transactionSql = "INSERT INTO tbl_transaction (employee_id, period, days, gross_amount, absent_amount, late_amount, sss_amount, pagibig_amount, phil_amount, others_type, others_amount, others_desc, grosspay, netpay, date)
                                VALUES (:employee_id, :period, :days, :gross_sal, :abs_total, :late_total, :sss_ded, :pag_ded, :ph_ded, :others_type, :others_amount, :others_desc, :gross, :net, NOW())";

            $stmtTransaction = $conn->prepare($transactionSql);

            // Bind parameters for transaction
            $stmtTransaction->bindParam(':employee_id', $emp_id);
            $stmtTransaction->bindParam(':period', $periodValue);
            $stmtTransaction->bindParam(':days', $days);
            $stmtTransaction->bindParam(':gross_sal', $gross_sal);
            $stmtTransaction->bindParam(':abs_total', $abs_total);
            $stmtTransaction->bindParam(':late_total', $late_total);
            $stmtTransaction->bindParam(':sss_ded', $sss_ded);
            $stmtTransaction->bindParam(':pag_ded', $pag_ded);
            $stmtTransaction->bindParam(':ph_ded', $ph_ded);
            $stmtTransaction->bindParam(':others_type', $others_type);
            $stmtTransaction->bindParam(':others_amount', $others_amt);
            $stmtTransaction->bindParam(':others_desc', $others_desc);
            $stmtTransaction->bindParam(':gross', $grossp);
            $stmtTransaction->bindParam(':net', $netp);

            // Execute the transaction query
            $stmtTransaction->execute();

            // Get the last inserted transaction ID
            $transactionId = $conn->lastInsertId();


            function redirectToPrint($formAction, $eid, $tid, $pd)
            {
                echo '<form id="myForm" action="' . $formAction . '" method="post">';
                echo '<input type="hidden" name="emps_id" value="' . $eid . '">';
                echo '<input type="hidden" name="trans_id" value="' . $tid . '">';
                echo '<input type="hidden" name="period" value="' . $pd . '">';
                echo '</form>';
                echo '<script>
                            document.addEventListener("DOMContentLoaded", function() {
                                document.getElementById("myForm").submit();
                            });
                          </script>';
            }



            // Insert data into tbl_attendance
            $absent = $_POST['absent']; // You need to replace 'absent' with the actual field from the form
            $late = $_POST['late']; // You need to replace 'late' with the actual field from the form
            $overtime = '0'; // You need to replace 'overtime' with the actual field from the form

            $attendanceSql = "INSERT INTO tbl_attendance (transaction_id, absent, late, overtime)
                              VALUES (:transaction_id, :absent, :late, :overtime)";

            $stmtAttendance = $conn->prepare($attendanceSql);

            // Bind parameters for attendance
            $stmtAttendance->bindParam(':transaction_id', $transactionId);
            $stmtAttendance->bindParam(':absent', $absent);
            $stmtAttendance->bindParam(':late', $late);
            $stmtAttendance->bindParam(':overtime', $overtime);

            // Execute the attendance query
            $stmtAttendance->execute();

            // Sample data for tbl_borrow, replace these with actual values
            if (!empty($_POST['credit_amount']) && $_POST['credit_amount'] != '0') {
                $amount = $_POST['credit_amount'];
                $cred_desc = $_POST['cred_desc'];
                $status = 'Debit';

                // SQL query to insert data into tbl_borrow
                $borrowSql = "INSERT INTO tbl_borrows (employee_id, transaction_id, amount, type, status, date)
                              VALUES (:employee_id, :transaction_id, :amount, :type, :status, NOW())";

                $stmtBorrow = $conn->prepare($borrowSql);

                // Bind parameters for borrow
                $stmtBorrow->bindParam(':employee_id', $emp_id);
                $stmtBorrow->bindParam(':transaction_id', $transactionId);
                $stmtBorrow->bindParam(':amount', $amount);
                $stmtBorrow->bindParam(':type', $cred_desc);
                $stmtBorrow->bindParam(':status', $status);

                // Execute the borrow query
                $stmtBorrow->execute();


                // echo '<form id="myForm" action="../profile.php" method="post">';
                // echo '<input type="hidden" name="emps_id" value="'.$emp_id.'">';
                // echo '</form>';
                // echo '<script>
                //         document.addEventListener("DOMContentLoaded", function() {
                //             document.getElementById("myForm").submit();
                //         });
                //       </script>';

                redirectToPrint("../slip-print.php", $emp_id, $transactionId, $period);
            } else {
                // echo "Data inserted successfully!";

                // // Redirect without showing alert if credit_amount is empty or zero
                // echo '<form id="myForm" action="../profile.php" method="post">';
                // echo '<input type="hidden" name="emps_id" value="'.$emp_id.'">';
                // echo '</form>';
                // echo '<script>
                //         document.addEventListener("DOMContentLoaded", function() {
                //             document.getElementById("myForm").submit();
                //         });
                //       </script>';

                redirectToPrint("../slip-print.php", $emp_id, $transactionId, $period);
            }
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    } finally {
        // Close the database connection
        if ($conn) {
            $conn = null;
        }
    }
} else {
    header("location: ../profile.php?error=error");
}
