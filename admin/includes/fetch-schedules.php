<?php
include_once 'connection.php';

header('Content-Type: application/json');

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

$query = "
    SELECT s.schedule_id, 
           CONCAT(e.first_name, ' ', e.last_name) AS instructor_name, 
           c.course_description, 
           s.course_id, 
           s.subject_id, 
           CONCAT(sb.description) AS subject_description, 
           r.room_name, 
           s.room_id, 
           CONCAT(st.start_time, ' - ', st.end_time) AS time_slot
    FROM tbl_schedule s
    JOIN tbl_employee e ON s.instructor_id = e.employee_id
    JOIN tbl_course c ON s.course_id = c.course_id
    JOIN tbl_subjects sb ON s.subject_id = sb.id
    JOIN tbl_rooms r ON s.room_id = r.room_id
    JOIN tbl_sched_time st ON s.time_id = st.time_id
";

$stmt = $conn->prepare($query);
$stmt->execute();
$schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($schedules);

$connClass->close();
