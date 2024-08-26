<?php
include_once "../includes/connect.php";
include_once "../includes/connection.php";

header('Content-Type: application/json'); // Ensure the content type is set to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subjectId = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($subjectId > 0) {
        try {
            $stmt = $database->prepare("SELECT * FROM tbl_subjects WHERE id = :id");
            $stmt->bindParam(':id', $subjectId, PDO::PARAM_INT);
            $stmt->execute();
            $subject = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($subject) {
                echo json_encode($subject);
            } else {
                echo json_encode(['error' => 'Subject not found']);
            }
        } catch (PDOException $e) {
            error_log("Get Subject Error: " . $e->getMessage());
            echo json_encode(['error' => 'An error occurred']);
        }
    } else {
        echo json_encode(['error' => 'Invalid ID']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}

$database = null;
