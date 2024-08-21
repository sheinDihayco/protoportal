<?php
include("../includes/connect.php");
include("../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_fname = $_POST['user_fname'];
    $user_lname = $_POST['user_lname'];
    $user_email = $_POST['user_email'];
    $user_name = $_POST['user_name'];
    $user_pass = password_hash($_POST['user_pass'], PASSWORD_BCRYPT);
    $user_role = $_POST['user_role'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $hire_date = $_POST['hire_date'];
    $department = $_POST['department'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];

    $database = new Connection();
    $db = $database->open();

    try {
        $sql = "INSERT INTO tbl_users (user_fname, user_lname, user_email, user_name, user_pass, user_role, date_of_birth, gender, hire_date, department, phone_number, address)
                VALUES (:user_fname, :user_lname, :user_email, :user_name, :user_pass, :user_role, :date_of_birth, :gender, :hire_date, :department, :phone_number, :address)";

        $stmt = $db->prepare($sql);
        $stmt->execute([
            ':user_fname' => $user_fname,
            ':user_lname' => $user_lname,
            ':user_email' => $user_email,
            ':user_name' => $user_name,
            ':user_pass' => $user_pass,
            ':user_role' => $user_role,
            ':date_of_birth' => $date_of_birth,
            ':gender' => $gender,
            ':hire_date' => $hire_date,
            ':department' => $department,
            ':phone_number' => $phone_number,
            ':address' => $address
        ]);

        echo "User added successfully!";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $database->close();
}
