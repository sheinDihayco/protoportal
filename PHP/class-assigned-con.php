<?php
include_once 'includes/connection.php';

// Get instructor_id and subject_id from the URL parameters
$instructor_id = isset($_GET['instructor_id']) ? $_GET['instructor_id'] : '';
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';

// Initialize the grouped_students array
$grouped_students = [];

if (!empty($instructor_id) && !empty($subject_id)) {
    // Initialize the database connection
    $connection = new Connection();
    $conn = $connection->open();

    try {
        // Query to get students assigned to the selected instructor and subject (grouped by subject_id)
        $stmt = $conn->prepare("
            SELECT ts.user_id, ts.fname, ts.lname, ts.course, ts.year, ts.user_name, tsi.subject_id
            FROM tbl_students ts
            INNER JOIN tbl_student_instructors tsi ON ts.user_id = tsi.student_id
            INNER JOIN tbl_subjects tsub ON tsi.subject_id = tsub.id
            WHERE tsi.instructor_id = :instructor_id
            AND tsi.subject_id = :subject_id
            ORDER BY ts.course, ts.year ASC
        ");
        $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the students
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group students by subject_id (as well as course and year)
        foreach ($students as $student) {
            $course_year_key = "{$student['course']} - {$student['year']}";
            $grouped_students[$student['subject_id']][$course_year_key][] = $student;
        }

    } catch (PDOException $e) {
        echo "<p>Error fetching student data: " . htmlspecialchars($e->getMessage()) . "</p>";
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>Invalid instructor or subject information.</p>";
}
?>