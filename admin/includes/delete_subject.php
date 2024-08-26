<?php
include_once "../includes/connect.php";
include_once "../includes/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $subjectId = isset($_POST['id']) ? intval($_POST['id']) : 0;

    if ($subjectId > 0) {
        try {
            $stmt = $database->prepare("DELETE FROM tbl_subjects WHERE id = :id");
            $stmt->bindParam(':id', $subjectId, PDO::PARAM_INT);

            if ($stmt->execute()) {
                echo 'success';
            } else {
                echo 'error';
            }
        } catch (PDOException $e) {
            error_log("Delete Subject Error: " . $e->getMessage());
            echo 'error';
        }
    } else {
        echo 'error';
    }
} else {
    echo 'error';
}

$database = null;
