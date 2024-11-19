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

<?php
// Assuming the form is submitted via POST and semester is set
$selectedSemester = isset($_POST['semester']) ? $_POST['semester'] : '';
$selectedYear = isset($_POST['year']) ? $_POST['year'] : '';

// Map semester values to display text (optional)
$semesterText = [
    '1' => '1st',
    '2' => '2nd',
];
$yearText = [
    '1' => '1',
    '2' => '2',
    '3' => '3',
    '4' => '4',
    '11' => '11',
    '12' => '12', 
    
];

// Display the semester if selected
?>

<style>
    .card-title {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
    }

    .info-row {
        display: flex;
        justify-content: space-between;  /* Spaces the items between left and right */
        margin-bottom: 8px; /* Space between rows */
    }

    .info-item {
        display: flex;
        align-items: center;
        flex-basis: 45%; /* Make sure each item takes up equal space */
    }

    .info-item strong {
        margin-right: 10px; /* Space between label and value */
    }

    /* Optional: Responsive design for smaller screens */
    @media (max-width: 768px) {
        .info-row {
            flex-direction: column; /* Stack the rows vertically */
            align-items: flex-start;
        }

        .info-item {
            flex-basis: 100%;  /* Make each item take the full width */
        }
    }

</style>

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


