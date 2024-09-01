<?php

if (isset($_POST['stud_id']) && !empty($_POST['stud_id'])) {
  $_SESSION['stud'] = $_POST['stud_id'];
}

if (isset($_SESSION['stud']) && !empty($_SESSION['stud'])) {
  $studid = $_SESSION['stud'];
} else {
  exit('No student ID provided');
}

include_once "../templates/header3.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

try {
  // Fetch student details
  $statement = $conn->prepare("SELECT * FROM tbl_students WHERE studentID = :sid");
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
        WHERE g.studentID = :sid
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

<main id="main" class="main">
  <div class="pagetitle">
    <?php if ($studs) : ?>
      <h1><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?></h1>

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
        <!-- Recent Sales -->
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
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

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
              </li>
            </ul>
            <!-- End Bordered Tabs -->

            <div class="tab-content pt-2">
              <div class="tab-pane fade show active" id="payment-status">
                <div class="card-body">

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">Semester</th>
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

                      // Query to fetch students with their payment status for the selected studentID
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

                            <td><?php echo htmlspecialchars($row["payment_status"]) ? htmlspecialchars($row["payment_status"]) : 'Not Available'; ?></td>

                            <td>
                              <button type="button" class=" btn btn-sm btn-warning ri-edit-2-fill"><i class="bi view-list"></i></button>
                            </td>
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

              <!--Start Profile Overview-->
              <div class="tab-pane fade" id="profile-overview">
                <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
                <div class="container my-5">
                  <div class="card shadow-sm">
                    <div class="card-body p-4">
                      <h2 class="text-center mb-3">MICROSYSTEMS INTERNATIONAL INSTITUTE OF TECHNOLOGY, INC.</h2>
                      <p class="text-center">National Highway, Inayagan, City of Naga, Cebu</p>
                      <p class="text-center">Tel. No. (032) 4273630 (Registrar’s Office)</p>
                      <hr class="mb-4">

                      <h3 class="text-center mb-4">Student Personal Data - Enrollment</h3>

                      <form>
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label for="last-name" class="form-label">Last Name:</label>
                            <input type="text" id="last-name" name="last-name" class="form-control" value="<?php echo htmlspecialchars($studs["lname"]); ?>" readonly>
                          </div>
                          <div class="col-md-4">
                            <label for="first-name" class="form-label">First Name:</label>
                            <input type="text" id="first-name" name="first-name" class="form-control" value="<?php echo htmlspecialchars($studs["fname"]); ?>" readonly>
                          </div>
                          <div class="col-md-2">
                            <label for="middleInitial" class="form-label">Middle :</label>
                            <input type="text" id="middleInitial" name="middleInitial" class="form-control" value="<?php echo htmlspecialchars($studs["middleInitial"]); ?>" readonly>
                          </div>
                          <div class="col-md-2">
                            <label for="Suffix" class="form-label">Suffix:</label>
                            <input type="text" id="Suffix" name="Suffix" class="form-control" value="<?php echo htmlspecialchars($studs["Suffix"]); ?>" readonly>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label for="user_name" class="form-label">ID Number:</label>
                            <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo htmlspecialchars($studs["user_name"]); ?>">
                          </div>
                          <div class="col-md-3">
                            <label for="gender" class="form-label">Gender:</label>
                            <select id="gender" name="gender" class="form-select">
                              <option value="M" <?php echo ($studs["gender"] == 'M') ? 'selected' : ''; ?> readonly>M</option>
                              <option value="F" <?php echo ($studs["gender"] == 'F') ? 'selected' : ''; ?> readonly>F</option>
                            </select>
                          </div>
                          <div class="col-md-4">
                            <label for="bdate" class="form-label">Date of Birth:</label>
                            <input type="date" id="bdate" name="bdate" class="form-control" value="<?php echo htmlspecialchars($studs["bdate"]); ?>" readonly>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label for="pob" class="form-label">Place of Birth:</label>
                            <input type="text" id="pob" name="pob" class="form-control" value="<?php echo htmlspecialchars($studs["pob"]) ?>">
                          </div>
                          <div class="col-md-4">
                            <label for="nationality" class="form-label">Nationality :</label>
                            <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo htmlspecialchars($studs["nationality"]); ?>" readonly>
                          </div>
                          <div class="col-md-4">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($studs["email"]); ?>" readonly>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-3">
                            <label for="course" class="form-label">Course:</label>
                            <input type="text" id="course" name="course" class="form-control" value="<?php echo htmlspecialchars($studs["course"]); ?>">
                          </div>
                          <div class="col-md-2">
                            <label for="year" class="form-label">Year:</label>
                            <input type="text" id="year" name="year" class="form-control" value="<?php echo htmlspecialchars($studs["year"]); ?>" readonly>
                          </div>
                          <div class="col-md-4">
                            <label for="major" class="form-label">Major :</label>
                            <input type="text" id="major" name="major" class="form-control" value="<?php echo htmlspecialchars($studs["major"]); ?>" readonly>
                          </div>
                          <div class="col-md-3">
                            <label for="civilStatus" class="form-label">Civil Status :</label>
                            <input type="text" id="civilStatus" name="civilStatus" class="form-control" value="<?php echo htmlspecialchars($studs["civilStatus"]); ?>" readonly>
                          </div>

                        </div>

                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label for="religion" class="form-label">Religion:</label>
                            <input type="text" id="religion" name="religion" class="form-control" value="<?php echo htmlspecialchars($studs["religion"]) ?>" readonly>
                          </div>
                          <div class="col-md-4">
                            <label for="modality" class="form-label">Modality :</label>
                            <input type="text" id="modality" name="modality" class="form-control" value="<?php echo htmlspecialchars($studs["modality"]); ?>" readonly>
                          </div>
                          <div class="col-md-4">
                            <label for="fb" class="form-label">Facebook Account:</label>
                            <input type="text" id="fb" name="fb" class="form-control" value="<?php echo htmlspecialchars($studs["fb"]); ?>" readonly>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label for="curAddress" class="form-label">Current Address:</label>
                            <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" readonly>
                          </div>
                          <div class="col-md-3">
                            <label for="cityAdd" class="form-label">City :</label>
                            <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>" readonly>
                          </div>
                          <div class="col-md-3">
                            <label for="zipcode" class="form-label">Zip Code :</label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" readonly>
                          </div>
                          <div class="col-md-2">
                            <label for="contact" class="form-label">Phone Number :</label>
                            <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" readonly>
                          </div>

                        </div>
                        <div style="margin-top: 5%;"></div>
                        <div class="row mb-3">
                          <div class="col-md-4">
                            <label for="curAddress" class="form-label">Permanent Address:</label>
                            <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" readonly>
                          </div>
                          <div class="col-md-3">
                            <label for="cityAdd" class="form-label">City :</label>
                            <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>" readonly>
                          </div>
                          <div class="col-md-3">
                            <label for="zipcode" class="form-label">Zip Code :</label>
                            <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" readonly>
                          </div>
                          <div class="col-md-2">
                            <label for="contact" class="form-label">Phone Number :</label>
                            <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" readonly>
                          </div>

                        </div>

                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label for="fatherName" class="form-label">Father's Name:</label>
                            <input type="text" id="fatherName" name="fatherName" class="form-control" value="<?php echo htmlspecialchars($studs["fatherName"]); ?>" readonly>
                          </div>
                          <div class="col-md-6">
                            <label for="fwork" class="form-label">Occupation:</label>
                            <input type="text" id="fwork" name="fwork" class="form-control" value="<?php echo htmlspecialchars($studs["fwork"]); ?>" readonly>
                          </div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-md-6">
                            <label for="motherName" class="form-label">Mother's Name:</label>
                            <input type="text" id="motherName" name="motherName" class="form-control" value="<?php echo htmlspecialchars($studs["motherName"]); ?>" readonly>
                          </div>
                          <div class="col-md-6">
                            <label for="mwork" class="form-label">Occupation:</label>
                            <input type="text" id="mwork" name="mwork" class="form-control" value="<?php echo htmlspecialchars($studs["mwork"]); ?>" readonly>
                          </div>
                        </div>

                        <h3 class="text-center mb-4">Educational Attainment</h3>

                        <table class="table table-bordered" readonly>
                          <thead>
                            <tr class="table-secondary">
                              <th>Level</th>
                              <th>Name of School</th>
                              <th>School Address</th>
                              <th>Year Completed</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>Primary (Grade 1-4)</td>
                              <td><input type="text" name="primarySchool" class="form-control" value="<?php echo htmlspecialchars($studs["primarySchool"]); ?>" readonly></td>
                              <td><input type="text" name="primaryAddress" class="form-control" value="<?php echo htmlspecialchars($studs["primaryAddress"]); ?>" readonly></td>
                              <td><input type="text" name="primaryCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["primaryCompleted"]); ?>" readonly></td>
                            </tr>
                            <tr>
                              <td>Intermediate (Grade 5-6)</td>
                              <td><input type="text" name="entermediateSchool" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateSchool"]); ?>" readonly></td>
                              <td><input type="text" name="entermediateAddress" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateAddress"]); ?>" readonly></td>
                              <td><input type="text" name="entermediateCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateCompleted"]); ?>" readonly></td>
                            </tr>
                            <tr>
                              <td>High School</td>
                              <td><input type="text" name="hsSchool" class="form-control" value="<?php echo htmlspecialchars($studs["hsSchool"]); ?>" readonly></td>
                              <td><input type="text" name="hsAddress" class="form-control" value="<?php echo htmlspecialchars($studs["hsAddress"]); ?>" readonly></td>
                              <td><input type="text" name="hsCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["hsCompleted"]); ?>" readonly></td>
                            </tr>
                            <tr>
                              <td>K12</td>
                              <td><input type="text" name="shSchool" class="form-control" value="<?php echo htmlspecialchars($studs["shSchool"]); ?>" readonly></td>
                              <td><input type="text" name="shAddress" class="form-control" value="<?php echo htmlspecialchars($studs["shAddress"]); ?>" readonly></td>
                              <td><input type="text" name="shCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["shCompleted"]); ?>" readonly></td>
                            </tr>
                          </tbody>
                        </table>
                        <div style="margin-top: 10%"></div>
                        <h6 class="text-justify mb-4">I hereby certify that all entries herein are true and correct. I certify further that I will read thoroughly the agreement/policy and commit myself to follow its provision.</h6>

                        <div class="row mb-3">

                          <div class="col-md-4">
                            <label for="date" class="form-label">Date Enrolled: </label>
                            <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($studs["date"]); ?>">
                          </div>


                        </div>

                        <!-- <div class="d-flex justify-content-end">
                          <button type="submit" class="btn btn-primary">Update</button>
                        </div>-->
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--End Profile Overview-->

              <!--Start Grades Overview-->
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
              <!--End Grades Overview-->

              <!--Start Profile Edit-->
              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <div class="row mb-3">
                  <div class="container my-5">
                    <div class="card shadow-sm">
                      <div class="card-body p-4">
                        <h2 class="text-center mb-3">MICROSYSTEMS INTERNATIONAL INSTITUTE OF TECHNOLOGY, INC.</h2>
                        <p class="text-center">National Highway, Inayagan, City of Naga, Cebu</p>
                        <p class="text-center">Tel. No. (032) 4273630 (Registrar’s Office)</p>
                        <hr class="mb-4">

                        <h3 class="text-center mb-4">Student Personal Data - Enrollment</h3>

                        <form action="upload/insert-student-rec.php" method="post" novalidate>
                          <div class="row mb-3">
                            <div class="col-md-1">
                              <label for="user_id" class="form-label">ID:</label>
                              <input type="text" id="user_id" name="user_id" class="form-control" value="<?php echo htmlspecialchars($studs["user_id"]); ?>" required>
                            </div>

                            <div class="col-md-4">
                              <label for="lname" class="form-label">Last Name:</label>
                              <input type="text" id="lname" name="lname" class="form-control" value="<?php echo htmlspecialchars($studs["lname"]); ?>" required>
                            </div>
                            <div class="col-md-4">
                              <label for="fname" class="form-label">First Name:</label>
                              <input type="text" id="fname" name="fname" class="form-control" value="<?php echo htmlspecialchars($studs["fname"]); ?>" required>
                            </div>
                            <div class="col-md-2">
                              <label for="middleInitial" class="form-label">Middle :</label>
                              <input type="text" id="middleInitial" name="middleInitial" class="form-control" value="<?php echo htmlspecialchars($studs["middleInitial"]); ?>" required>
                            </div>
                            <div class="col-md-1">
                              <label for="Suffix" class="form-label">Suffix:</label>
                              <input type="text" id="Suffix" name="Suffix" class="form-control" value="<?php echo htmlspecialchars($studs["Suffix"]); ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="user_name" class="form-label">ID Number:</label>
                              <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo htmlspecialchars($studs["user_name"]); ?>" required>
                            </div>
                            <div class="col-md-3">
                              <label for="gender" class="form-label">Gender:</label>
                              <select id="gender" name="gender" class="form-select">
                                <option value="M" <?php echo ($studs["gender"] == 'M') ? 'selected' : ''; ?>required>M</option>
                                <option value="F" <?php echo ($studs["gender"] == 'F') ? 'selected' : ''; ?>required>F</option>
                              </select>
                            </div>
                            <div class="col-md-4">
                              <label for="bdate" class="form-label">Date of Birth:</label>
                              <input type="date" id="bdate" name="bdate" class="form-control" value="<?php echo htmlspecialchars($studs["bdate"]); ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="pob" class="form-label">Place of Birth:</label>
                              <input type="text" id="pob" name="pob" class="form-control" value="<?php echo htmlspecialchars($studs["pob"]) ?>" required>
                            </div>
                            <div class="col-md-4">
                              <label for="nationality" class="form-label">Nationality :</label>
                              <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo htmlspecialchars($studs["nationality"]); ?>" required>
                            </div>
                            <div class="col-md-4">
                              <label for="email" class="form-label">Email Address:</label>
                              <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($studs["email"]); ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-3">
                              <label for="course" class="form-label">Course:</label>
                              <input type="text" id="course" name="course" class="form-control" value="<?php echo htmlspecialchars($studs["course"]); ?>" required>
                            </div>
                            <div class="col-md-2">
                              <label for="year" class="form-label">Year:</label>
                              <input type="text" id="year" name="year" class="form-control" value="<?php echo htmlspecialchars($studs["year"]); ?>" required>
                            </div>
                            <div class="col-md-4">
                              <label for="major" class="form-label">Major :</label>
                              <input type="text" id="major" name="major" class="form-control" value="<?php echo htmlspecialchars($studs["major"]); ?>" required>
                            </div>
                            <div class="col-md-3">
                              <label for="civilStatus" class="form-label">Civil Status :</label>
                              <input type="text" id="civilStatus" name="civilStatus" class="form-control" value="<?php echo htmlspecialchars($studs["civilStatus"]); ?>" required>
                            </div>

                          </div>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="religion" class="form-label">Religion:</label>
                              <input type="text" id="religion" name="religion" class="form-control" value="<?php echo htmlspecialchars($studs["religion"]) ?>" required>
                            </div>
                            <div class="col-md-4">
                              <label for="modality" class="form-label">Modality :</label>
                              <input type="text" id="modality" name="modality" class="form-control" value="<?php echo htmlspecialchars($studs["modality"]); ?>" required>
                            </div>
                            <div class="col-md-4">
                              <label for="fb" class="form-label">Facebook Account:</label>
                              <input type="text" id="fb" name="fb" class="form-control" value="<?php echo htmlspecialchars($studs["fb"]); ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-4">
                              <label for="curAddress" class="form-label">Current Address:</label>
                              <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" required>
                            </div>
                            <div class="col-md-3">
                              <label for="cityAdd" class="form-label">City :</label>
                              <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>" required>
                            </div>
                            <div class="col-md-3">
                              <label for="zipcode" class="form-label">Zip Code :</label>
                              <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" required>
                            </div>
                            <div class="col-md-2">
                              <label for="contact" class="form-label">Phone Number :</label>
                              <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" required>
                            </div>

                          </div>
                          <div style="margin-top: 5%;"></div>
                          <div class="row mb-3">
                            <div class="col-md-4" required>
                              <label for="curAddress" class="form-label">Permanent Address:</label>
                              <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" required>
                            </div>
                            <div class="col-md-3">
                              <label for="cityAdd" class="form-label">City :</label>
                              <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>">
                            </div>
                            <div class="col-md-3">
                              <label for="zipcode" class="form-label">Zip Code :</label>
                              <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" required>
                            </div>
                            <div class="col-md-2">
                              <label for="contact" class="form-label">Phone Number :</label>
                              <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" required>
                            </div>

                          </div>

                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="fatherName" class="form-label">Father's Name:</label>
                              <input type="text" id="fatherName" name="fatherName" class="form-control" value="<?php echo htmlspecialchars($studs["fatherName"]); ?>" required>
                            </div>
                            <div class="col-md-6">
                              <label for="fwork" class="form-label">Occupation:</label>
                              <input type="text" id="fwork" name="fwork" class="form-control" value="<?php echo htmlspecialchars($studs["fwork"]); ?>" required>
                            </div>
                          </div>

                          <div class="row mb-3">
                            <div class="col-md-6">
                              <label for="motherName" class="form-label">Mother's Name:</label>
                              <input type="text" id="motherName" name="motherName" class="form-control" value="<?php echo htmlspecialchars($studs["motherName"]); ?>" required>
                            </div>
                            <div class="col-md-6">
                              <label for="mwork" class="form-label">Occupation:</label>
                              <input type="text" id="mwork" name="mwork" class="form-control" value="<?php echo htmlspecialchars($studs["mwork"]); ?>" required>
                            </div>
                          </div>

                          <h3 class="text-center mb-4">Educational Attainment</h3>

                          <table class="table table-bordered">
                            <thead>
                              <tr class="table-secondary">
                                <th>Level</th>
                                <th>Name of School</th>
                                <th>School Address</th>
                                <th>Year Completed</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Primary (Grade 1-4)</td>
                                <td><input type="text" name="primarySchool" class="form-control" value="<?php echo htmlspecialchars($studs["primarySchool"]); ?>" required></td>
                                <td><input type="text" name="primaryAddress" class="form-control" value="<?php echo htmlspecialchars($studs["primaryAddress"]); ?>" required></td>
                                <td><input type="text" name="primaryCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["primaryCompleted"]); ?>" required></td>
                              </tr>
                              <tr>
                                <td>Intermediate (Grade 5-6)</td>
                                <td><input type="text" name="entermediateSchool" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateSchool"]); ?>" required></td>
                                <td><input type="text" name="entermediateAddress" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateAddress"]); ?>" required></td>
                                <td><input type="text" name="entermediateCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateCompleted"]); ?>" required></td>
                              </tr>
                              <tr>
                                <td>High School</td>
                                <td><input type="text" name="hsSchool" class="form-control" value="<?php echo htmlspecialchars($studs["hsSchool"]); ?>" required></td>
                                <td><input type="text" name="hsAddress" class="form-control" value="<?php echo htmlspecialchars($studs["hsAddress"]); ?>" required></td>
                                <td><input type="text" name="hsCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["hsCompleted"]); ?>" required></td>
                              </tr>
                              <tr>
                                <td>K12</td>
                                <td><input type="text" name="shSchool" class="form-control" value="<?php echo htmlspecialchars($studs["shSchool"]); ?>" required></td>
                                <td><input type="text" name="shAddress" class="form-control" value="<?php echo htmlspecialchars($studs["shAddress"]); ?>" required></td>
                                <td><input type="text" name="shCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["shCompleted"]); ?>" required></td>
                              </tr>
                            </tbody>
                          </table>
                          <div style="margin-top: 10%"></div>
                          <h6 class="text-justify mb-4">I hereby certify that all entries herein are true and correct. I certify further that I will read thoroughly the agreement/policy and commit myself to follow its provision.</h6>

                          <div class="row mb-3">

                            <div class="col-md-4">
                              <label for="date" class="form-label">Date: </label>
                              <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($studs["date"]); ?>" required>
                            </div>


                          </div>

                          <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" name="submit">Save</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--End Profile Edit-->

              <!--Start Profile Change Password-->
              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form action="../admin/includes/change-pass.php" method="post">

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newPassword" type="password" class="form-control" id="newPassword" required>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewPassword" type="password" class="form-control" id="renewPassword" required>
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form>
                <!-- End Change Password Form -->
              </div>
              <!--Start Profile Change Password-->

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