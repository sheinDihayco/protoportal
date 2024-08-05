<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "schooldb";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {

    $course = $_POST['course'];
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $code = $_POST['code'];
    $description = $_POST['description'];
    $lec = $_POST['lec'];
    $lab = $_POST['lab'];
    $unit = $_POST['unit'];
    $pre_req = $_POST['pre_req'];
    $total = $_POST['total'];

    $stmt = $conn->prepare("UPDATE tbl_subjects SET course=?, year=?, semester=?, description=?, lec=?, lab=?, unit=?, pre_req=?, total=? WHERE code=?");
    $stmt->bind_param("sisssiiiss", $course, $year, $semester, $description, $lec, $lab, $unit, $pre_req, $total, $code);

    if ($stmt->execute()) {
        header("Location: ../subject.php?error=upated-success");
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "No data received";
}
