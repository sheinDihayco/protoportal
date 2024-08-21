<?php include_once "../templates/header.php"; ?>
<?php
// Fetch the subject details based on the provided ID
if (isset($_GET['id'])) {
  $subjectId = $_GET['id'];
  $query = $pdo->prepare("SELECT * FROM subjects WHERE id = :id");
  $query->bindParam(':id', $subjectId, PDO::PARAM_INT);
  $query->execute();
  $subject = $query->fetch(PDO::FETCH_ASSOC);
  echo json_encode($subject);
}
?>


<?php
if (isset($_SESSION['subject_created']) && $_SESSION['subject_created']) {
  echo "
        <div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
            New employee successfully added!
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

  <div class="pagetitle">
    <h1>Subject Records</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#courseModal"></button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Subject</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <form id="subjectForm" action="" method="GET" class="row g-3">
    <div class="col-md-6">
      <label for="course" class="form-label">Course</label>
      <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($_GET['course'] ?? ''); ?>" oninput="enableNextField('year')" required>
    </div>
    <div class="col-md-2">
      <label for="year" class="form-label">Year</label>
      <select class="form-select" id="year" name="year" oninput="enableNextField('semester')" disabled>
        <option value="" <?php echo (empty($_GET['year'])) ? 'selected' : ''; ?>>Select</option>
        <option value="all" <?php echo (isset($_GET['year']) && $_GET['year'] == 'all') ? 'selected' : ''; ?>>All Years</option>
        <option value="1" <?php echo (isset($_GET['year']) && $_GET['year'] == '1') ? 'selected' : ''; ?>>1</option>
        <option value="2" <?php echo (isset($_GET['year']) && $_GET['year'] == '2') ? 'selected' : ''; ?>>2</option>
        <option value="3" <?php echo (isset($_GET['year']) && $_GET['year'] == '3') ? 'selected' : ''; ?>>3</option>
        <option value="4" <?php echo (isset($_GET['year']) && $_GET['year'] == '4') ? 'selected' : ''; ?>>4</option>
      </select>
    </div>
    <div class="col-md-2">
      <label for="semester" class="form-label">Semester</label>
      <select class="form-select" id="semester" name="semester" disabled>
        <option value="" <?php echo (empty($_GET['semester'])) ? 'selected' : ''; ?>>Select</option>
        <option value="all" <?php echo (isset($_GET['semester']) && $_GET['semester'] == 'all') ? 'selected' : ''; ?>>All Semesters</option>
        <option value="1" <?php echo (isset($_GET['semester']) && $_GET['semester'] == '1') ? 'selected' : ''; ?>>1</option>
        <option value="2" <?php echo (isset($_GET['semester']) && $_GET['semester'] == '2') ? 'selected' : ''; ?>>2</option>
      </select>
    </div>

    <div class="col-md-2 align-self-end">
      <button type="submit" class="btn btn-primary">Search</button>
    </div>
  </form>

  <section class="section dashboard">
    <div class="table-responsive mt-4">
      <?php
      $database = new Connection();
      $db = $database->open();

      try {
        $course = $_GET['course'] ?? '';
        $year = $_GET['year'] ?? 'all';
        $semester = $_GET['semester'] ?? 'all';
        $years = ['1' => 'First Year', '2' => 'Second Year', '3' => 'Third Year', '4' => 'Fourth Year'];

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
            echo "<tr><td colspan='10' class='table-info text-center'><strong>$yearTitle</strong></td></tr>";

            foreach (['1' => '1st Semester', '2' => '2nd Semester'] as $semCode => $semTitle) {
              if ($semester == 'all' || $semester == $semCode) {
                $sql = "SELECT * FROM tbl_subjects WHERE course = :course AND year = :year AND semester = :semester";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':course', $course);
                $stmt->bindParam(':year', $yearNumber);
                $stmt->bindParam(':semester', $semCode);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                  echo "<tr><td colspan='10' class='table-secondary text-center'><strong>$semTitle</strong></td></tr>";

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
                  echo '<tr><td colspan="10"><hr></td></tr>'; // Horizontal line separator for semester
                }
              }
            }
            echo '<tr><td colspan="10"><hr></td></tr>'; // Horizontal line separator between years
          }
        } else {
          // Handle specific year and semester selections if needed
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
                  echo '<tr><td colspan="10"><hr></td></tr>'; // Horizontal line separator between years
                }
                $currentYear = $subject['year'];
                echo "<tr><td colspan='10' class='table-info text-center'><strong>Year $currentYear</strong></td></tr>";
              }
              if ($currentSemester != $subject['semester']) {
                if ($currentSemester != '') {
                  echo '<tr><td colspan="10"><hr></td></tr>'; // Horizontal line separator between semesters
                }
                $currentSemester = $subject['semester'];
                echo "<tr><td colspan='10' class='table-secondary text-center'><strong>$currentSemester Semester</strong></td></tr>";
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
            echo '<tr><td colspan="10" class="text-center">No subjects found for the selected criteria.</td></tr>';
          }
        }

        echo '</tbody>';
        echo '</table>';
      } catch (PDOException $e) {
        echo "There was an issue: " . $e->getMessage();
      }

      $database->close();
      ?>
    </div>

    <!-- Course Modal -->
    <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="courseModalLabel">Add New Subject</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="courseForm" action="../admin/functions/add-subject.php" method="POST">
              <div class="row mb-3">
                <label for="code" class="col-sm-3 col-form-label">Course Code</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="code" name="code" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="description" class="col-sm-3 col-form-label">Description</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="description" name="description" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="lec" class="col-sm-3 col-form-label">Lec</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="lec" name="lec" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="lab" class="col-sm-3 col-form-label">Lab</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="lab" name="lab" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="unit" class="col-sm-3 col-form-label">Units</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="unit" name="unit" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="pre_req" class="col-sm-3 col-form-label">Pre-requisite</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="pre_req" name="pre_req">
                </div>
              </div>
              <div class="row mb-3">
                <label for="total" class="col-sm-3 col-form-label">Total Hours</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="total" name="total" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="course" class="col-sm-3 col-form-label">Course</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="course" name="course" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="year" class="col-sm-3 col-form-label">Year</label>
                <div class="col-sm-9">
                  <select class="form-select" id="year" name="year" required>
                    <option value="">Select Year</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                  </select>
                </div>
              </div>
              <div class="row mb-3">
                <label for="semester" class="col-sm-3 col-form-label">Semester</label>
                <div class="col-sm-9">
                  <select class="form-select" id="semester" name="semester" required>
                    <option value="">Select Semester</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
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
    </div>

    <!-- Edit Subject Modal -->
    <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="editSubjectForm">
              <div class="row mb-3">
                <label for="editSubjectCode" class="col-sm-2 col-form-label">Code</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="editSubjectCode" name="editSubjectCode" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="editDescription" class="col-sm-2 col-form-label">Description</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="editDescription" name="editDescription" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="editLec" class="col-sm-2 col-form-label">Lec</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="editLec" name="editLec" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="editLab" class="col-sm-2 col-form-label">Lab</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="editLab" name="editLab" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="editUnit" class="col-sm-2 col-form-label">Unit</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="editUnit" name="editUnit" required>
                </div>
              </div>
              <div class="row mb-3">
                <label for="editPreReq" class="col-sm-2 col-form-label">Pre-requisite</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="editPreReq" name="editPreReq">
                </div>
              </div>
              <div class="row mb-3">
                <label for="editTotal" class="col-sm-2 col-form-label">Total Hours</label>
                <div class="col-sm-10">
                  <input type="number" class="form-control" id="editTotal" name="editTotal" required>
                </div>
              </div>
              <input type="hidden" id="editSubjectId" name="editSubjectId">
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="saveSubjectChanges">Save changes</button>
          </div>
        </div>
      </div>
    </div>

  </section>
