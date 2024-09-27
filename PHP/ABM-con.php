<?php
// Database connection
include_once "includes/connection.php";
$connection = new Connection();
$pdo = $connection->open();

// Fetch subjects for BSIT course ordered by year and semester
$sql = "SELECT * FROM tbl_subjects WHERE course = 'ABM' ORDER BY year ASC, semester ASC";
$stmt = $pdo->query($sql);

// Fetch all subjects
$subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Close the connection
$connection->close();

// Group subjects by year and semester
$groupedSubjects = [];
foreach ($subjects as $subject) {
  $year = $subject['year'];
  $semester = $subject['semester'];
  if (!isset($groupedSubjects[$year])) {
    $groupedSubjects[$year] = [];
  }
  if (!isset($groupedSubjects[$year][$semester])) {
    $groupedSubjects[$year][$semester] = [];
  }
  $groupedSubjects[$year][$semester][] = $subject;
}

// Fetch student details
$statement = $conn->prepare("SELECT * FROM tbl_students WHERE user_id = :sid");
$statement->bindParam(':sid', $userid, PDO::PARAM_STR);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

?>