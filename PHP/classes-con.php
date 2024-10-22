<?php
include_once 'includes/connection.php';

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
        sub.description
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

    // Add subject details to the course
    $instructors[$instructor_id]['courses'][$course]['subjects'][] = [
        'code' => $subject_code,
        'description' => $subject_description
    ];
}
?>
