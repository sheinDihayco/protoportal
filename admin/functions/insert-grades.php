<?php
include("../includes/connect.php");
include("../includes/connection.php");

if (isset($_POST['register'])) {
    $database = new Connection();
    $db = $database->open();

    // Retrieve the data from the form
    $user_id = $_POST['user_id'] ?? null;
    $id = $_POST['subject'] ?? null;
    $year = $_POST['year'] ?? null;
    $semester = $_POST['semester'] ?? null;
    $term = $_POST['term'] ?? null;
    $grade = $_POST['grade'] ?? null;

    // Ensure none of the required fields are missing
    if ($user_id && $id && $year && $semester && $term && $grade) {
        // Prepare and execute the insert query
        try {
            $sql = "INSERT INTO tbl_grades (user_id,year,semester, term, grade, id) VALUES (:user_id,:year,:semester, :term, :grade, :id )";
            $stmt = $db->prepare($sql);

            // Bind the parameters
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindParam(':year', $year, PDO::PARAM_INT);
            $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
            $stmt->bindParam(':term', $term, PDO::PARAM_STR);
            $stmt->bindParam(':grade', $grade, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the query
            if ($stmt->execute()) {
                header("Location:../studentRecords.php");
                exit();
            } else {
                echo "<script>alert('Failed to add grade');</script>";
            }
        } catch (PDOException $e) {
            echo "There was an error: " . $e->getMessage();
        }
    } else {
        echo "<script>alert('Please fill in all required fields.');</script>";
    }

    $database->close();
}
