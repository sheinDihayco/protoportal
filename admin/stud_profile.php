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

              <div class="tab-pane fade" id="profile-overview" style="padding: 50px;">

                <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                  <img src="upload-files/<?php echo htmlspecialchars($image); ?>" onerror="this.src='images/default.png'" alt="Profile Image" class="rounded-circle">
                  <h2><?php echo $fname . ' ' . $lname; ?></h2>
                  <h3><?php echo htmlspecialchars($studs["course"]); ?> - <?php echo htmlspecialchars($studs["major"]); ?></h3>
                  <!-- <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                      Profile Options
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>-->

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


              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <!-- Profile Edit Form -->
                <form action="upload/insert-student-rec.php" method="post" novalidate>


                  <div class="row mb-3">
                    <div class=" col-md-8">
                      <label for="user_id" class="col-sm-2 col-form-label">User ID</label>
                      <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo htmlspecialchars($studs["user_id"]); ?>" required>
                    </div>

                    <div class="row mb-3">
                      <div class=" col-md-8 col-lg-9">
                        <label for="user_name" class="col-sm-2 col-form-label">Student ID</label>
                        <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo htmlspecialchars($studs["user_name"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="lname" class="col-sm-2 col-form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" value="<?php echo htmlspecialchars($studs["lname"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="fname" class="col-sm-2 col-form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="<?php echo htmlspecialchars($studs["fname"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="middleInitial" class="form-label">Middle Initial</label>
                        <input type="text" class="form-control" id="middleInitial" name="middleInitial" value="<?php echo htmlspecialchars($studs["middleInitial"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="Suffix" class="form-label">Suffix</label>
                        <input type="text" class="form-control" id="Suffix" name="Suffix" name="middleInitial" value="<?php echo htmlspecialchars($studs["Suffix"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="course" class="col-sm-2 col-form-label">Course</label>
                        <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($studs["course"]); ?>" required>
                      </div>
                    </div>

                    <div class=" row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="year" class="col-sm-2 col-form-label">Year</label>
                        <input type="text" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($studs["year"]); ?>" required>
                      </div>
                    </div>

                    <div class=" row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="gender" class="col-sm-2 col-form-label">Gender</label>
                        <select class="form-control" id="gender" name="gender" required>
                          <option disabled value="">Select Gender</option>
                          <option <?php echo htmlspecialchars($studs["gender"] == "Male") ? 'selected' : ''; ?>>Male</option>
                          <option <?php echo htmlspecialchars($studs["gender"] == "Female") ? 'selected' : ''; ?>>Female</option>
                        </select>
                      </div>
                    </div>


                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="bdate" class="col-sm-2 col-form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="bdate" name="bdate" value="<?php echo htmlspecialchars($studs["bdate"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="pob" class="col-sm-2 col-form-label">Place of Birth</label>
                        <input type="text" class="form-control" id="pob" name="pob" value="<?php echo htmlspecialchars($studs["pob"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class=" col-md-8 col-lg-9">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($studs["email"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="major" class="col-sm-2 col-form-label">Major</label>
                        <input type="text" class="form-control" id="major" name="major" value="<?php echo htmlspecialchars($studs["major"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class=" col-md-8 col-lg-9">
                        <label for="nationality" class="col-sm-2 col-form-label">Nationality</label>
                        <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo htmlspecialchars($studs["nationality"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9 ">
                        <label for="civilStatus" class="col-sm-2 col-form-label">Civil Status</label>
                        <input type="text" class="form-control" id="civilStatus" name="civilStatus" value="<?php echo htmlspecialchars($studs["civilStatus"]); ?>" required>
                      </div>
                    </div>

                    <div class=" row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="religion" class="col-sm-2 col-form-label">Religion</label>
                        <input type="text" class="form-control" id="religion" name="religion" value="<?php echo htmlspecialchars($studs["religion"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="modality" class="col-sm-2 col-form-label">Modality</label>
                        <input type="text" class="form-control" id="modality" name="modality" value="<?php echo htmlspecialchars($studs["modality"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="fb" class="col-sm-2 col-form-label">Facebook Account</label>
                        <input type="text" class="form-control" id="fb" name="fb" value="<?php echo htmlspecialchars($studs["fb"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="curAddress" class="col-sm-2 col-form-label">Current Address</label>
                        <input type="text" class="form-control" id="curAddress" name="curAddress" value="<?php echo htmlspecialchars($studs["curAddress"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="cityAdd" class="col-sm-2 col-form-label">City Address</label>
                        <input type="text" class="form-control" id="cityAdd" name="cityAdd" placeholder="(Barangay, Town or City, Province, Country)" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="zipcode" class="col-sm-2 col-form-label">Zip Code</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo htmlspecialchars($studs["contact"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="fatherName" class="col-sm-2 col-form-label">Father's Name</label>
                        <input type="text" class="form-control" id="fatherName" name="fatherName" value="<?php echo htmlspecialchars($studs["fatherName"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="fwork" class="col-sm-2 col-form-label">Father's Occupation</label>
                        <input type="text" class="form-control" id="fwork" name="fwork" value="<?php echo htmlspecialchars($studs["fwork"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="motherName" class="col-sm-2 col-form-label">Mother's Name</label>
                        <input type="text" class="form-control" id="motherName" name="motherName" value="<?php echo htmlspecialchars($studs["motherName"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="mwork" class="col-sm-2 col-form-label">Mother's Occupation</label>
                        <input type="text" class="form-control" id="mwork" name="mwork" value="<?php echo htmlspecialchars($studs["mwork"]); ?>" required>
                      </div>
                    </div>
                    <!-- Educational Background Sections -->
                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <h5 class="card-title" style="margin:5%; text-align:center">Educational Background</h5>
                      </div>
                    </div>

                    <p class="card-title" style="margin-top: -3%;">Primary (Grade 1 - 4)</p>
                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="primarySchool" class="col-sm-2 col-form-label">Name of School</label>
                        <input type="text" class="form-control" id="primarySchool" name="primarySchool" value="<?php echo htmlspecialchars($studs["primarySchool"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="primaryAddress" class="col-sm-2 col-form-label">School Address</label>
                        <input type="text" class="form-control" id="primaryAddress" name="primaryAddress" value="<?php echo htmlspecialchars($studs["primaryAddress"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="primaryCompleted" class="col-sm-2 col-form-label">Completed</label>
                        <input type="text" class="form-control" id="primaryCompleted" name="primaryCompleted" value="<?php echo htmlspecialchars($studs["primaryCompleted"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <p class="card-title" style="margin-top: 2%;">Intermediate (Grade 5 - 6)</p>
                      <div class="col-md-8">
                        <label for="entermediateSchool" class="col-sm-2 col-form-label">Name of School</label>
                        <input type="text" class="form-control" id="entermediateSchool" name="entermediateSchool" value="<?php echo htmlspecialchars($studs["entermediateSchool"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-6 col-lg-9">
                        <label for="entermediateAddress" class="col-sm-2 col-form-label">School Address</label>
                        <input type="text" class="form-control" id="entermediateAddress" name="entermediateAddress" value="<?php echo htmlspecialchars($studs["entermediateAddress"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-2 col-lg-9">
                        <label for="entermediateCompleted" class="col-sm-2 col-form-label">Completed</label>
                        <input type="text" class="form-control" id="entermediateCompleted" name="entermediateCompleted" value="<?php echo htmlspecialchars($studs["entermediateCompleted"]); ?>" required>
                      </div>
                    </div>


                    <p class="card-title" style="margin-top: 2%;">High School</p>
                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="hsSchool" class="col-sm-2 col-form-label">Name of School</label>
                        <input type="text" class="form-control" id="hsSchool" name="hsSchool" value="<?php echo htmlspecialchars($studs["hsSchool"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-6 col-lg-9">
                        <label for="hsAddress" class="col-sm-2 col-form-label">School Address</label>
                        <input type="text" class="form-control" id="hsAddress" name="hsAddress" value="<?php echo htmlspecialchars($studs["hsAddress"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-2 col-lg-9">
                        <label for="hsCompleted" class="col-sm-2 col-form-label">Completed</label>
                        <input type="text" class="form-control" id="hsCompleted" name="hsCompleted" value="<?php echo htmlspecialchars($studs["hsCompleted"]); ?>" required>
                      </div>
                    </div>

                    <p class="card-title" style="margin-top: 2%;">K12</p>
                    <div class="row mb-3">

                      <div class="col-md-8 col-lg-9">
                        <label for="shSchool" class="col-sm-2 col-form-label">Name of School</label>
                        <input type="text" class="form-control" id="shSchool" name="shSchool" value="<?php echo htmlspecialchars($studs["shSchool"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-6 col-lg-9">
                        <label for="shAddress" class="col-sm-2 col-form-label">School Address</label>
                        <input type="text" class="form-control" id="shAddress" name="shAddress" value="<?php echo htmlspecialchars($studs["shAddress"]); ?>" required>
                      </div>
                    </div>


                    <div class="row mb-3">

                      <div class="col-md-2 col-lg-9">
                        <label for="shCompleted" class="col-sm-2 col-form-label">Completed</label>
                        <input type="text" class="form-control" id="shCompleted" name="shCompleted" value="<?php echo htmlspecialchars($studs["shCompleted"]); ?>" required>
                      </div>
                    </div>


                    <p class="card-title" style="margin-top: 2%;">College</p>

                    <div class="row mb-3">
                      <div class="col-md-8 col-lg-9">
                        <label for="collegeSchool" class="col-sm-2 col-form-label">Name of School</label>
                        <input type="text" class="form-control" id="collegeSchool" name="collegeSchool" value="<?php echo htmlspecialchars($studs["collegeSchool"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">

                      <div class="col-md-6 col-lg-9">
                        <label for="collegeAddress" class="col-sm-2 col-form-label">School Address</label>
                        <input type="text" class="form-control" id="collegeAddress" name="collegeAddress" value="<?php echo htmlspecialchars($studs["collegeAddress"]); ?>" required>
                      </div>
                    </div>

                    <div class="row mb-3">
                      <div class="col-md-2 col-lg-9">
                        <label for="collegeCompleted" class="col-sm-2 col-form-label">Completed</label>
                        <input type="text" class="form-control" id="collegeCompleted" name="collegeCompleted" value="<?php echo htmlspecialchars($studs["collegeCompleted"]); ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                  </div>
                </form>

                <!-- End Profile Edit Form -->

              </div>


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