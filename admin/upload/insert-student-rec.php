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

    // Collect and sanitize form data
    $user_id = $conn->real_escape_string(trim($_POST['user_id']));
    $lname = $conn->real_escape_string(trim($_POST['lname']));
    $fname = $conn->real_escape_string(trim($_POST['fname']));
    $middleInitial = $conn->real_escape_string(trim($_POST['middleInitial']));
    $Suffix = $conn->real_escape_string(trim($_POST['Suffix']));
    $course = $conn->real_escape_string(trim($_POST['course']));
    $year = $conn->real_escape_string(trim($_POST['year']));
    $gender = $conn->real_escape_string(trim($_POST['gender']));
    $bdate = $conn->real_escape_string(trim($_POST['bdate']));
    $pob = $conn->real_escape_string(trim($_POST['pob']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $user_name = $conn->real_escape_string(trim($_POST['user_name']));
    $major = $conn->real_escape_string(trim($_POST['major']));
    $contact = $conn->real_escape_string(trim($_POST['contact']));
    $nationality = $conn->real_escape_string(trim($_POST['nationality']));
    $civilStatus = $conn->real_escape_string(trim($_POST['civilStatus']));
    $religion = $conn->real_escape_string(trim($_POST['religion']));
    $modality = $conn->real_escape_string(trim($_POST['modality']));
    $fb = $conn->real_escape_string(trim($_POST['fb']));
    $curAddress = $conn->real_escape_string(trim($_POST['curAddress']));
    $cityAdd = $conn->real_escape_string(trim($_POST['cityAdd']));
    $zipcode = $conn->real_escape_string(trim($_POST['zipcode']));

    // Check if the studentID already exists
    if (!empty($user_id)) {
        $checkSQL = "SELECT user_id FROM tbl_students WHERE user_id = '$user_id'";
        $result = $conn->query($checkSQL);

        if ($result && $result->num_rows > 0) {
            // Update the existing record
            $updateSQL = "UPDATE tbl_students SET
                          user_name = '$user_name',
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
                          contact = '$contact',
                          nationality = '$nationality',
                          civilStatus = '$civilStatus',
                          religion = '$religion',
                          modality = '$modality',
                          fb = '$fb',
                          curAddress = '$curAddress',
                          cityAdd = '$cityAdd',
                          zipcode = '$zipcode'
                          WHERE user_id = '$user_id'";

            if ($conn->query($updateSQL) === TRUE) {
                $_SESSION['student_updated'] = true;
                $user_id = urlencode($user_id); // URL encode the user_id
                echo "<script>
                        window.location.href = '../user-profile.php?user_id=" . $user_id . "&update-success=true';
                      </script>";
                exit();
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            // Insert a new record
            $insertSQL = "INSERT INTO tbl_students (user_name, lname, fname, middleInitial, Suffix, course, year, gender, bdate, pob, email, user_id, major, contact, nationality, civilStatus, religion, modality, fb, curAddress, cityAdd, zipcode)
                          VALUES ('$user_name', '$lname', '$fname', '$middleInitial', '$Suffix', '$course', '$year', '$gender', '$bdate', '$pob', '$email', '$user_id', '$major', '$contact', '$nationality', '$civilStatus', '$religion', '$modality', '$fb', '$curAddress', '$cityAdd', '$zipcode')";

            if ($conn->query($insertSQL) === TRUE) {
                $_SESSION['student_updated'] = true;
                header("Location: ../user-profile.php?error=success");
                exit();
            } else {
                echo "Error inserting record: " . $conn->error;
            }
        }
    } else {
        echo "User ID is missing.";
    }

    // Close connection
    $conn->close();
}
