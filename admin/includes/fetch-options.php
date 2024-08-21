<?php
include_once 'connection.php';

header('Content-Type: application/json');

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

function fetchOptions($table, $valueField, $textField)
{
    global $conn;
    $options = [];
    $stmt = $conn->prepare("SELECT $valueField, $textField FROM $table");
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options[] = $row;
    }
    return $options;
}

$data = [
    'instructors' => fetchOptions('tbl_users', 'user_id', 'CONCAT(user_fname, " ", user_lname) AS name'),
    'courses' => fetchOptions('tbl_course', 'course_id', 'CONCAT(course_description, " (Year ", course_year, ")") AS description'),
    'subjects' => fetchOptions('tbl_subjects', 'id', 'description'),
    'rooms' => fetchOptions('tbl_rooms', 'room_id', 'room_name'),
    'times' => fetchOptions('tbl_sched_time', 'time_id', 'CONCAT(start_time, " - ", end_time) AS slot')
];

echo json_encode($data);
