<?php include_once "../templates/header.php"; ?>

<?php
// Display a success message if a new subject was added
if (isset($_SESSION['subject_created']) && $_SESSION['subject_created']) {
  echo "
    <div class='alert alert-success'>
        <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
        New subject successfully added!
    </div>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.opacity = '0';
            setTimeout(function() {
                document.querySelector('.alert').style.display = 'none';
            }, 600);
        }, 5000);
    </script>";
  unset($_SESSION['subject_created']);
}
?>

<main id="main" class="main">

  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Subject Records</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#courseModal">
    </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Subject</li>
      </ol>
    </nav>
  </div>
  <!-- End Page Title -->

  <!-- Start Search bar -->
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
                      // Select distinct course descriptions
                      $sql = "SELECT DISTINCT course_description FROM tbl_course";
                      $stmt = $db->prepare($sql);
                      $stmt->execute();

                      // Loop through unique course descriptions
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
              <option value="" <?php echo (empty($_GET['year'])) ? 'selected' : ''; ?>>Select</option>
              <option value="all" <?php echo (isset($_GET['year']) && $_GET['year'] == 'all') ? 'selected' : ''; ?>>All Years</option>
              <option value="1" <?php echo (isset($_GET['year']) && $_GET['year'] == '1') ? 'selected' : ''; ?>>1</option>
              <option value="2" <?php echo (isset($_GET['year']) && $_GET['year'] == '2') ? 'selected' : ''; ?>>2</option>
              <option value="3" <?php echo (isset($_GET['year']) && $_GET['year'] == '3') ? 'selected' : ''; ?>>3</option>
              <option value="4" <?php echo (isset($_GET['year']) && $_GET['year'] == '4') ? 'selected' : ''; ?>>4</option>
              <option value="11" <?php echo (isset($_GET['year']) && $_GET['year'] == '11') ? 'selected' : ''; ?>>11</option>
              <option value="12" <?php echo (isset($_GET['year']) && $_GET['year'] == '12') ? 'selected' : ''; ?>>12</option>
            </select>
          </div>
          <div class="col-md-2 form-group">
            <label for="semester" class="form-label">Semester</label>
            <select class="form-select" id="semester" name="semester" disabled>
              <option value="" <?php echo (empty($_GET['semester'])) ? 'selected' : ''; ?>>Select</option>
              <option value="all" <?php echo (isset($_GET['semester']) && $_GET['semester'] == 'all') ? 'selected' : ''; ?>>All Semesters</option>
              <option value="1" <?php echo (isset($_GET['semester']) && $_GET['semester'] == '1') ? 'selected' : ''; ?>>1</option>
              <option value="2" <?php echo (isset($_GET['semester']) && $_GET['semester'] == '2') ? 'selected' : ''; ?>>2</option>
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
  <!-- End Search bar -->

  <?php if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['course']) && !empty($_GET['course'])): ?>
    <!-- Start Section -->
    <section class="section dashboard">
      <div class="table-responsive mt-4">
        <?php
        $database = new Connection();
        $db = $database->open();

        try {
          $course = $_GET['course'] ?? '';
          $year = $_GET['year'] ?? 'all';
          $semester = $_GET['semester'] ?? 'all';
          $years = ['1' => 'First Year', '2' => 'Second Year', '3' => 'Third Year', '4' => 'Fourth Year', '11' => "Grade 11", '12' => "Grade 12"];

          echo '<table class="table table-bordered table-striped">';
          echo '<thead class="table-dark">';
          echo '<tr>';
          echo '<th scope="col">Course Code</th>';
          echo '<th scope="col">Description</th>';
          echo '<th scope="col">Lec</th>';
          echo '<th scope="col">Lab</th>';
          echo '<th scope="col">Units</th>';
          echo '<th scope="col">Pre-requisite</th>';
          echo '<th scope="col">Total Hours</th>';
          echo '<th scope="col">Action</th>';
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
                      echo '<button type="button" class="btn btn-sm btn-warning ri-edit-2-fill btn-edit" data-id="' . htmlspecialchars($subject['id']) . '" data-bs-toggle="modal" data-bs-target="#editSubjectModal"></button>';
                      echo '<button type="button" class="btn btn-sm btn-danger ri-delete-bin-6-line btn-delete" data-id="' . htmlspecialchars($subject['id']) . '"></button>';
                      echo "</td>";
                      echo "</tr>";
                    }
                    echo '<tr><td colspan="8"><hr></td></tr>'; // Horizontal line separator for semester
                  }
                }
              }
              echo '<tr><td colspan="8"><hr></td></tr>'; // Horizontal line separator between years
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
              $currentYear = '';
              $currentSemester = '';

              foreach ($stmt as $subject) {
                if ($currentYear != $subject['year']) {
                  if ($currentYear != '') {
                    echo '<tr><td colspan="8"><hr></td></tr>'; // Horizontal line separator between years
                  }
                  $currentYear = $subject['year'];
                  echo "<tr><td colspan='8' class='table-info text-center'><strong>{$years[$currentYear]}</strong></td></tr>";
                }

                if ($currentSemester != $subject['semester']) {
                  if ($currentSemester != '') {
                    echo '<tr><td colspan="8"><hr></td></tr>'; // Horizontal line separator for semester
                  }
                  $currentSemester = $subject['semester'];
                  echo "<tr><td colspan='8' class='table-secondary text-center'><strong>{$subject['semester']} Semester</strong></td></tr>";
                }

                echo "<tr>";
                echo "<td>" . htmlspecialchars($subject['code']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['description']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['lec']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['lab']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['unit']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['pre_req']) . "</td>";
                echo "<td>" . htmlspecialchars($subject['total']) . "</td>";
                echo "<td>";
                echo '<button type="button" class="btn btn-sm btn-warning ri-edit-2-fill btn-edit" data-id="' . htmlspecialchars($subject['id']) . '" data-bs-toggle="modal" data-bs-target="#editSubjectModal"></button>';
                echo '<button type="button" class="btn btn-sm btn-danger ri-delete-bin-6-line btn-delete" data-id="' . htmlspecialchars($subject['id']) . '"></button>';
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
        <div class="modal-body">
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
                  <?php foreach ($years as $yearNumber => $yearTitle): ?>
                    <option value="<?= $yearNumber ?>"><?= $yearTitle ?></option>
                  <?php endforeach; ?>
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

  <!-- Start Modal for editing subjects -->
  <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editSubjectForm" action="includes/update_subject.php" method="POST">
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
                <input type="text" class="form-control" id="edit-course" name="course" required>
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
  <!--End Modal for editing subjects -->


</main>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.btn-edit');

    editButtons.forEach(button => {
      button.addEventListener('click', function() {
        const subjectId = this.getAttribute('data-id');

        if (!subjectId) {
          console.error('No subject ID found.');
          return;
        }

        // Fetch all subjects via AJAX
        fetch('includes/get_subject.php')
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success' && data.data) {
              // Find the subject with the matching ID
              const subject = data.data.find(subj => subj.id == subjectId);

              if (subject) {
                // Populate the modal with the subject data
                document.getElementById('edit-id').value = subject.id || '';
                document.getElementById('edit-code').value = subject.code || '';
                document.getElementById('edit-description').value = subject.description || '';
                document.getElementById('edit-lec').value = subject.lec || '';
                document.getElementById('edit-lab').value = subject.lab || '';
                document.getElementById('edit-unit').value = subject.unit || '';
                document.getElementById('edit-pre_req').value = subject.pre_req || '';
                document.getElementById('edit-total').value = subject.total || '';
                document.getElementById('edit-course').value = subject.course || '';
                document.getElementById('edit-year').value = subject.year || '';
                document.getElementById('edit-semester').value = subject.semester || '';

                // Show the modal
                $('#editModal').modal('show');
              } else {
                console.error('Subject not found');
              }
            } else {
              console.error('Error:', data.message);
            }
          })
          .catch(error => console.error('Fetch Error:', error));
      });
    });
  });
