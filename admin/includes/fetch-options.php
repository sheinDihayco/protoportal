<?php
include_once 'connection.php';

header('Content-Type: application/json');

// Create an instance of the Connection class
$connClass = new Connection();
$conn = $connClass->open();

function fetchOptions($table, $valueField, $textField, $whereClause = '')
{
    global $conn;
    $options = [];
    $query = "SELECT $valueField, $textField FROM $table";
    if ($whereClause) {
        $query .= " WHERE $whereClause";
    }
    $stmt = $conn->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options[] = $row;
    }
    return $options;
}

$data = [
    'instructors' => fetchOptions('tbl_users', 'user_id', 'CONCAT(user_fname, " ", user_lname) AS name', 'user_role = "teacher"'),
    'courses' => fetchOptions('tbl_course', 'course_id', 'CONCAT(course_description, " (Year ", course_year, ")") AS description'),
    'subjects' => fetchOptions('tbl_subjects', 'id', 'description'),
    'rooms' => fetchOptions('tbl_rooms', 'room_id', 'room_name'),
    'times' => fetchOptions('tbl_sched_time', 'time_id', 'CONCAT(start_time, " - ", end_time) AS slot'),
    'days' => fetchOptions('tbl_days', 'day_id', 'day_name')
];

echo json_encode($data);

$connClass->close();
