<?php

include("../includes/connect.php");
include("../includes/connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the JSON body
    $data = json_decode(file_get_contents('php://input'), true);
    $subjectId = $data['id'];

    // Open database connection
    $database = new Connection();
    $db = $database->open();

    try {
        // Prepare the SQL delete statement
        $sql = "DELETE FROM tbl_subjects WHERE id = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $subjectId);

        // Execute the delete statement
        if ($stmt->execute()) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Unable to delete the subject.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    } finally {
        $database->close();
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>  