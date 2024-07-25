<?php

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

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect value of each input field
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $middleInitial = $_POST['middleInitial'];
    $gender = $_POST['gender'];
    $bdate = $_POST['bdate'];
    $pob = $_POST['pob'];
    $email = $_POST['email'];
    $studentID = $_POST['studentID'];
    $course = $_POST['course'];
    $year = $_POST['year'];
    $major = $_POST['major'];
    $nationality = $_POST['nationality'];
    $civilStatus = $_POST['civilStatus'];
    $religion = $_POST['religion'];
    $modality = $_POST['modality'];
    $fb = $_POST['fb'];
    $curAddress = $_POST['curAddress'];
    $cityAdd = $_POST['cityAdd'];
    $zipcode = $_POST['zipcode'];
    $contact = $_POST['contact'];
    $fatherName = $_POST['fatherName'];
    $fwork = $_POST['fwork'];
    $motherName = $_POST['motherName'];
    $mwork = $_POST['mwork'];
    $primarySchool = $_POST['primarySchool'];
    $primaryAddress = $_POST['primaryAddress'];
    $primaryCompleted = $_POST['primaryCompleted'];
    $entermediateSchool = $_POST['entermediateSchool'];
    $entermediateAddress = $_POST['entermediateAddress'];
    $entermediateCompleted = $_POST['entermediateCompleted'];
    $hsSchool = $_POST['hsSchool'];
    $hsAddress = $_POST['hsAddress'];
    $hsCompleted = $_POST['hsCompleted'];
    $shSchool = $_POST['shSchool'];
    $shAddress = $_POST['shAddress'];
    $shCompleted = $_POST['shCompleted'];
    $collegeSchool = $_POST['collegeSchool'];
    $collegeAddress = $_POST['collegeAddress'];
    $collegeCompleted = $_POST['collegeCompleted'];

    // Prepare an update statement
    $sql = "UPDATE tbl_students SET 
                fname = ?, 
                lname = ?, 
                middleInitial = ?, 
                gender = ?, 
                bdate = ?, 
                pob = ?, 
                email = ?, 
                course = ?, 
                year = ?, 
                major = ?, 
                nationality = ?, 
                civilStatus = ?, 
                religion = ?, 
                modality = ?, 
                fb = ?, 
                curAddress = ?, 
                cityAdd = ?, 
                zipcode = ?, 
                contact = ?, 
                fatherName = ?, 
                fwork = ?, 
                motherName = ?, 
                mwork = ?, 
                primarySchool = ?, 
                primaryAddress = ?, 
                primaryCompleted = ?, 
                entermediateSchool = ?, 
                entermediateAddress = ?, 
                entermediateCompleted = ?, 
                hsSchool = ?, 
                hsAddress = ?, 
                hsCompleted = ?, 
                shSchool = ?, 
                shAddress = ?, 
                shCompleted = ?, 
                collegeSchool = ?, 
                collegeAddress = ?, 
                collegeCompleted = ?
            WHERE studentID = ?";

    // Prepare and bind
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param(
            "ssssssssssssssssssssssssssssssssssssssi",
            $fname,
            $lname,
            $middleInitial,
            $gender,
            $bdate,
            $pob,
            $email,
            $course,
            $year,
            $major,
            $nationality,
            $civilStatus,
            $religion,
            $modality,
            $fb,
            $curAddress,
            $cityAdd,
            $zipcode,
            $contact,
            $fatherName,
            $fwork,
            $motherName,
            $mwork,
            $primarySchool,
            $primaryAddress,
            $primaryCompleted,
            $entermediateSchool,
            $entermediateAddress,
            $entermediateCompleted,
            $hsSchool,
            $hsAddress,
            $hsCompleted,
            $shSchool,
            $shAddress,
            $shCompleted,
            $collegeSchool,
            $collegeAddress,
            $collegeCompleted,
            $studentID
        );

        // Execute the statement
        if ($stmt->execute()) {
            header("Location: ../studentRecords1.php?error=update-success");
            exit(); // Ensure no further code is executed after redirection
        } else {
            echo "Error updating record: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }

    // Close the connection
    $conn->close();
} else {
    echo "Invalid request method.";
}
