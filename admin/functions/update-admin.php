<?php
include("../includes/connect.php");
include("../includes/connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $date_of_birth = $_POST['bdate'];
    $gender = $_POST['gend'];
    // Assuming you have a field for hire date in your form
    $hire_date = $_POST['dhire']; // Ensure this field is present in your form
    $department = $_POST['dept'];
    $phone_number = $_POST['cnum'];
    $address = $_POST['add'];

    // Create a new connection instance
    $database = new Connection();
    $db = $database->open();

    try {
        // Prepare the SQL update statement
        $sql = "UPDATE tbl_users SET
                date_of_birth = :date_of_birth,
                gender = :gender,
                hire_date = :hire_date,
                department = :department,
                phone_number = :phone_number,
                address = :address
                WHERE user_id = :user_id";

        // Prepare and execute the statement
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

        // Set session variable to indicate a successful update
        $_SESSION['admin_updated'] = true;
        // Redirect to user profile page after successful update
        header("Location: ../user-profile-admin.php?update=success");
        exit(); // Ensure no further code is executed after redirect
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    // Close the database connection
    $database->close();
} else {
    echo "Invalid request method.";
}