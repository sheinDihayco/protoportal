<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "schooldb";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    if (isset($_POST['id'])) {
        $subjectId = $_POST['id'];

        // Prepare and execute the query to delete the subject
        $query = $pdo->prepare("DELETE FROM subjects WHERE id = :id");
        $query->bindParam(':id', $subjectId, PDO::PARAM_INT);
        $query->execute();

        echo json_encode(['status' => 'success']);
    }
}
