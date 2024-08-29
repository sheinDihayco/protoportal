<?php

include_once "connect.php";
session_start(); // Start the session

if (isset($_POST["login"])) {
    $identifier = trim($_POST["identifier"]);
    $pass = trim($_POST["password"]);
    $remember = isset($_POST["remember"]);

    try {
        // Query to check if the identifier exists in tbl_students
        $stmt = $conn->prepare("SELECT * FROM tbl_students WHERE user_name = :identifier");
        $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
        $stmt->execute();

        // If no rows are returned from tbl_students, check tbl_users
        if ($stmt->rowCount() === 0) {
            $stmt = $conn->prepare("SELECT * FROM tbl_users WHERE user_name = :identifier");
            $stmt->bindParam(':identifier', $identifier, PDO::PARAM_STR);
            $stmt->execute();
        }

        // Check if the query returned any rows
        if ($stmt->rowCount() > 0) {
            $account = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($account) {
                $password = $account["user_pass"];
                $checkpass = password_verify($pass, $password);

                if ($checkpass === false) {
                    header("location:../login.php?error=wrongpass");
                    exit;
                } else {
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
                    switch ($account["user_role"]) {
                        case "admin":
                            header("location:../index.php");
                            break;
                        case "teacher":
                            header("location:../index2.php");
                            break;
                        case "student":
                            header("location:../index3.php");
                            break;
                        default:
                            header("location:../login.php?error=unknownrole");
                            break;
                    }
                    exit;
                }
            }
        } else {
            header("location:../login.php?error=nouser");
            exit;
        }
    } catch (PDOException $e) {
        // Log the error for debugging (in a real application, consider logging this to a file)
        error_log("Error during login: " . $e->getMessage());
        header("location:../login.php?error=queryfailed");
        exit;
    }
}
