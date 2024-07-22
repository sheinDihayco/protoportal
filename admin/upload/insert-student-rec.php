<?php
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

    // Collect and sanitize form data
    $fname = $conn->real_escape_string($_POST['fname']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $middleInitial = $conn->real_escape_string($_POST['middleInitial']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $bdate = $conn->real_escape_string($_POST['bdate']);
    $pob = $conn->real_escape_string($_POST['pob']);
    $email = $conn->real_escape_string($_POST['email']);
    $studentID = $conn->real_escape_string($_POST['studentID']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);
    $major = $conn->real_escape_string($_POST['major']);
    $nationality = $conn->real_escape_string($_POST['nationality']);
    $civilStatus = $conn->real_escape_string($_POST['civilStatus']);
    $religion = $conn->real_escape_string($_POST['religion']);
    $modality = $conn->real_escape_string($_POST['modality']);
    $fb = $conn->real_escape_string($_POST['fb']);
    $curAddress = $conn->real_escape_string($_POST['curAddress']);
    $cityAdd = $conn->real_escape_string($_POST['cityAdd']);
    $zipcode = $conn->real_escape_string($_POST['zipcode']);
    $contact = $conn->real_escape_string($_POST['contact']);
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

    // SQL insert statement
    $sql = "INSERT INTO tbl_students (fname, lname, middleInitial, gender, bdate, pob, email, studentID, course, year, major, nationality, civilStatus, religion, modality, fb, curAddress, cityAdd, zipcode, contact, fatherName, fwork, motherName, mwork, primarySchool, primaryAddress, primaryCompleted, entermediateSchool, entermediateAddress, entermediateCompleted, hsSchool, hsAddress, hsCompleted, shSchool, shAddress, shCompleted, collegeSchool, collegeAddress, collegeCompleted)

    VALUES ('$fname', '$lname', '$middleInitial', '$gender', '$bdate', '$pob', '$email', '$studentID', '$course', '$year', '$major', '$nationality', '$civilStatus', '$religion', '$modality', '$fb', '$curAddress', '$cityAdd', '$zipcode', '$contact', '$fatherName', '$fwork', '$motherName', '$mwork', '$primarySchool', '$primaryAddress', '$primaryCompleted', '$entermediateSchool', '$entermediateAddress', '$entermediateCompleted', '$hsSchool', '$hsAddress', '$hsCompleted', '$shSchool', '$shAddress', '$shCompleted', '$collegeSchool', '$collegeAddress', '$collegeCompleted')";

    if ($conn->query($sql) === TRUE) {
        header("location: ../studentRecords.php?error=success");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Close connection
    $conn->close();
}
