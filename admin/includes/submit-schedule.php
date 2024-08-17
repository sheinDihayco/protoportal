<?php
include_once 'connection.php';

$connClass = new Connection();
$conn = $connClass->open();

$instructor_id = $_POST['instructor'];
$course_id = $_POST['course'];
$subject_id = $_POST['subject'];
$room_id = $_POST['room'];
$time_id = $_POST['time'];

// Check for overlapping schedules
$overlapCheckQuery = "
    SELECT * FROM tbl_schedule 
    WHERE (room_id = :room_id 
    AND time_id = :time_id)
    OR (instructor_id = :instructor_id 
    AND time_id = :time_id)
    OR (course_id = :course_id 
    AND time_id = :time_id)";

$stmt = $conn->prepare($overlapCheckQuery);
$stmt->execute([
    ':room_id' => $room_id,
    ':time_id' => $time_id,
    ':instructor_id' => $instructor_id,
    ':course_id' => $course_id,
]);

if ($stmt->rowCount() > 0) {
    // Overlap found, send error response
    echo json_encode(['error' => 'The selected time slot overlaps with an existing schedule.']);
} else {
    // No overlap, proceed with inserting the new schedule
    $insertQuery = "
        INSERT INTO tbl_schedule (instructor_id, course_id, subject_id, room_id, time_id) 
        VALUES (:instructor_id, :course_id, :subject_id, :room_id, :time_id)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->execute([
        ':instructor_id' => $instructor_id,
        ':course_id' => $course_id,
        ':subject_id' => $subject_id,
        ':room_id' => $room_id,
        ':time_id' => $time_id,
    ]);

    echo json_encode(['success' => 'Schedule has been added.']);
}

$connClass->close();
?>
