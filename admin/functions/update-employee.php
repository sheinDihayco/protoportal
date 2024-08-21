<?php
include("../includes/connect.php");
include("../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $date_of_birth = $_POST['bdate'];
    $gender = $_POST['gend'];
    $hire_date = $_POST['dhire'];
    $department = $_POST['dept'];
    $phone_number = $_POST['cnum'];
    $address = $_POST['add'];

    $database = new Connection();
    $db = $database->open();

    try {
        $sql = "UPDATE tbl_users SET
                date_of_birth = :date_of_birth,
                gender = :gender,
                hire_date = :hire_date,
                department = :department,
                phone_number = :phone_number,
                address = :address
                WHERE user_id = :user_id";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':date_of_birth' => $date_of_birth,
            ':gender' => $gender,
            ':hire_date' => $hire_date,
            ':department' => $department,
            ':phone_number' => $phone_number,
            ':address' => $address,
            ':user_id' => $user_id
        ]);

        echo "User updated successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $database->close();
}
