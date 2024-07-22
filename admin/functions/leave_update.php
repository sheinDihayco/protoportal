<?php
// Include the necessary PHP files and establish a database connection
include("../includes/connect.php");
include("../includes/connection.php");

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $leave_id = $_POST['leave_id'];
    $leaveType = $_POST['leaveType'];
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $leaveDuration = $_POST['leaveDuration'];
    $empID = $_POST['empid'];

    try {
        
        $stmt = $conn->prepare("UPDATE tbl_leave SET leave_type = ?, leave_start = ?, leave_end = ?, leave_duration = ? WHERE lvs_id = ?");

        // Bind parameters and execute the statement
        $stmt->bindParam(1, $leaveType);
        $stmt->bindParam(2, $startDate);
        $stmt->bindParam(3, $endDate);
        $stmt->bindParam(4, $leaveDuration);
        $stmt->bindParam(5, $leave_id);
        $stmt->execute();

        // Redirect to a success page or update page
        
        echo '<form id="myForm" action="../profile.php?error=success" method="post">';
        echo '<input type="hidden" name="emps_id" value="'.$empID.'">';
        echo '</form>';
        echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById("myForm").submit();
                });
              </script>';

        exit();
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
}

// Close the database connection
$database->close();
?>
