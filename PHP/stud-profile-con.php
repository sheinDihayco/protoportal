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

<!-- Styles to make the page responsive -->
<style>
/* Table responsiveness */
.table-responsive {
  overflow-x: auto;
}

/* Responsive font sizes for better readability */
.pagetitle h1 {
  font-size: 2rem;
}

@media (max-width: 1200px) {
  .pagetitle h1 {
    font-size: 1.8rem;
  }

  .table th, .table td {
    font-size: 0.9rem;
  }
}

@media (max-width: 992px) {
  .pagetitle h1 {
    font-size: 1.6rem;
  }

  .table th, .table td {
    font-size: 0.85rem;
  }
}

@media (max-width: 768px) {
  .pagetitle h1 {
    font-size: 1.5rem;
  }

  .table th, .table td {
    font-size: 0.8rem;
  }
}

@media (max-width: 576px) {
  .pagetitle h1 {
    font-size: 1.3rem;
  }

  .table th, .table td {
    font-size: 0.75rem;
  }
}
  .badge-success {
    background-color: green;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    display: inline-block;
  }

  .badge-danger {
    background-color: red;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    display: inline-block;
  }

  .badge-secondary {
    background-color: gray;
    color: white;
    padding: 5px 10px;
    border-radius: 20px;
    display: inline-block;
  }
  /* Warning badge (Pending) */
  .badge-warning {
      background-color: orange;
      color: white;
      padding: 5px 10px;
      border-radius: 20px;
      display: inline-block;
  }

    .card-title {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
    }

    .info-row {
        display: flex;
        justify-content: space-between;  /* Spaces the items between left and right */
        margin-bottom: 8px; /* Space between rows */
    }

    .info-item {
        display: flex;
        align-items: center;
        flex-basis: 45%; /* Make sure each item takes up equal space */
    }

    .info-item strong {
        margin-right: 10px; /* Space between label and value */
    }

    /* Optional: Responsive design for smaller screens */
    @media (max-width: 768px) {
        .info-row {
            flex-direction: column; /* Stack the rows vertically */
            align-items: flex-start;
        }

        .info-item {
            flex-basis: 100%;  /* Make each item take the full width */
        }
    }
</style>
