<?php
include_once 'includes/connection.php';

$userid = $_SESSION['login'];

$connection = new Connection();
$conn = $connection->open();

$results = [];

try {
    // Modified query to select only the records for the logged-in student
    $stmt = $conn->prepare("
        SELECT
            st.user_id AS student_id,  -- Using student_id instead of instructor_id
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
        WHERE 
            st.user_id = :userid  -- Filter results for the current student
        ORDER BY 
            u.user_id, st.course, st.year
    ");

    // Bind the current user ID to the prepared statement
    $stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection->close();

// Grouping results by course, including subject details
$courses = [];
foreach ($results as $row) {
    $course = $row['course'];
    $year = $row['year'];
    $subject_code = $row['code'];
    $subject_description = $row['description'];
    $subject_id = $row['subject_id']; // Get subject ID

    // Initialize the course if not already done
    if (!isset($courses[$course])) {
        $courses[$course] = [
            'years' => [],
            'subjects' => []
        ];
    }

    // Add year to the course
    if (!in_array($year, $courses[$course]['years'])) {
        $courses[$course]['years'][] = $year;
    }

    // Add subject details to the course, including the subject ID
    $courses[$course]['subjects'][$subject_id] = [
        'code' => $subject_code,
        'description' => $subject_description
    ];
}
?>