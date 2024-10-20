<?php include_once "../templates/header.php"; ?>
<!--<?php include_once '../PHP/subject-con.php' ?>-->

<main id="main" class="main">

  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Subject Records</h1>
    <button type="button" class="ri-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#courseModal">
    </button>
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
            <option value="all">All Years</option>
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
            <option value="all">All Semesters</option>
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

<?php if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['course']) && !empty($_GET['course'])): ?>
  <!-- Start Section -->
  <section class="section dashboard">
    <div class="table-responsive mt-4">
      <?php
        $database = new Connection();
        $db = $database->open();

        try {
          $course = $_GET['course'];
          $year = $_GET['year'] ?? 'all';
          $semester = $_GET['semester'] ?? 'all';
          $years = ['1' => 'First Year', '2' => 'Second Year', '3' => 'Third Year', '4' => 'Fourth Year', '11' => "Grade 11", '12' => "Grade 12"];

          echo '<table class="table table-bordered table-striped">';
          echo '<thead class="table-primary">';
          echo '<tr>';
          echo '<th>Course Code</th>';
          echo '<th>Description</th>';
          echo '<th>Lec</th>';
          echo '<th>Lab</th>';
          echo '<th>Units</th>';
          echo '<th>Pre-requisite</th>';
          echo '<th>Total Hours</th>';
          echo '<th>Action</th>';
          echo '</tr>';
          echo '</thead>';
          echo '<tbody>';

          if ($year == 'all') {
            foreach ($years as $yearNumber => $yearTitle) {
              echo "<tr><td colspan='8' class='table-info text-center'><strong>$yearTitle</strong></td></tr>";

              foreach (['1' => '1st Semester', '2' => '2nd Semester'] as $semCode => $semTitle) {
                if ($semester == 'all' || $semester == $semCode) {
                  $sql = "SELECT * FROM tbl_subjects WHERE course = :course AND year = :year AND semester = :semester";
                  $stmt = $db->prepare($sql);
                  $stmt->bindParam(':course', $course);
                  $stmt->bindParam(':year', $yearNumber);
                  $stmt->bindParam(':semester', $semCode);
                  $stmt->execute();

                  if ($stmt->rowCount() > 0) {
                    echo "<tr><td colspan='8' class='table-secondary text-center'><strong>$semTitle</strong></td></tr>";

                    foreach ($stmt as $subject) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($subject['code']) . "</td>";
                      echo "<td>" . htmlspecialchars($subject['description']) . "</td>";
                      echo "<td>" . htmlspecialchars($subject['lec']) . "</td>";
                      echo "<td>" . htmlspecialchars($subject['lab']) . "</td>";
                      echo "<td>" . htmlspecialchars($subject['unit']) . "</td>";
                      echo "<td>" . htmlspecialchars($subject['pre_req']) . "</td>";
                      echo "<td>" . htmlspecialchars($subject['total']) . "</td>";
                      echo "<td>";
                     echo '<button class="btn btn-sm btn-warning ri-edit-2-fill btn-edit" data-id="' . htmlspecialchars($subject['id'], ENT_QUOTES, 'UTF-8') . '" data-bs-toggle="modal" data-bs-target="#editCourseModal"></button>';
echo '<button class="btn btn-sm btn-danger ri-delete-bin-6-line btn-delete" data-id="' . htmlspecialchars($subject['id']) . '"></button>';

                      echo "</td>";
                      echo "</tr>";
                    }
                    echo '<tr><td colspan="8"><hr></td></tr>';
                  }
                }
              }
              echo '<tr><td colspan="8"><hr></td></tr>';
            }
          } else {
            $sql = "SELECT * FROM tbl_subjects WHERE course = :course AND year = :year";
            if ($semester != 'all') {
              $sql .= " AND semester = :semester";
            }
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':course', $course);
            $stmt->bindParam(':year', $year);
            if ($semester != 'all') {
              $stmt->bindParam(':semester', $semester);
            }
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
              foreach ($stmt as $subject) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($subject['code']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['description']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['lec']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['lab']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['unit']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['pre_req']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['total']) . "</td>";
                echo "<td>";
                echo '<button class="btn btn-sm btn-warning ri-edit-2-fill btn-edit" data-id="' . htmlspecialchars($subject['id'], ENT_QUOTES, 'UTF-8') . '" data-bs-toggle="modal" data-bs-target="#editCourseModal"></button>';
echo '<button class="btn btn-sm btn-danger ri-delete-bin-6-line btn-delete" data-id="' . htmlspecialchars($subject['id']) . '"></button>';

                echo "</td>";
                echo "</tr>";
              }
            } else {
              echo '<tr><td colspan="8" class="text-center">No subjects found for this course/year/semester combination.</td></tr>';
            }
          }

          echo '</tbody>';
          echo '</table>';
        } catch (PDOException $e) {
          echo "There was an error retrieving the subjects: " . $e->getMessage();
        }

        $database->close();
      ?>
    </div>
  </section>
  <!-- End Section -->
<?php endif; ?>

<!-- Start Modal for adding subjects -->
  <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="courseModalLabel">Add Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color:#e6ffe6;">
          <form id="addSubjectForm" action="functions/add-subject.php" method="POST">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="code" class="form-label">Course Code</label>
                <input type="text" class="form-control" id="code" name="code" required>
              </div>
              <div class="col-md-6">
                <label for="description" class="form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" required>
              </div>
              <div class="col-md-6">
                <label for="lec" class="form-label">Lecture Hours</label>
                <input type="number" class="form-control" id="lec" name="lec" required>
              </div>
              <div class="col-md-6">
                <label for="lab" class="form-label">Lab Hours</label>
                <input type="number" class="form-control" id="lab" name="lab" required>
              </div>
              <div class="col-md-6">
                <label for="unit" class="form-label">Units</label>
                <input type="number" class="form-control" id="unit" name="unit" step="0.1" required>
              </div>
              <div class="col-md-6">
                <label for="pre_req" class="form-label">Pre-requisite</label>
                <input type="text" class="form-control" id="pre_req" name="pre_req">
              </div>
              <div class="col-md-6">
                <label for="total" class="form-label">Total Hours</label>
                <input type="number" class="form-control" id="total" name="total" required>
              </div>

              <div class="col-md-6">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" name="course" placeholder="(BSIT / BSBA / BSOA / ICT / ABM / HUMSS / GAS">
              </div>

              <div class="col-md-6">
                <label for="year" class="form-label">Year</label>
                <select class="form-select" id="year" name="year" required>
                    <option value="" selected>Select</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
              </div>
              <div class="col-md-6">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-select" id="semester" name="semester" required>
                  <option value="" selected>Select</option>
                  <option value="1">1st Semester</option>
                  <option value="2">2nd Semester</option>
                </select>
              </div>
            </div>
       
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Subject</button>
            </div>
        </form>
      </div>
    </div>
  </div>
 <!-- End Modal for adding subjects -->

 <!-- Start Modal for edit subjects -->
  <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
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
                  <?php foreach ($years as $yearNumber => $yearTitle): ?>
                    <option value="<?= $yearNumber ?>"><?= $yearTitle ?></option>
                  <?php endforeach; ?>
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
 <!-- End Modal for edit subjects -->

</main>

<?php include_once "../templates/footer.php"; ?>
<?php include_once '../admin/modals/add-subject.php' ?>
