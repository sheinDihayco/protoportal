<?php
session_start(); // Start the session

include_once 'connection.php';

header('Content-Type: application/json');

$connClass = new Connection();
$conn = $connClass->open();

$instructor_id = $_POST['instructor'];
$course_id = $_POST['course'];
$subject_id = $_POST['subject'];
$room_id = $_POST['room'];
$time_id = $_POST['time'];
$day_id = $_POST['day'];

// Check for overlapping schedules
$overlapCheckQuery = "
    SELECT * FROM tbl_schedule 
    WHERE (room_id = :room_id 
    AND time_id = :time_id
    AND day_id = :day_id)
    OR (instructor_id = :instructor_id 
    AND time_id = :time_id
    AND day_id = :day_id)
    OR (course_id = :course_id 
    AND time_id = :time_id
    AND day_id = :day_id)";

$stmt = $conn->prepare($overlapCheckQuery);
$stmt->execute([
    ':room_id' => $room_id,
    ':time_id' => $time_id,
    ':day_id' => $day_id,
    ':instructor_id' => $instructor_id,
    ':course_id' => $course_id,
]);

if ($stmt->rowCount() > 0) {
    // Overlap found, send error response
    echo json_encode(['error' => 'The selected time slot overlaps with an existing schedule.']);
} else {
    // No overlap, proceed with inserting the new schedule
    $insertQuery = "
        INSERT INTO tbl_schedule (instructor_id, course_id, subject_id, room_id, time_id, day_id) 
        VALUES (:instructor_id, :course_id, :subject_id, :room_id, :time_id, :day_id)";
    $stmt = $conn->prepare($insertQuery);
    
    if ($stmt->execute([
        ':instructor_id' => $instructor_id,
        ':course_id' => $course_id,
        ':subject_id' => $subject_id,
        ':room_id' => $room_id,
        ':time_id' => $time_id,
        ':day_id' => $day_id,
    ])) {
        // Insert successful
        $_SESSION['schedule_success'] = "Schedule created successfully.";
        echo json_encode(['success' => 'Schedule created successfully.']);
    } else {
        // Insert failed
        echo json_encode(['error' => 'Failed to create the schedule. Please try again.']);
    }
}

$connClass->close();
