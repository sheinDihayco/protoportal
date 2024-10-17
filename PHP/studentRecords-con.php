<?php
include_once 'includes/connection.php'; // Ensure to include your database connection file

// Initialize database connection
$connection = new Connection();
$conn = $connection->open();

// Initialize $students array
$students = [];

// Get the logged-in instructor's user ID
$instructor_id = $_SESSION["login"]; 

try {
    // Query to get students assigned to the logged-in instructor
    $stmt = $conn->prepare("
        SELECT ts.user_id, ts.fname, ts.lname, ts.course, ts.year, ts.user_name
        FROM tbl_students ts
        INNER JOIN tbl_student_instructors tsi ON ts.user_id = tsi.student_id
        WHERE tsi.instructor_id = :instructor_id
        ORDER BY ts.course, ts.year ASC
    ");
    $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
    $stmt->execute();

    // Fetch the students
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Group students by course and year
    $grouped_students = [];
    foreach ($students as $student) {
        $course_year_key = "{$student['course']} - {$student['year']}";
        $grouped_students[$course_year_key][] = $student;
    }

} catch (PDOException $e) {
    echo "<p>Error fetching student data: " . htmlspecialchars($e->getMessage()) . "</p>";
    exit(); // Stop further execution in case of an error
}

// Close the connection
$connection->close();
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    <?php if (isset($_SESSION['grade_created']) && $_SESSION['grade_created'] === true) : ?>
      Swal.fire({
        icon: 'success',
        title: 'Grade Created',
        text: 'The grade has been successfully created!',
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          <?php unset($_SESSION['grade_created']); ?> // Clear session variable
        }
      });
    <?php endif; ?>
  });
</script>


<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function confirmDelete(form) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'No, cancel!',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        form.submit();
      } else if (result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire(
          'Cancelled',
          'Student still enrolled in class :)',
          'error'
        )
      }
    });
    return false; // Prevent the form from submitting immediately
  }

  document.addEventListener('DOMContentLoaded', function() {
    <?php if (isset($_SESSION['grade_created']) && $_SESSION['grade_created']): ?>
      Swal.fire({
        title: 'Success!',
        text: 'The grade has been successfully created.',
        icon: 'success',
        confirmButtonText: 'OK'
      });
      <?php unset($_SESSION['grade_created']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['grade_error'])): ?>
      Swal.fire({
        title: 'Error!',
        text: '<?php echo $_SESSION['grade_error']; ?>',
        icon: 'error',
        confirmButtonText: 'OK'
      });
      <?php unset($_SESSION['grade_error']); ?>
    <?php endif; ?>
  });
</script>