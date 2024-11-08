<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=schooldb', 'root', '');

// Initialize variables
$grades = [];
$studentInfo = null;
$years = [];
$semesters = [];

// Get distinct years and semesters
$yearStmt = $pdo->query("SELECT DISTINCT year FROM tbl_grades ORDER BY year");
$years = $yearStmt->fetchAll(PDO::FETCH_COLUMN);

$semesterStmt = $pdo->query("SELECT DISTINCT semester FROM tbl_grades ORDER BY semester");
$semesters = $semesterStmt->fetchAll(PDO::FETCH_COLUMN);

// Check if the search form was submitted
if (isset($_POST['search']) && isset($_POST['user_name'])) {
    $searchTerm = '%' . $_POST['user_name'] . '%';
    $selectedYear = $_POST['year'] ?? '';
    $selectedSemester = $_POST['semester'] ?? '';

    // Prepare the SQL statement to get student info
    $studentStmt = $pdo->prepare("
        SELECT 
            s.user_name,
            s.lname,
            s.fname,
            s.middleInitial,
            s.user_id,
            s.year,
            s.semester,
            s.course
        FROM 
            tbl_students s
        WHERE 
            s.user_name LIKE :searchTerm
    ");
    $studentStmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $studentStmt->execute();

    // Fetch the student information
    $studentInfo = $studentStmt->fetch(PDO::FETCH_ASSOC);

    if ($studentInfo) {
        // Prepare the SQL statement to get grades for all terms
        $gradesStmt = $pdo->prepare("
            SELECT 
                sub.code,
                sub.description,
                sub.unit,
                g.term,
                g.grade,
                g.year,
                g.semester
            FROM 
                tbl_grades g
            JOIN 
                tbl_subjects sub ON g.id = sub.id
            WHERE 
                g.user_id = :user_id
                AND (:selectedYear = '' OR g.year = :selectedYear)
                AND (:selectedSemester = '' OR g.semester = :selectedSemester)
        ");
        $gradesStmt->bindParam(':user_id', $studentInfo['user_id'], PDO::PARAM_INT);
        $gradesStmt->bindParam(':selectedYear', $selectedYear, PDO::PARAM_STR);
        $gradesStmt->bindParam(':selectedSemester', $selectedSemester, PDO::PARAM_STR);
        $gradesStmt->execute();

        // Fetch the grades
        $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const userNameField = document.getElementById('user_name');
        const yearField = document.getElementById('year');
        const semesterField = document.getElementById('semester');

        // Function to check the state of the first field
        function checkFields() {
            if (userNameField.value.trim() === '') {
                yearField.disabled = true;
                semesterField.disabled = true;
            } else {
                yearField.disabled = false;
                semesterField.disabled = false;
            }
        }

        // Initial check
        checkFields();

        // Add event listeners to check the fields when the user types
        userNameField.addEventListener('input', checkFields);
    });

    function clearSearchForm() {
        document.getElementById('user_name').value = '';
        document.getElementById('year').selectedIndex = 0;
        document.getElementById('semester').selectedIndex = 0;

        // Disable year and semester fields
        document.getElementById('year').disabled = true;
        document.getElementById('semester').disabled = true;
    }
</script>


