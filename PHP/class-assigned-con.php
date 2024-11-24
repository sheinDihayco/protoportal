<?php
include_once 'includes/connection.php';

// Get parameters from the URL
$instructor_id = isset($_GET['instructor_id']) ? $_GET['instructor_id'] : '';
$subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : '';
$paymentPeriod = isset($_GET['paymentPeriod']) ? $_GET['paymentPeriod'] : ''; // Filter option

// Initialize the grouped_students array
$grouped_students = [];

if (!empty($instructor_id) && !empty($subject_id)) {
    // Initialize the database connection
    $connection = new Connection();
    $conn = $connection->open();

    try {
        // Base query
        $query = "
            SELECT DISTINCT ts.user_id, ts.fname, ts.lname, ts.course, ts.year, ts.user_name, ts.status,ts.sy,ts.semester, tsi.subject_id, tp.payment_status, tp.paymentPeriod
            FROM tbl_students ts
            INNER JOIN tbl_student_instructors tsi ON ts.user_id = tsi.student_id
            INNER JOIN tbl_subjects tsub ON tsi.subject_id = tsub.id
            LEFT JOIN tbl_payments tp ON ts.user_id = tp.user_id
            WHERE tsi.instructor_id = :instructor_id
            AND tsi.subject_id = :subject_id
        ";

        // Add paymentPeriod filter if selected
        if (!empty($paymentPeriod)) {
            $query .= " AND tp.paymentPeriod = :paymentPeriod";
        }

        $query .= " ORDER BY ts.course, ts.year ASC";

        // Prepare and bind parameters
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
        $stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
        if (!empty($paymentPeriod)) {
            $stmt->bindParam(':paymentPeriod', $paymentPeriod, PDO::PARAM_STR);
        }

        $stmt->execute();

        // Fetch the students
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group students uniquely by user_id to prevent duplicates
        $unique_students = [];
        foreach ($students as $student) {
            $unique_students[$student['user_id']] = $student;
        }

        // Organize the unique students by course and year
        foreach ($unique_students as $student) {
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