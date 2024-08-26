<?php
include("../includes/connect.php");
include("../includes/connection.php");

$connection = new Connection();
$pdo = $connection->open();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $id = $_POST['id']; // Get the subject ID from the hidden input field
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

    // Update the existing subject data in the database
    $sql = "UPDATE tbl_subjects 
            SET year = :year, semester = :semester, code = :code, description = :description, 
                lec = :lec, lab = :lab, unit = :unit, pre_req = :pre_req, total = :total, course = :course 
            WHERE id = :id";
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
        ':course' => $course,
        ':id' => $id // Bind the subject ID to identify which record to update
    ]);

    // Redirect to subject.php after successful update
    $_SESSION['subject_updated'] = true;
    header("Location: ../subject.php?status=update-success");
    exit();
}

$connection->close();
