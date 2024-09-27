<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=schooldb', 'root', '');

// Initialize variables
$grades = [];
$studentInfo = null;
$subjects = [];

// Get distinct subject codes
$subjectStmt = $pdo->query("SELECT DISTINCT code FROM tbl_subjects ORDER BY code");
$subjects = $subjectStmt->fetchAll(PDO::FETCH_COLUMN);

// Check if the search form was submitted
if (isset($_POST['search']) && isset($_POST['user_name'])) {
  $searchTerm = '%' . $_POST['user_name'] . '%';
  $enteredCode = $_POST['subject_code'] ?? '';

  // Query to get students assigned to the specific instructor
  $sql = "
    SELECT s.user_id, s.lname, s.fname, s.course, s.year, s.status, s.user_name
    FROM tbl_students s
    INNER JOIN tbl_student_instructors si ON s.user_id = si.student_id
    WHERE si.instructor_id = :instructor_id
      AND s.user_name LIKE :searchTerm";
  $studentStmt = $pdo->prepare($sql);
  $studentStmt->bindParam(':instructor_id', $userid, PDO::PARAM_INT); // Assuming $userid is the logged-in instructor
  $studentStmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
  $studentStmt->execute();

  // Fetch the student information
  $studentInfo = $studentStmt->fetch(PDO::FETCH_ASSOC);

  if ($studentInfo) {
    // Fetch grades based on the selected subject code
    $gradesStmt = $pdo->prepare("
      SELECT sub.code, sub.description, sub.unit, g.term, g.grade
      FROM tbl_grades g
      JOIN tbl_subjects sub ON g.id = sub.id
      WHERE g.user_id = :user_id
        AND (:enteredCode = '' OR sub.code = :enteredCode)");
    $gradesStmt->bindParam(':user_id', $studentInfo['user_id'], PDO::PARAM_INT);
    $gradesStmt->bindParam(':enteredCode', $enteredCode, PDO::PARAM_STR);
    $gradesStmt->execute();

    // Fetch the grades
    $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);
  }
}
?>


<script>
  document.addEventListener('DOMContentLoaded', function() {
    const userNameField = document.getElementById('user_name');
    const subjectCodeField = document.getElementById('subject_code');

    // Function to check the state of the first field
    function checkFields() {
      if (userNameField.value.trim() === '') {
        subjectCodeField.disabled = true;
      } else {
        subjectCodeField.disabled = false;
      }
    }

    // Initial check
    checkFields();

    // Add event listeners to check the fields when the user types
    userNameField.addEventListener('input', checkFields);
  });

  function clearSearchForm() {
    document.getElementById('user_name').value = '';
    document.getElementById('subject_code').value = '';
  }
</script>

<script>
  function clearSearchForm() {
    // Clear all input fields in the form
    document.querySelectorAll('form input, form select').forEach(input => input.value = '');

    // Check if the form is empty, and hide the section if it is
    const isFormEmpty = Array.from(document.querySelectorAll('form input, form select'))
      .every(input => input.value === '');

    if (isFormEmpty) {
      const gradeResult = document.querySelector('.gradeResult');
      if (gradeResult) {
        gradeResult.style.display = 'none';
      }
    }
  }
</script>

<!-- Add custom CSS to remove underlines -->
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

  body {
    background-color: #f8f9fa;
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

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">