</script>


<script>
  document.querySelectorAll('.btn-delete').forEach(button => {
    button.addEventListener('click', function() {
      const subjectId = this.getAttribute('data-id');
      if (confirm('Are you sure you want to delete this subject?')) {
        // Redirect to delete_subject.php with the subject ID
        window.location.href = `includes/delete_subject.php?id=${subjectId}`;
      }
    });
  });
</script>

<script>
  function enableNextField(nextFieldId) {
    const courseField = document.getElementById('course');
    const yearField = document.getElementById('year');
    const semesterField = document.getElementById('semester');

    if (nextFieldId === 'year') {
      yearField.disabled = !courseField.value.trim();
    } else if (nextFieldId === 'semester') {
      semesterField.disabled = !yearField.value.trim();
    }
  }

  // Initialize fields based on existing values
  window.addEventListener('DOMContentLoaded', () => {
    enableNextField('year');
    enableNextField('semester');
  });
</script>

<script>
  function clearSearchForm() {
    // Clear all input fields in the form
    document.querySelectorAll('form input, form select').forEach(input => input.value = '');

    // Check if the form is empty, and hide the section if it is
    const isFormEmpty = Array.from(document.querySelectorAll('form input, form select'))
      .every(input => input.value === '');

    if (isFormEmpty) {
      const section = document.querySelector('.section.dashboard');
      if (section) {
        section.style.display = 'none';
      }
    }
  }
</script>

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

  .alert {
    padding: 20px;
    background-color: #4CAF50;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
    border-radius: 4px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 5000;
    width: 300px;
  }

  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover {
    color: black;
  }
  .container {
    margin-top: 20px;
  }

  .form-group label {
    font-weight: bold;
  }

  .card-body {
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
  }

  table {
    margin-top: 20px;
  }

  th,
  td {
    text-align: center;
  }

  .no-results {
    text-align: center;
    color: #6c757d;
    font-style: italic;
  }
</style>

<?php include_once "../templates/footer.php"; ?>