</main>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Handle edit button click
    document.querySelectorAll('.btn-edit').forEach(button => {
      button.addEventListener('click', function() {
        const subjectId = this.getAttribute('data-id');

        fetch('get_subject_details.php?id=' + subjectId)
          .then(response => response.json())
          .then(subject => {
            document.getElementById('editSubjectCode').value = subject.code;
            document.getElementById('editDescription').value = subject.description;
            document.getElementById('editLec').value = subject.lec;
            document.getElementById('editLab').value = subject.lab;
            document.getElementById('editUnit').value = subject.unit;
            document.getElementById('editPreReq').value = subject.pre_req;
            document.getElementById('editTotal').value = subject.total;
            document.getElementById('editSubjectId').value = subject.id;
          });
      });
    });

    // Handle delete button click
    document.querySelectorAll('.btn-delete').forEach(button => {
      button.addEventListener('click', function() {
        const subjectId = this.getAttribute('data-id');
        if (confirm('Are you sure you want to delete this subject?')) {
          fetch('delete_subject.php?id=' + subjectId, {
              method: 'DELETE'
            })
            .then(response => response.text())
            .then(result => {
              alert(result);
              location.reload(); // Refresh the page after deletion
            });
        }
      });
    });

    // Handle save changes in edit modal
    document.getElementById('saveSubjectChanges').addEventListener('click', function() {
      const form = document.getElementById('editSubjectForm');
      const formData = new FormData(form);

      fetch('edit_subject.php', {
          method: 'POST',
          body: formData
        })
        .then(response => response.text())
        .then(result => {
          alert(result);
          location.reload(); // Refresh the page after saving changes
        });
    });
  });
</script>
<script>
  function enableNextField(nextFieldId) {
    var currentField = event.target;
    if (currentField.value !== "") {
      document.getElementById(nextFieldId).disabled = false;
    } else {
      document.getElementById(nextFieldId).disabled = true;
    }
  }
</script>

<?php
include_once "../templates/footer.php";
?>