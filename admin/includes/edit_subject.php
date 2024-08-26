<?php
include_once "../includes/connect.php";
include_once "../includes/connection.php";

// Check if the 'id' parameter is set in the query string
if (isset($_GET['id'])) {
    $subjectId = $_GET['id'];

    // Prepare the SQL statement to fetch the subject details
    $stmt = $pdo->prepare("SELECT code, description, lec, lab, unit, pre_req, total FROM tbl_subjects WHERE id = :id");
    $stmt->bindParam(':id', $subjectId, PDO::PARAM_INT);

    // Execute the statement
    $stmt->execute();

    // Fetch the subject details as an associative array
    $subject = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the subject was found
    if ($subject) {
        // Return the subject details as JSON
        echo json_encode($subject);
    } else {
        // Return an error message if the subject was not found
        echo json_encode(['error' => 'Subject not found']);
    }
} else {
    // Return an error message if the 'id' parameter is missing
    echo json_encode(['error' => 'Invalid request']);
}
