<?php
include_once "connect.php";

if (isset($_POST["login"])) {
    $user = $_POST["username"];
    $pass = $_POST["password"];

    $statement = $conn->prepare("SELECT * FROM tbl_users WHERE user_name = :username");
    $statement->bindParam(':username', $user);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $password = $user["user_pass"];
        $checkpass = password_verify($pass, $password);

        if ($checkpass === false) {
            header("location:../login.php?error=wrongpass");
            exit;
        } else {
            session_start();
            $_SESSION['login'] = $user["user_id"];
            $_SESSION['role'] = $user["user_role"]; // Store user role in session

            // Redirect based on role
            if ($user["user_role"] == "admin") {
                header("location:../index.php");
            } elseif ($user["user_role"] == "teacher") {
                header("location:../index2.php");
            } elseif ($user["user_role"] == "student") {
                header("location:../index3.php");
            } else {
                header("location:../login.php?error=unknownrole");
            }
            exit;
        }
    } else {
        header("location:../login.php?error=nouser");
        exit;
    }
}
