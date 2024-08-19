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
    <h1>Assigned Students</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Assigned Students</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <!-- Display Assigned Students Table -->
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
                <th scope="col">Full Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($assignedStudents)): ?>
                <?php foreach ($assignedStudents as $student): ?>
                  <tr>
                    <th scope="row"><?php echo htmlspecialchars($student['user_name']); ?></th>
                    <td><?php echo htmlspecialchars($student['lname']) . ', ' . htmlspecialchars($student['fname']); ?></td>
                    <td>

                      <!-- Form to view student profile -->
                      <form action="stud-profile.php" method="post" style="display:inline;">
                        <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($student['user_id']); ?>">
                        <button type="submit" class="btn btn-sm btn-success" name="submit">
                          <i class="ri-arrow-right-circle-fill"></i>
                        </button>
                      </form>
                    </td>

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
    </div>

  </section>
</main>