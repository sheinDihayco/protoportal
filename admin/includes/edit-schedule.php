<?php
include_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve POST data
    $scheduleId = $_POST['schedule_id'] ?? '';
    $instructor = $_POST['instructor'] ?? '';
    $course = $_POST['course'] ?? '';
    $subject = $_POST['subject'] ?? '';
    $room = $_POST['room'] ?? '';
    $time = $_POST['time'] ?? '';
    $day = $_POST['day'] ?? ''; // Corrected from $days to $day

    if (!$scheduleId || !$instructor || !$course || !$subject || !$room || !$time || !$day) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    try {
        $connClass = new Connection();
        $conn = $connClass->open();

        $sql = "UPDATE tbl_schedule
                SET instructor_id = :instructor,
                    course_id = :course,
                    subject_id = :subject,
                    room_id = :room,
                    time_id = :time,
                    day_id = :day
                WHERE schedule_id = :schedule_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':schedule_id', $scheduleId, PDO::PARAM_INT);
        $stmt->bindParam(':instructor', $instructor, PDO::PARAM_INT);
        $stmt->bindParam(':course', $course, PDO::PARAM_INT);
        $stmt->bindParam(':subject', $subject, PDO::PARAM_INT);
        $stmt->bindParam(':room', $room, PDO::PARAM_INT);
        $stmt->bindParam(':time', $time, PDO::PARAM_INT);
        $stmt->bindParam(':day', $day, PDO::PARAM_INT); // Corrected binding

        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to update schedule']);
        }
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
    } finally {
        $connClass->close(); // Properly close the connection
    }
}
