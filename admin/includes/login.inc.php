<?php
include_once "connect.php";

if (isset($_POST["login"])) {
    $identifier = $_POST["identifier"]; // Could be username or school ID
    $pass = $_POST["password"];
    $remember = isset($_POST["remember"]);

    // Determine if the identifier is a school ID or username
    $column = preg_match('/^[a-zA-Z0-9-]+$/', $identifier) ? 'user_name' : 'user_name';

    $statement = $conn->prepare("SELECT * FROM tbl_users WHERE user_name = :identifier");
    $statement->bindParam(':identifier', $identifier);
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

            if ($remember) {
                setcookie("rememberedIdentifier", $identifier, time() + (86400 * 30), "/"); // 30 days
                setcookie("rememberedPassword", $pass, time() + (86400 * 30), "/"); // 30 days
            } else {
                setcookie("rememberedIdentifier", "", time() - 3600, "/"); // Expire cookie
                setcookie("rememberedPassword", "", time() - 3600, "/"); // Expire cookie
            }

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
