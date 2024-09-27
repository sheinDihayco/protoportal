<?php

if (isset($_POST['stud_id']) && !empty($_POST['stud_id'])) {
  $_SESSION['stud'] = $_POST['stud_id'];
}

if (isset($_SESSION['stud']) && !empty($_SESSION['stud'])) {
  $studid = $_SESSION['stud'];
} else {
  exit('No student ID provided');
}

include_once "../templates/header.php";
include_once "includes/connect.php";
include_once "includes/connection.php";

try {
  // Fetching student details from tbl_students
  $statement = $conn->prepare("SELECT * FROM tbl_students WHERE user_id = :sid");
  $statement->bindParam(':sid', $studid, PDO::PARAM_INT);
  $statement->execute();
  $studs = $statement->fetch(PDO::FETCH_ASSOC);

  if ($studs) {
    $userid = $studs['user_id'];

    $statementUser = $conn->prepare("SELECT user_image FROM tbl_users WHERE user_id = :userid");
    $statementUser->bindParam(':userid', $userid, PDO::PARAM_INT);
    $statementUser->execute();
    $user = $statementUser->fetch(PDO::FETCH_ASSOC);

    $userImage = $user && !empty($user["user_image"]) ? htmlspecialchars($user["user_image"]) : "default.jpg";

    // Check if the studentID has a record in tbl_payments
    $paymentStmt = $conn->prepare("SELECT COUNT(*) AS count_payments FROM tbl_payments WHERE user_id = :user_id");
    $paymentStmt->bindParam(':user_id', $studid, PDO::PARAM_INT);
    $paymentStmt->execute();
    $paymentCount = $paymentStmt->fetch(PDO::FETCH_ASSOC);

    $showButton = ($paymentCount['count_payments'] == 0);
  } else {
    exit('Student not found');
  }
} catch (PDOException $e) {
  echo 'Query failed: ' . $e->getMessage();
  exit;
}

// Connection to the database for fetching grades
$database = new Connection();
$db = $database->open();

$grades = []; // Initialize as an empty array

try {
  $sql = "SELECT g.grade, g.term, s.code AS subject_code, s.description
          FROM tbl_grades g
          LEFT JOIN tbl_subjects s ON g.id = s.id
          WHERE g.user_id = :sid
          ORDER BY s.code ASC";

  $stmt = $db->prepare($sql);
  $stmt->bindParam(':sid', $studid, PDO::PARAM_INT);
  $stmt->execute();
  $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "There was an error fetching grades: " . $e->getMessage();
}
?>