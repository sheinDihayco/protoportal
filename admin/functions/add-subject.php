<?php
include("../includes/connect.php");
include("../includes/connection.php");

$connection = new Connection();
$pdo = $connection->open();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $year = $_POST['year'];
    $semester = $_POST['semester'];
    $code = $_POST['code'];
    $description = $_POST['description'];
    $lec = $_POST['lec'];
    $lab = $_POST['lab'];
    $unit = $_POST['unit'];
    $pre_req = $_POST['pre_req'];
    $total = $_POST['total'];
    $course = $_POST['course'];

    // Insert the data into the database
    $sql = "INSERT INTO tbl_subjects (year, semester, code, description, lec, lab, unit, pre_req, total, course)
            VALUES (:year, :semester, :code, :description, :lec, :lab, :unit, :pre_req, :total, :course)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':year' => $year,
        ':semester' => $semester,
        ':code' => $code,
        ':description' => $description,
        ':lec' => $lec,
        ':lab' => $lab,
        ':unit' => $unit,
        ':pre_req' => $pre_req,
        ':total' => $total,
        ':course' => $course
    ]);

    // Redirect to subject.php after successful insertion
    header("Location: ../subject.php?error=upload-success");
    exit();
}

$connection->close();
