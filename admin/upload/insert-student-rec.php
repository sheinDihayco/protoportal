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
    $user_id = $conn->real_escape_string($_POST['user_id']);
    $lname = $conn->real_escape_string($_POST['lname']);
    $fname = $conn->real_escape_string($_POST['fname']);
    $middleInitial = $conn->real_escape_string($_POST['middleInitial']);
    $Suffix = $conn->real_escape_string($_POST['Suffix']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);
    $gender = $conn->real_escape_string($_POST['gender']);
    $bdate = $conn->real_escape_string($_POST['bdate']);
    $pob = $conn->real_escape_string($_POST['pob']);
    $email = $conn->real_escape_string($_POST['email']);
    $studentID = $conn->real_escape_string($_POST['studentID']);
    $major = $conn->real_escape_string($_POST['major']);
    $nationality = $conn->real_escape_string($_POST['nationality']);
    $civilStatus = $conn->real_escape_string($_POST['civilStatus']);
    $religion = $conn->real_escape_string($_POST['religion']);
    $modality = $conn->real_escape_string($_POST['modality']);
    $fb = $conn->real_escape_string($_POST['fb']);
    $curAddress = $conn->real_escape_string($_POST['curAddress']);
    $cityAdd = $conn->real_escape_string($_POST['cityAdd']);
    $zipcode = $conn->real_escape_string($_POST['zipcode']);
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

    // Check if the studentID already exists
    $checkSQL = "SELECT studentID FROM tbl_students WHERE studentID = '$studentID'";
    $result = $conn->query($checkSQL);

    if ($result->num_rows > 0) {
        // studentID exists, update the existing record
        $updateSQL = "UPDATE tbl_students SET
                      user_id = '$user_id',
                      lname = '$lname',
                      fname = '$fname',
                      middleInitial = '$middleInitial',
                      Suffix = '$Suffix',
                      course = '$course',
                      year = '$year',
                      gender = '$gender',
                      bdate = '$bdate',
                      pob = '$pob',
                      email = '$email',
                      major = '$major',
                      nationality = '$nationality',
                      civilStatus = '$civilStatus',
                      religion = '$religion',
                      modality = '$modality',
                      fb = '$fb',
                      curAddress = '$curAddress',
                      cityAdd = '$cityAdd',
                      zipcode = '$zipcode',
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
                      WHERE studentID = '$studentID'";

        if ($conn->query($updateSQL) === TRUE) {
            header("location: ../studentRecords1.php?error=success");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        // studentID does not exist, insert a new record
        $insertSQL = "INSERT INTO tbl_students (user_id, lname, fname, middleInitial, Suffix, course, year, gender, bdate, pob, email, studentID, major, nationality, civilStatus, religion, modality, fb, curAddress, cityAdd, zipcode, fatherName, fwork, motherName, mwork, primarySchool, primaryAddress, primaryCompleted, entermediateSchool, entermediateAddress, entermediateCompleted, hsSchool, hsAddress, hsCompleted, shSchool, shAddress, shCompleted, collegeSchool, collegeAddress, collegeCompleted)
                      VALUES ('$user_id', '$lname', '$fname', '$middleInitial', '$Suffix', '$course', '$year', '$gender', '$bdate', '$pob', '$email', '$studentID', '$major', '$nationality', '$civilStatus', '$religion', '$modality', '$fb', '$curAddress', '$cityAdd', '$zipcode', '$fatherName', '$fwork', '$motherName', '$mwork', '$primarySchool', '$primaryAddress', '$primaryCompleted', '$entermediateSchool', '$entermediateAddress', '$entermediateCompleted', '$hsSchool', '$hsAddress', '$hsCompleted', '$shSchool', '$shAddress', '$shCompleted', '$collegeSchool', '$collegeAddress', '$collegeCompleted')";

        if ($conn->query($insertSQL) === TRUE) {
            header("location: ../studentRecords1.php?error=success");
        } else {
            echo "Error inserting record: " . $conn->error;
        }
    }

    // Close connection
    $conn->close();
}
