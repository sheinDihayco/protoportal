
<?php 
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


<!-- Vendor JS Files -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
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