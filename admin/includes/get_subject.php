<?php
include("../includes/connect.php");
include("../includes/connection.php");
session_start();

$connection = new Connection();
$pdo = $connection->open();
if (isset($_GET['id'])) {
    $subjectId = $_GET['id'];
    $database = new Connection();
    $db = $database->open();

    try {
        $stmt = $db->prepare("SELECT * FROM tbl_subjects WHERE id = :id");
        $stmt->execute(['id' => $subjectId]);
        $subject = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($subject) {
            // Return subject data as JSON
            echo json_encode($subject);
        } else {
            echo json_encode(null); // No subject found
        }
    } catch (PDOException $e) {
        echo json_encode(null); // Error fetching subject
    }

    $database->close();
} else {
    echo json_encode(null); // No ID provided
}
