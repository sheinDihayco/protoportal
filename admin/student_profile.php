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
  $statement = $conn->prepare("SELECT * FROM tbl_students WHERE studentID = :sid");
  $statement->bindParam(':sid', $studid, PDO::PARAM_INT);
  $statement->execute();
  $studs = $statement->fetch(PDO::FETCH_ASSOC);

  if ($studs) {
    $userid = $studs['user_id'];

    $statementUser = $conn->prepare("SELECT user_image FROM tbl_users WHERE user_id = :userid");
    $statementUser->bindParam(':userid', $userid, PDO::PARAM_INT);
    $statementUser->execute();
    $user = $statementUser->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user["user_image"])) {
      $userImage = htmlspecialchars($user["user_image"]);
    } else {
      $userImage = "default.jpg";
    }

    // Check if the studentID has a record in tbl_payments
    $paymentStmt = $conn->prepare("SELECT COUNT(*) AS count_payments FROM tbl_payments WHERE studentID = :studentID");
    $paymentStmt->bindParam(':studentID', $studid, PDO::PARAM_INT);
    $paymentStmt->execute();
    $paymentCount = $paymentStmt->fetch(PDO::FETCH_ASSOC);

    // Determine if the button should be displayed
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
  // Query to fetch grades with description and code
  $sql = "SELECT g.grade, g.term, s.code AS subject_code, s.description
        FROM tbl_grades g
        LEFT JOIN tbl_subjects s ON g.id = s.id
        WHERE g.studentID = :sid
        ORDER BY s.code ASC";

  $stmt = $db->prepare($sql);
  $stmt->bindParam(':sid', $studid, PDO::PARAM_STR);
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
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
        </button>
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

  <div class="modal fade" id="insertStudent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Insert Payment Status</h5>
        </div>
        <div class="modal-body">
          <form action="../admin/upload/insert-payment-status.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
            <div class="col-md-6">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="number" class="form-control" id="studentID" name="studentID" value="<?php echo htmlspecialchars($studid); ?>" required readonly>
              <div class="invalid-feedback">
                Please enter a valid student ID.
              </div>
            </div>
            <div class="col-md-6">
              <label for="semester" class="form-label">Semester</label>
              <select class="form-select" id="semester" name="semester" required>
                <option value="">Choose...</option>
                <option value="1st">1st</option>
                <option value="2nd">2nd</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="col-md-6">
              <label for="paymentPeriod" class="form-label">Payment Period</label>
              <select class="form-select" id="paymentPeriod" name="paymentPeriod" required>
                <option value="">Choose...</option>
                <option value="Prelim">Prelim</option>
                <option value="Midterm">Midterm</option>
                <option value="Pre-final">Pre-final</option>
                <option value="Final">Final</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="col-md-6">
              <label for="payment_status" class="form-label">Status</label>
              <select class="form-select" id="payment_status" name="payment_status" required>
                <option value="">Choose...</option>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Overdue">Overdue</option>
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <section class="section profile">
    <div class="col-lg-12">
      <div class="row">
        <!-- Recent Sales -->
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <button type="button" class="icon-button">
                <a href="../admin/payment.php" class="icon-link">
                  <i class="ri-arrow-go-back-line"></i>
                </a>
              </button>


              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment-status">Payment Status</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-grades">Grades</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Info</button>
              </li>
            </ul>
            <!-- End Bordered Tabs -->

            <div class="tab-content pt-2">
              <div class="tab-pane fade show active" id="payment-status">
                <div class="card-body">
                  <h5 class="card-title">Students <span>| Enrolled</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Payment Period</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
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

                      $sql = 'SELECT s.*, p.*
                          FROM tbl_students s 
                          LEFT JOIN tbl_payments p ON s.studentID = p.studentID
                          WHERE s.studentID = ?';

                      if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("s", $studid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                      ?>
                          <tr>
                            <th scope="row"><a href=""><?php echo htmlspecialchars($row["studentID"]); ?></a></th>

                            <td><?php echo htmlspecialchars($row["semester"]) ? htmlspecialchars($row["semester"]) : 'Choose semester'; ?></td>

                            <td><?php echo htmlspecialchars($row["paymentPeriod"]) ? htmlspecialchars($row["paymentPeriod"]) : 'Choose payment period'; ?></td>

                            <td><?php echo htmlspecialchars($row["payment_status"]) ? htmlspecialchars($row["payment_status"]) : 'Not Available'; ?></td>

                            <td><button type="button" class="ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#updatePaymentStatus<?php echo $row["studentID"]; ?>"></button></td>
                            <?php include('modals/update-payment-form.php'); ?>
                          </tr>
                      <?php
                        }

                        $stmt->close();
                      } else {
                        echo "Error preparing statement: " . $conn->error;
                      }

                      $conn->close();
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="profile-grades">
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

                        // Organize grades by subject and term
                        foreach ($grades as $row) {
                          if (isset($row['term']) && isset($row['grade'])) {
                            $grades_by_subject[$row['subject_code']][$row['term']] = $row['grade'];
                          }
                          if (isset($row['description'])) {
                            $grades_by_subject[$row['subject_code']]['description'] = $row['description'];
                          }
                        }


                        // Display the organized grades
                        foreach ($grades_by_subject as $subject_code => $subject_grades): ?>
                          <tr>
                            <td><?php echo htmlspecialchars($subject_code); ?></td>
                            <td><?php echo htmlspecialchars($subject_grades['description']); ?></td>
                            <td><?php echo isset($subject_grades['Prelim']) ? htmlspecialchars($subject_grades['Prelim']) : '-'; ?></td>
                            <td><?php echo isset($subject_grades['Midterm']) ? htmlspecialchars($subject_grades['Midterm']) : '-'; ?></td>
                            <td><?php echo isset($subject_grades['Pre-final']) ? htmlspecialchars($subject_grades['Pre-final']) : '-'; ?></td>
                            <td><?php echo isset($subject_grades['Final']) ? htmlspecialchars($subject_grades['Final']) : '-'; ?></td>
                            <td>
                              <?php
                              $total_grade = 0;
                              $grade_count = 0;

                              foreach (['Prelim', 'Midterm', 'Pre-final', 'Final'] as $term) {
                                if (isset($subject_grades[$term])) {
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



              <div class="tab-pane fade" id="profile-overview">
                <h5 class="card-title">Student Profile Details</h5>

                <div class="profile-section">
                  <div class="profile-img">
                    <img src="upload-files/<?php echo htmlspecialchars($user["user_image"]); ?>" alt="Profile Image" class="rounded-circle">
                  </div>
                  <div class="profile-info">
                    <h5><?php echo htmlspecialchars($studs["lname"]); ?> <?php echo htmlspecialchars($studs["fname"]); ?> <?php echo htmlspecialchars($studs["middleInitial"]); ?> <?php echo htmlspecialchars($studs["Suffix"]); ?></h5>
                  </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Course <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["course"]); ?> - <?php echo htmlspecialchars($studs["year"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Major <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["major"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["curAddress"]); ?> <?php echo htmlspecialchars($studs["cityAdd"]); ?> <?php echo htmlspecialchars($studs["zipcode"]); ?> </div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["contact"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["email"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Gender <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["gender"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Date of Birth <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["bdate"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Place of Birth <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["pob"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Nationality <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["nationality"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Civil Status <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["civilStatus"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Religion <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["religion"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Modality <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["modality"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Facebook Account <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["fb"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Father's Name <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["fatherName"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Father's Occupation <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["fwork"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Mother's Name <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["motherName"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Mother's Occupation <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["mwork"]); ?></div>
                </div>

                <p class="card-title" style="margin-top: 1%;">Primary (Grade 1 - 4)</p>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Primary School <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["primarySchool"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Address <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["primaryAddress"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Year Completed <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["primaryCompleted"]); ?></div>
                </div>

                <p class="card-title" style="margin-top: 2%;">Intermediate (Grade 5 - 6)</p>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Name <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["entermediateSchool"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Address <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["entermediateAddress"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Year Completed <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["entermediateCompleted"]); ?></div>
                </div>

                <p class="card-title" style="margin-top: 2%;">High School</p>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Name <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["hsSchool"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Address<span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["hsAddress"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Year Completed <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["hsCompleted"]); ?></div>
                </div>

                <p class="card-title" style="margin-top: 2%;">K12</p>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Name <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["shSchool"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["shAddress"]); ?></div>
                </div>
                <div class="row">
                  <div class="col-lg-3 col-md-4 label"> Year Completed <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["shCompleted"]); ?></div>
                </div>

                <p class="card-title" style="margin-top: 2%;">College</p>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Name <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["collegeSchool"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">School Address <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["collegeAddress"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Year Completed <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["collegeCompleted"]); ?></div>
                </div>

              </div>
            </div>


            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
              <div class="row mb-3">
                <div class="col-md-2 col-lg-9">
                  <label class="col-sm-6 col-form-label">Editing is not permitted on this page.</label>
                </div>
              </div>
            </div>

          </div><!-- End Bordered Tabs -->
        </div>
      </div><!-- End Left side columns -->
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