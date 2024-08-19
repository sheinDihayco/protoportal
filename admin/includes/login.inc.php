<?php
include_once "connect.php";

if (isset($_POST["login"])) {
    $identifier = trim($_POST["identifier"]);
    $pass = trim($_POST["password"]);
    $remember = isset($_POST["remember"]);

    // Check in tbl_users
    $statement = $conn->prepare("SELECT * FROM tbl_users WHERE user_name = :identifier");
    $statement->bindParam(':identifier', $identifier);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // If not found in tbl_users, check in tbl_students
    if (!$user) {
        $statement = $conn->prepare("SELECT * FROM tbl_students WHERE user_name = :identifier");
        $statement->bindParam(':identifier', $identifier);
        $statement->execute();
        $student = $statement->fetch(PDO::FETCH_ASSOC);
    }

    if ($user || $student) {
        $account = $user ? $user : $student;
        $password = $account["user_pass"];
        $checkpass = password_verify($pass, $password);

        if ($checkpass === false) {
            header("location:../login.php?error=wrongpass");
            exit;
        } else {
            session_start();
            $_SESSION['login'] = $account["user_id"];
            $_SESSION['role'] = $account["user_role"];
            $_SESSION['login_success'] = true;

            if ($remember) {
                setcookie("rememberedIdentifier", $identifier, time() + (86400 * 30), "/");
                setcookie("rememberedPassword", $pass, time() + (86400 * 30), "/");
            } else {
                setcookie("rememberedIdentifier", "", time() - 3600, "/");
                setcookie("rememberedPassword", "", time() - 3600, "/");
            }

            // Redirect based on role
            if ($account["user_role"] == "admin") {
                header("location:../index.php");
            } elseif ($account["user_role"] == "teacher") {
                header("location:../index2.php");
            } elseif ($account["user_role"] == "student") {
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
