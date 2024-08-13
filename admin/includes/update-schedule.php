<?php
include_once 'connection.php';

$connClass = new Connection();
$conn = $connClass->open();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedule_id = $_POST['schedule_id'];
    $instructor = $_POST['instructor'];
    $course = $_POST['course'];
    $subject = $_POST['subject'];
    $room = $_POST['room'];
    $time = $_POST['time'];

    try {
        $stmt = $conn->prepare("
            UPDATE tbl_schedule
            SET instructor_id = :instructor, course_id = :course, subject_id = :subject, room_id = :room, time_id = :time
            WHERE schedule_id = :schedule_id
        ");

        $stmt->bindParam(':schedule_id', $schedule_id);
        $stmt->bindParam(':instructor', $instructor);
        $stmt->bindParam(':course', $course);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':room', $room);
        $stmt->bindParam(':time', $time);

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update schedule.']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}
?>