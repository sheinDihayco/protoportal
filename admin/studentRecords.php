<?php
include_once "../templates/header2.php"; // Adjust the path as needed
include_once "includes/connect.php"; // Ensure to include your database connection file

$database = new Connection();
$db = $database->open();

// Initialize variables
$assignedStudents = [];
$userid = $_SESSION["login"]; // Get the logged-in instructor's user ID

try {
  // Query to get students assigned to the specific instructor
  $sql = "SELECT s.user_id, s.lname, s.fname, s.course, s.year, s.status, s.user_name
            FROM tbl_students s
            INNER JOIN tbl_student_instructors si ON s.user_id = si.student_id
            WHERE si.instructor_id = :instructor_id";
  $stmt = $db->prepare($sql);
  $stmt->execute([':instructor_id' => $userid]);
  $assignedStudents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "There was an error: " . $e->getMessage();
}

// Close database connection
$database->close();
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Student Account Records</h1>
    </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Accounts</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->



  <section class="section dashboard">
    <div class="col-12">
      <div class="card recent-sales overflow-auto">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div>
        <div class="card-body">
          <h5 class="card-title">Students <span>| Enrolled</span></h5>
          <table class="table table-borderless datatable">
            <thead>
              <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Course & Year</th>
                <th scope="col">Full Name</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($assignedStudents)): ?>
                <?php foreach ($assignedStudents as $student): ?>
                  <tr>
                    <th scope="row"><?php echo htmlspecialchars($student['user_name']); ?></th>
                    <td><?php echo htmlspecialchars($student['course']) . ' ' . htmlspecialchars($student['year']); ?></td>
                    <td><?php echo htmlspecialchars($student['lname']) . ', ' . htmlspecialchars($student['fname']); ?></td>
                    <td><?php echo htmlspecialchars($student['status']); ?></td>
                    <td>
                      <!-- Button to trigger the modal for grade insertion -->
                      <button type="button" class="btn btn-sm btn-warning ri-add-box-fill" data-bs-toggle="modal" data-bs-target="#insertGrade<?php echo htmlspecialchars($student['user_id']); ?>"></button>

                      <!-- Form to delete the user -->
                      <form method="POST" action="../admin/upload/delete-user.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($student['user_id']); ?>">
                        <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                      </form>
                    </td>
                    <?php include('modals/insert-grade.php'); ?>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5">No students assigned to this instructor.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div><!-- End Students Enrolled -->
  </section>
</main><!-- End #main -->

<!-- Vendor JS Files -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>

<script>
  document.getElementById('role').addEventListener('change', function() {
    var role = this.value;
    if (role === 'student') {
      document.getElementById('usernameDiv').style.display = 'none';
      document.getElementById('schoolidDiv').style.display = 'block';
    } else {
      document.getElementById('usernameDiv').style.display = 'block';
      document.getElementById('schoolidDiv').style.display = 'none';
    }
  });
</script>

<?php include_once "../templates/footer.php"; ?>