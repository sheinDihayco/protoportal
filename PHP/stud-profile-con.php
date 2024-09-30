<?php

include_once "../templates/header3.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

if (isset($_POST['stud_id']) && !empty($_POST['stud_id'])) {
  $_SESSION['stud'] = $_POST['stud_id'];
  $studid = $_POST['stud_id'];
} elseif (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
  $_SESSION['stud'] = $_GET['user_id'];
  $studid = $_GET['user_id'];
} elseif (isset($_SESSION['stud']) && !empty($_SESSION['stud'])) {
  $studid = $_SESSION['stud'];
} else {
  exit('No student ID provided');
}

// Fetch student details and user image
$statement = $conn->prepare("SELECT user_id FROM tbl_students WHERE user_id = :sid");
$statement->bindParam(':sid', $studid, PDO::PARAM_INT);
$statement->execute();
$studs = $statement->fetch(PDO::FETCH_ASSOC);

if ($studs) {
  $userid = $studs['user_id'];

  // Fetch the user image from tbl_users
  $statementUser = $conn->prepare("SELECT user_image, lname FROM tbl_students WHERE user_id = :userid");
  $statementUser->bindParam(':userid', $userid, PDO::PARAM_INT);
  $statementUser->execute();
  $user = $statementUser->fetch(PDO::FETCH_ASSOC);

  if ($user && !empty($user["user_image"])) {
    $image = htmlspecialchars($user["user_image"]);
  } else {
    $image = "default.png";  // Set to default image if user doesn't have an image
  }

  // Get the student's last name
  $lname = htmlspecialchars($user["lname"]);
} else {
  exit('Student not found');
}

try {
  // Fetch student details
  $statement = $conn->prepare("SELECT * FROM tbl_students WHERE user_id = :sid");
  $statement->bindParam(':sid', $studid, PDO::PARAM_STR);
  $statement->execute();
  $studs = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo 'Query failed: ' . $e->getMessage();
}

// Connection to the database for fetching grades
$database = new Connection();
$db = $database->open();

$grades = []; // Initialize as an empty array

try {
  // Query to fetch grades with description and code
  $sql = "SELECT g.grade, g.term, s.code AS subject_code, s.description
        FROM tbl_grades g
        LEFT JOIN tbl_subjects s ON g.id = s.id
        WHERE g.user_id = :sid
        ORDER BY s.code ASC";

  $stmt = $db->prepare($sql);
  $stmt->bindParam(':sid', $studid, PDO::PARAM_STR);
  $stmt->execute();
  $grades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "There was an error fetching grades: " . $e->getMessage();
}
$database->close();
?>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
if (isset($_SESSION['student_updated']) && $_SESSION['student_updated']) {
    echo "
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Information Updated',
                text: 'Information successfully updated!',
                showConfirmButton: false,
                timer: 5000
            });
        });
    </script>";
    unset($_SESSION['student_updated']); // Clear the session variable after use
}
?>


<!-- Add custom CSS to remove underlines -->
<style>
  a {
    text-decoration: none !important;
  }

  .breadcrumb-item a {
    text-decoration: none !important;
  }

  .breadcrumb-item.active {
    text-decoration: none;
  }

  .navbar-brand {
    text-decoration: none !important;
  }
</style>