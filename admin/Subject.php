<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/subject-con.php"; ?>

<main id="main" class="main">

<section>
  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Subject Records</h1>
    <button type="button" class="ri-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#courseModal"> </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Subject</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  
  <!-- Start Search Bar -->
  <div class="container">
      <div class="card">
          <div class="card-body">
              <form id="subjectForm" action="" method="GET" class="row g-3">
                  <!-- Course Selection -->
                  <div class="col-md-3 form-group">
                      <label for="course" class="form-label">Course</label>
                      <select class="form-select" id="course" name="course" oninput="enableNextField('year')" required>
                          <option value="" <?= !isset($_GET['course']) ? 'selected' : '' ?>>Select Course</option>
                          <?php
                          $database = new Connection();
                          $db = $database->open();

                          try {
                              $sql = "SELECT DISTINCT course_description FROM tbl_course";
                              $stmt = $db->prepare($sql);
                              $stmt->execute();
                              foreach ($stmt as $course) {
                                  $selected = (isset($_GET['course']) && $_GET['course'] == $course['course_description']) ? 'selected' : '';
                                  echo '<option value="' . htmlspecialchars($course['course_description']) . '" ' . $selected . '>' . htmlspecialchars($course['course_description']) . '</option>';
                              }
                          } catch (PDOException $e) {
                              echo "<option value='' disabled>Error fetching courses</option>";
                          }

                          $database->close();
                          ?>
                      </select>
                  </div>

                  <!-- Year Selection -->
                  <div class="col-md-3 form-group">
                      <label for="year" class="form-label">Year</label>
                      <select class="form-select" id="year" name="year" oninput="enableNextField('semester')" <?= !isset($_GET['year']) ? 'disabled' : '' ?>>
                          <option value="" <?= !isset($_GET['year']) ? 'selected' : '' ?>>Select</option>
                          <?php
                          $years = [1, 2, 3, 4, 11, 12];
                          foreach ($years as $yr) {
                              $selected = (isset($_GET['year']) && $_GET['year'] == $yr) ? 'selected' : '';
                              echo '<option value="' . $yr . '" ' . $selected . '>' . $yr . '</option>';
                          }
                          ?>
                      </select>
                  </div>

                  <!-- Semester Selection -->
                  <div class="col-md-2 form-group">
                      <label for="semester" class="form-label">Semester</label>
                      <select class="form-select" id="semester" name="semester" <?= !isset($_GET['semester']) ? 'disabled' : '' ?>>
                          <option value="" <?= !isset($_GET['semester']) ? 'selected' : '' ?>>Select</option>
                          <?php
                          $semesters = [1, 2];
                          foreach ($semesters as $sem) {
                              $selected = (isset($_GET['semester']) && $_GET['semester'] == $sem) ? 'selected' : '';
                              echo '<option value="' . $sem . '" ' . $selected . '>' . $sem . '</option>';
                          }
                          ?>
                      </select>
                  </div>

                  <!-- Buttons -->
                  <div class="col-md-2 form-group align-self-end">
                      <button type="submit" class="btn btn-primary">
                          <i class="bx bx-search-alt"></i>
                      </button>
                      <button type="button" class="btn btn-secondary" onclick="clearSearchForm()">
                          <i class="bx bx-eraser"></i>
                      </button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  <!-- End Search Bar -->


  <!-- Start Table for Subject Records -->
  <?php 
  if (isset($_GET['course'], $_GET['year'], $_GET['semester']) && !empty($_GET['course']) && !empty($_GET['year']) && !empty($_GET['semester'])): ?>
      
    <!-- Start Table for Subject Records -->
    <div class="container mt-4">
      <div class="card subjectTable">
        <div class="card-body">
          <h5 class="card-title">Subject Records</h5>
          <table class="table table-striped">
            <thead>
              <tr>
                <th>Course Code</th>
                <th>Description</th>
                <th>Lec</th>
                <th>Lab</th>
                <th>Units</th>
                <th>Pre-requisite</th>
                <th>Total Hours</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
                // Fetch and display subject records based on search criteria
                $course = isset($_GET['course']) ? $_GET['course'] : '';
                $year = isset($_GET['year']) ? $_GET['year'] : '';
                $semester = isset($_GET['semester']) ? $_GET['semester'] : '';

                // Database connection
                $database = new Connection();
                $db = $database->open();

                try {
                  $sql = "SELECT * FROM tbl_subjects WHERE (course = :course OR :course = '') 
                          AND (year = :year OR :year = 'all') 
                          AND (semester = :semester OR :semester = 'all')";

                  $stmt = $db->prepare($sql);
                  $stmt->execute([
                    'course' => $course,
                    'year' => ($year == 'all' ? '' : $year), // Allow 'all' to match no specific year
                    'semester' => ($semester == 'all' ? '' : $semester) // Allow 'all' to match no specific semester
                  ]);

                  if ($stmt->rowCount() > 0) {
                    foreach ($stmt as $subject) {
                      echo '<tr>';
                      echo '<td>' . htmlspecialchars($subject['code']) . '</td>';
                      echo '<td>' . htmlspecialchars($subject['description']) . '</td>';
                      echo '<td>' . htmlspecialchars($subject['lec']) . '</td>';
                      echo '<td>' . htmlspecialchars($subject['lab']) . '</td>';
                      echo '<td>' . htmlspecialchars($subject['unit']) . '</td>';
                      echo '<td>' . htmlspecialchars($subject['pre_req']) . '</td>';
                      echo '<td>' . htmlspecialchars($subject['total']) . '</td>';
                      echo '<td>
                              <button class="btn btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubjectModal" data-id="' . $subject['id'] . '" onclick="fetchSubjectData(' . $subject['id'] . ')"></button>
                              
                              <button class="btn btn-sm btn-danger ri-delete-bin-6-line btn-delete" data-id="' . $subject['id'] . '"></button>
                              
                            </td>';
                      echo '</tr>';
                    }
                  } else {
                    echo "<tr><td colspan='8' class='text-center'>No subjects found</td></tr>";
                  }
                } catch (PDOException $e) {
                  echo "<tr><td colspan='8' class='text-center'>Error fetching subjects: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
                }

                $database->close();
              ?>
              <?php include('modals/edit-subject.php'); ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!-- End Table for Subject Records -->
  <?php endif; ?>

 </section>
</main>

<?php include('modals/add-subject.php'); ?>
<?php include_once "../templates/footer.php"; ?>
