<?php
// Database connection
include_once "includes/connection.php";
$connection = new Connection();
$pdo = $connection->open();

// Fetch subjects for BSIT course ordered by year and semester
$sql = "SELECT * FROM tbl_subjects WHERE course = 'BSIT' ORDER BY year ASC, semester ASC";
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


<style>
  .section {
    padding: 20px;
    border: 1px solid #dcdcdc;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }

  .dashboard {
    max-width: 1200px;
    margin: auto;
  }


  h4 {
    font-size: 1.4rem;
    color: #004080;
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-weight: bold;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }

  th,
  td {
    padding: 12px;
    text-align: left;
    border: 1px solid #e0e0e0;
  }

  th {
    background-color: #f5f5f5;
    color: #333;
    font-weight: bold;
    text-align: center;
  }

  tbody tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tbody tr:hover {
    background-color: #f1f1f1;
  }

  p {
    font-size: 1.2rem;
    color: #666;
  }
</style>
