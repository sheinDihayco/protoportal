<?php
include_once 'connection.php';

header('Content-Type: application/json');

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

$query = "
    SELECT s.schedule_id, 
           CONCAT(u.user_fname, ' ', u.user_lname) AS instructor_name, 
           c.course_description, 
           s.course_id, 
           s.subject_id, 
           CONCAT(sb.description) AS subject_description, 
           r.room_name, 
           s.room_id, 
           CONCAT(st.start_time, ' - ', st.end_time) AS time_slot,
           s.day_id,
           d.day_name
    FROM tbl_schedule s
    JOIN tbl_users u ON s.instructor_id = u.user_id
    JOIN tbl_course c ON s.course_id = c.course_id
    JOIN tbl_subjects sb ON s.subject_id = sb.id
    JOIN tbl_rooms r ON s.room_id = r.room_id
    JOIN tbl_sched_time st ON s.time_id = st.time_id
    JOIN tbl_days d ON s.day_id = d.day_id
    ";

$stmt = $conn->prepare($query);
$stmt->execute();
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($schedules);

$connClass->close();
