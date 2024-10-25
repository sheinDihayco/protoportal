<?php
include_once 'includes/connection.php';

$userid = $_SESSION['login'];

$connection = new Connection();
$conn = $connection->open();

$results = [];

try {
    $stmt = $conn->prepare("
        SELECT
            u.user_id AS instructor_id, 
            u.user_fname, 
            u.user_lname, 
            st.course, 
            st.year,
            sub.code, 
            sub.description,
            sub.id AS subject_id
        FROM 
            tbl_student_instructors si
        JOIN 
            tbl_students st ON si.student_id = st.user_id
        JOIN 
            tbl_users u ON si.instructor_id = u.user_id
        JOIN 
            tbl_subjects sub ON si.subject_id = sub.id
        ORDER BY 
            u.user_id, st.course, st.year
    ");

    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection->close();

// Grouping results by instructor and course, including subject details
$instructors = [];
foreach ($results as $row) {
    $instructor_id = $row['instructor_id'];
    $course = $row['course'];
    $year = $row['year'];
    $subject_code = $row['code'];
    $subject_description = $row['description'];
    $subject_id = $row['subject_id']; // Get subject ID

    // Initialize the instructor if not already done
    if (!isset($instructors[$instructor_id])) {
        $instructors[$instructor_id] = [
            'name' => $row['user_fname'] . ' ' . $row['user_lname'],
            'courses' => []
        ];
    }

    // Initialize the course if not already done
    if (!isset($instructors[$instructor_id]['courses'][$course])) {
        $instructors[$instructor_id]['courses'][$course] = [
            'years' => [],
            'subjects' => []
        ];
    }

    // Add year to the course
    if (!in_array($year, $instructors[$instructor_id]['courses'][$course]['years'])) {
        $instructors[$instructor_id]['courses'][$course]['years'][] = $year;
    }

    // Add subject details to the course, including the subject ID
    $instructors[$instructor_id]['courses'][$course]['subjects'][$subject_id] = [
        'code' => $subject_code,
        'description' => $subject_description
    ];
}
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