<?php
include_once 'includes/connection.php';

// Check if instructor_id is passed in the URL
if (isset($_GET['user_id'])) {
    $instructor_id = $_GET['user_id'];

    // Initialize database connection
    $connection = new Connection();
    $conn = $connection->open();

    // Initialize $students array
    $students = [];

    try {
        // Query to get students assigned to the selected instructor
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
} else {
    echo "<p>Instructor not found.</p>";
    exit();
}
?>