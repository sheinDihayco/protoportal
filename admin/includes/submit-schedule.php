<?php
include_once 'connection.php';

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instructor_id = $_POST['instructor'];
    $course_id = $_POST['course'];
    $subject_id = $_POST['subject'];
    $room_id = $_POST['room'];
    $time_id = $_POST['time'];

    $query = "INSERT INTO tbl_schedule (instructor_id, course_id, subject_id, room_id, time_id) 
              VALUES (:instructor_id, :course_id, :subject_id, :room_id, :time_id)";

    $stmt = $conn->prepare($query);
    $stmt->execute([
        ':instructor_id' => $instructor_id,
        ':course_id' => $course_id,
        ':subject_id' => $subject_id,
        ':room_id' => $room_id,
        ':time_id' => $time_id
    ]);

    echo 'Success';
}
?>