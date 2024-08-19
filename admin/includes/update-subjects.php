<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

    $id = $conn->real_escape_string($_POST['id']);
    $code = $conn->real_escape_string($_POST['code']);
    $description = $conn->real_escape_string($_POST['description']);
    $lec = $conn->real_escape_string($_POST['lec']);
    $lab = $conn->real_escape_string($_POST['lab']);
    $unit = $conn->real_escape_string($_POST['unit']);
    $pre_req = $conn->real_escape_string($_POST['pre_req']);
    $total = $conn->real_escape_string($_POST['total']);
    $course = $conn->real_escape_string($_POST['course']);
    $year = $conn->real_escape_string($_POST['year']);
    $semester = $conn->real_escape_string($_POST['semester']);

    // Update record
    $sql = "UPDATE tbl_subjects SET code='$code', description='$description', lec='$lec', lab='$lab', unit='$unit', pre_req='$pre_req', total='$total', course='$course', year='$year', semester='$semester' WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: search_subjects.php?error=update-success");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
