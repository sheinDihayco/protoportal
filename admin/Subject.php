<?php include_once "../templates/header.php"; ?>

<?php
// Fetch the subject details based on the provided ID
if (isset($_GET['id'])) {
  $subjectId = $_GET['id'];
  $query = $pdo->prepare("SELECT * FROM tbl_subjects WHERE id = :id");
  $query->bindParam(':id', $subjectId, PDO::PARAM_INT);
  $query->execute();
  $subject = $query->fetch(PDO::FETCH_ASSOC);
  echo json_encode($subject);
  exit;
}
?>

<?php
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

  <div class="pagetitle">
    <h1>Subject Records</h1>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#courseModal">Add Subject</button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Subject</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <!-- Search -->
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
                  echo '<tr><td colspan="8"><hr></td></tr>'; // Horizontal line separator between semesters
                }
                $currentSemester = $subject['semester'];
                echo "<tr><td colspan='8' class='table-secondary text-center'><strong>Semester {$currentSemester}</strong></td></tr>";
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
            echo "<tr><td colspan='8' class='text-center'>No subjects found.</td></tr>";
          }
        }
        echo '</tbody>';
        echo '</table>';
      } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
      }

      $database->close();
      ?>
    </div>
  </section>

  <!-- Modal for adding subjects -->
  <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="courseModalLabel">Add Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addSubjectForm" action="../add_subject.php" method="POST">
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
                <label for="units" class="form-label">Units</label>
                <input type="number" class="form-control" id="units" name="units" step="0.1" required>
              </div>
              <div class="col-md-6">
                <label for="pre_req" class="form-label">Pre-requisite</label>
                <input type="text" class="form-control" id="pre_req" name="pre_req">
              </div>
              <div class="col-md-6">
                <label for="total_hours" class="form-label">Total Hours</label>
                <input type="number" class="form-control" id="total_hours" name="total_hours" required>
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

  <!-- Modal for editing subjects -->
  <div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editSubjectForm" action="../edit_subject.php" method="POST">
            <input type="hidden" id="editSubjectId" name="id">
            <div class="row g-3">
              <div class="col-md-6">
                <label for="edit_code" class="form-label">Course Code</label>
                <input type="text" class="form-control" id="edit_code" name="code" required>
              </div>
              <div class="col-md-6">
                <label for="edit_description" class="form-label">Description</label>
                <input type="text" class="form-control" id="edit_description" name="description" required>
              </div>
              <div class="col-md-6">
                <label for="edit_lec" class="form-label">Lecture Hours</label>
                <input type="number" class="form-control" id="edit_lec" name="lec" required>
              </div>
              <div class="col-md-6">
                <label for="edit_lab" class="form-label">Lab Hours</label>
                <input type="number" class="form-control" id="edit_lab" name="lab" required>
              </div>
              <div class="col-md-6">
                <label for="edit_units" class="form-label">Units</label>
                <input type="number" class="form-control" id="edit_units" name="units" step="0.1" required>
              </div>
              <div class="col-md-6">
                <label for="edit_pre_req" class="form-label">Pre-requisite</label>
                <input type="text" class="form-control" id="edit_pre_req" name="pre_req">
              </div>
              <div class="col-md-6">
                <label for="edit_total_hours" class="form-label">Total Hours</label>
                <input type="number" class="form-control" id="edit_total_hours" name="total_hours" required>
              </div>
              <div class="col-md-6">
                <label for="edit_year" class="form-label">Year</label>
                <select class="form-select" id="edit_year" name="year" required>
                  <option value="" selected>Select</option>
                  <?php foreach ($years as $yearNumber => $yearTitle): ?>
                    <option value="<?= $yearNumber ?>"><?= $yearTitle ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-md-6">
                <label for="edit_semester" class="form-label">Semester</label>
                <select class="form-select" id="edit_semester" name="semester" required>
                  <option value="" selected>Select</option>
                  <option value="1">1st Semester</option>
                  <option value="2">2nd Semester</option>
                </select>
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function() {
    // Handle Edit button click
    $('.btn-edit').click(function() {
      const subjectId = $(this).data('id'); // Get the subject ID from the button's data attribute

      // Fetch subject details
      $.ajax({
        url: 'includes/get_subject.php', // Endpoint to get subject details
        type: 'POST',
        data: {
          id: subjectId // Send the subject ID to the server
        },
        dataType: 'json',
        success: function(data) {
          if (data && !data.error) {
            // Populate the form fields with the retrieved data
            $('#editSubjectId').val(data.id);
            $('#edit_code').val(data.code);
            $('#edit_description').val(data.description);
            $('#edit_lec').val(data.lec);
            $('#edit_lab').val(data.lab);
            $('#edit_units').val(data.units);
            $('#edit_pre_req').val(data.pre_req);
            $('#edit_total_hours').val(data.total_hours);
            $('#edit_year').val(data.year);
            $('#edit_semester').val(data.semester);
          } else {
            alert(data.error || 'Failed to fetch subject details');
          }
        },
        error: function() {
          alert('An error occurred while fetching subject details');
        }
      });
    });

    // Handle Delete button click
    $('.btn-delete').click(function() {
      const subjectId = $(this).data('id'); // Get the subject ID from the button's data attribute

      if (confirm('Are you sure you want to delete this subject?')) {
        $.ajax({
          url: 'includes/delete_subject.php', // Endpoint to delete the subject
          type: 'POST',
          data: {
            id: subjectId // Send the subject ID to the server
          },
          success: function(response) {
            if (response.trim() === 'success') {
              location.reload(); // Reload the page if deletion was successful
            } else {
              alert('Failed to delete subject');
            }
          },
          error: function() {
            alert('An error occurred while deleting the subject');
          }
        });
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

</body>

</html>