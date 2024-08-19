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

<main id="main" class="main">
  <div class="pagetitle">
    <?php if ($studs) : ?>
      <h1><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?></h1>

      <?php if ($showButton): ?>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent"></button>
      <?php endif; ?>

      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><?php echo htmlspecialchars($studs["course"]); ?></li>
        </ol>
      </nav>
    <?php else : ?>
      <h1>No ID Found</h1>
    <?php endif; ?>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="col-lg-12">
      <div class="row">
        <div class="card">
          <div class="card-body pt-3">
            <ul class="nav nav-tabs nav-tabs-bordered">
              <button type="button" class="icon-button">
                <a href="../admin/studentRecords.php" class="icon-link">
                  <i class="ri-arrow-go-back-line"></i>
                </a>
              </button>

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-grades">Grades</button>
              </li>

            </ul>

            <div class="tab-pane fade show active" id="profile-grades">
              <div class="card-body">
                <table class="table table-striped datatable">
                  <thead>
                    <tr>
                      <th scope="col">Subject Code</th>
                      <th scope="col">Description</th>
                      <th scope="col">Prelim</th>
                      <th scope="col">Midterm</th>
                      <th scope="col">Pre-final</th>
                      <th scope="col">Final</th>
                      <th scope="col">Remarks</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if (is_array($grades) && count($grades) > 0):
                      $grades_by_subject = [];

                      foreach ($grades as $row) {
                        $subject_code = $row['subject_code'];
                        $term = $row['term'];
                        $grade = $row['grade'];

                        if (!isset($grades_by_subject[$subject_code])) {
                          $grades_by_subject[$subject_code] = [
                            'description' => $row['description'],
                            'Prelim' => '-',
                            'Midterm' => '-',
                            'Pre-final' => '-',
                            'Final' => '-'
                          ];
                        }

                        $grades_by_subject[$subject_code][$term] = $grade;
                      }

                      foreach ($grades_by_subject as $subject_code => $subject_grades): ?>
                        <tr>
                          <td><?php echo htmlspecialchars($subject_code); ?></td>
                          <td><?php echo htmlspecialchars($subject_grades['description']); ?></td>
                          <td><?php echo htmlspecialchars($subject_grades['Prelim']); ?></td>
                          <td><?php echo htmlspecialchars($subject_grades['Midterm']); ?></td>
                          <td><?php echo htmlspecialchars($subject_grades['Pre-final']); ?></td>
                          <td><?php echo htmlspecialchars($subject_grades['Final']); ?></td>
                          <td>
                            <?php
                            $total_grade = 0;
                            $grade_count = 0;

                            foreach (['Prelim', 'Midterm', 'Pre-final', 'Final'] as $term) {
                              if ($subject_grades[$term] !== '-') {
                                $total_grade += $subject_grades[$term];
                                $grade_count++;
                              }
                            }

                            if ($grade_count > 0) {
                              $final_grade = $total_grade / $grade_count;
                              echo $final_grade <= 3.0 ? 'PASSED' : 'FAILED';
                            } else {
                              echo 'N/A';
                            }
                            ?>
                          </td>
                        </tr>
                      <?php endforeach;
                    else: ?>
                      <tr>
                        <td colspan="7">No grades found.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>


          </div>
        </div>
      </div>
    </div>
  </section>
</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>

<style>
  .icon-button {
    border: none;
    background: transparent;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
  }

  .icon-link {
    color: black;
    text-decoration: none;
    display: flex;
    align-items: center;
  }

  .icon-button i {
    font-size: 20px;
  }
</style>