<?php
include_once "connect.php";

if (isset($_POST["login"])) {
    $identifier = $_POST["identifier"];
    $pass = $_POST["password"];
    $remember = isset($_POST["remember"]);

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
            $_SESSION['role'] = $user["user_role"];
            $_SESSION['login_success'] = true;

            if ($remember) {
                setcookie("rememberedIdentifier", $identifier, time() + (86400 * 30), "/");
                setcookie("rememberedPassword", $pass, time() + (86400 * 30), "/");
            } else {
                setcookie("rememberedIdentifier", "", time() - 3600, "/");
                setcookie("rememberedPassword", "", time() - 3600, "/");
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
