<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Database connection details
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooldb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve user_id from the session
    $user_id = isset($_SESSION["login"]) ? $_SESSION["login"] : null;

    if (!$user_id) {
        echo "User ID is missing.";
        exit();
    }

    // Collect and sanitize form data
    $fatherName = $conn->real_escape_string($_POST['fatherName']);
    $fwork = $conn->real_escape_string($_POST['fwork']);
    $motherName = $conn->real_escape_string($_POST['motherName']);
    $mwork = $conn->real_escape_string($_POST['mwork']);
    $primarySchool = $conn->real_escape_string($_POST['primarySchool']);
    $primaryAddress = $conn->real_escape_string($_POST['primaryAddress']);
    $primaryCompleted = $conn->real_escape_string($_POST['primaryCompleted']);
    $entermediateSchool = $conn->real_escape_string($_POST['entermediateSchool']);
    $entermediateAddress = $conn->real_escape_string($_POST['entermediateAddress']);
    $entermediateCompleted = $conn->real_escape_string($_POST['entermediateCompleted']);
    $hsSchool = $conn->real_escape_string($_POST['hsSchool']);
    $hsAddress = $conn->real_escape_string($_POST['hsAddress']);
    $hsCompleted = $conn->real_escape_string($_POST['hsCompleted']);
    $shSchool = $conn->real_escape_string($_POST['shSchool']);
    $shAddress = $conn->real_escape_string($_POST['shAddress']);
    $shCompleted = $conn->real_escape_string($_POST['shCompleted']);
    $collegeSchool = $conn->real_escape_string($_POST['collegeSchool']);
    $collegeAddress = $conn->real_escape_string($_POST['collegeAddress']);
    $collegeCompleted = $conn->real_escape_string($_POST['collegeCompleted']);

    // Check if the user_id exists in tbl_students_details
    $checkSQL = "SELECT id FROM tbl_students_details WHERE user_id = '$user_id'";
    $result = $conn->query($checkSQL);

    if ($result->num_rows > 0) {
        // user_id exists, update the existing record
        $updateSQL = "UPDATE tbl_students_details SET 
                      fatherName = '$fatherName',
                      fwork = '$fwork',
                      motherName = '$motherName',
                      mwork = '$mwork',
                      primarySchool = '$primarySchool',
                      primaryAddress = '$primaryAddress',
                      primaryCompleted = '$primaryCompleted',
                      entermediateSchool = '$entermediateSchool',
                      entermediateAddress = '$entermediateAddress',
                      entermediateCompleted = '$entermediateCompleted',
                      hsSchool = '$hsSchool',
                      hsAddress = '$hsAddress',
                      hsCompleted = '$hsCompleted',
                      shSchool = '$shSchool',
                      shAddress = '$shAddress',
                      shCompleted = '$shCompleted',
                      collegeSchool = '$collegeSchool',
                      collegeAddress = '$collegeAddress',
                      collegeCompleted = '$collegeCompleted'
                      WHERE user_id = '$user_id'";

        if ($conn->query($updateSQL) === TRUE) {
            $_SESSION['student_updated'] = true;
            header("Location: ../user-profile.php?user_id=$user_id&update-success=true");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // user_id does not exist, insert a new record
        $insertSQL = "INSERT INTO tbl_students_details 
                      (user_id, fatherName, fwork, motherName, mwork, primarySchool, primaryAddress, primaryCompleted, entermediateSchool, entermediateAddress, entermediateCompleted, hsSchool, hsAddress, hsCompleted, shSchool, shAddress, shCompleted, collegeSchool, collegeAddress, collegeCompleted) 
                      VALUES 
                      ('$user_id', '$fatherName', '$fwork', '$motherName', '$mwork', '$primarySchool', '$primaryAddress', '$primaryCompleted', '$entermediateSchool', '$entermediateAddress', '$entermediateCompleted', '$hsSchool', '$hsAddress', '$hsCompleted', '$shSchool', '$shAddress', '$shCompleted', '$collegeSchool', '$collegeAddress', '$collegeCompleted')";

        if ($conn->query($insertSQL) === TRUE) {
            $_SESSION['student_updated'] = true;
            header("Location: ../user-profile.php?user_id=$user_id&insert-success=true");
            exit();
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }

    // Close connection
    $conn->close();
}
?>
