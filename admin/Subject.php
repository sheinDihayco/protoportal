<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/subject-con.php"; ?>

<main id="main" class="main">

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
          <div class="col-md-6 form-group">
            <label for="course" class="form-label">Course</label>
            <select class="form-select" id="course" name="course" oninput="enableNextField('year')" required>
              <option value="" selected>Select Course</option>
              <?php
                $database = new Connection();
                $db = $database->open();

                try {
                  $sql = "SELECT DISTINCT course_description FROM tbl_course";
                  $stmt = $db->prepare($sql);
                  $stmt->execute();
                  foreach ($stmt as $course) {
                    echo '<option value="' . htmlspecialchars($course['course_description']) . '">' . htmlspecialchars($course['course_description']) . '</option>';
                  }
                } catch (PDOException $e) {
                  echo "<option value='' disabled>Error fetching courses</option>";
                }

                $database->close();
              ?>
            </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="year" class="form-label">Year</label>
            <select class="form-select" id="year" name="year" oninput="enableNextField('semester')" disabled>
              <option value="" selected>Select</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>
          </div>

          <div class="col-md-2 form-group">
            <label for="semester" class="form-label">Semester</label>
            <select class="form-select" id="semester" name="semester" disabled>
              <option value="" selected>Select</option>
              <option value="1">1</option>
              <option value="2">2</option>
            </select>
          </div>

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
  <div class="container mt-4">
    <div class="card">
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
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <!-- End Table for Subject Records -->
 
<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
       <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editCourseModalLabel">Edit Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color:#e6ffe6;">
          <form id="editForm" action="includes/update_subject.php" method="POST">
            <!-- Include a hidden input field to hold the subject ID -->
            <input type="hidden" id="edit-id" name="id">
            
            <div class="row g-3">
              <div class="col-md-6">
                <label for="edit-code" class="form-label">Course Code</label>
                <input type="text" class="form-control" id="edit-code" name="code" required>
              </div>
              <div class="col-md-6">
                <label for="edit-description" class="form-label">Description</label>
                <input type="text" class="form-control" id="edit-description" name="description" required>
              </div>
              <div class="col-md-6">
                <label for="edit-lec" class="form-label">Lecture Hours</label>
                <input type="number" class="form-control" id="edit-lec" name="lec" required>
              </div>
              <div class="col-md-6">
                <label for="edit-lab" class="form-label">Lab Hours</label>
                <input type="number" class="form-control" id="edit-lab" name="lab" required>
              </div>
              <div class="col-md-6">
                <label for="edit-unit" class="form-label">Units</label>
                <input type="number" class="form-control" id="edit-unit" name="unit" step="0.1" required>
              </div>
              <div class="col-md-6">
                <label for="edit-pre_req" class="form-label">Pre-requisite</label>
                <input type="text" class="form-control" id="edit-pre_req" name="pre_req">
              </div>
              <div class="col-md-6">
                <label for="edit-total" class="form-label">Total Hours</label>
                <input type="number" class="form-control" id="edit-total" name="total" required>
              </div>

              <div class="col-md-6">
                <label for="edit-course" class="form-label">Course</label>
                <input type="text" class="form-control" id="edit-course" name="course" placeholder="(BSIT / BSBA / BSOA / ICT / ABM / HUMSS / GAS)">
              </div>

              <div class="col-md-6">
                <label for="edit-year" class="form-label">Year</label>
                <select class="form-select" id="edit-year" name="year" required>
                  <option value="" selected>Select</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="edit-semester" class="form-label">Semester</label>
                <select class="form-select" id="edit-semester" name="semester" required>
                  <option value="" selected>Select</option>
                  <option value="1">1st Semester</option>
                  <option value="2">2nd Semester</option>
                </select>
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Subject</button>
            </div>
          </form>
        </div>
      </div>
    </div>
</div>

</main>

<?php include_once "../templates/footer.php"; ?>
<?php include '../admin/modals/add-subject.php'; ?>