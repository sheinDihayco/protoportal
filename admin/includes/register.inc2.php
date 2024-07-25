<?php
include("connect.php");
include("connection.php");

function emptyInputSignup($fname, $lname, $email, $username, $password, $role)
{
    return empty($fname) || empty($lname) || empty($email) || empty($username) || empty($password) || empty($role);
}

function invalidUsername($username)
{
    return !preg_match("/^[a-zA-Z0-9]*$/", $username);
}

function invalidPassword($password)
{
    return strlen($password) < 6 || !preg_match('/[A-Z]/', $password) || !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password);
}

function usernameExists($conn, $username, $email)
{
    $sql = "SELECT * FROM tbl_users WHERE user_name = :username OR user_email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

if (isset($_POST["submit"])) {
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    if (emptyInputSignup($fname, $lname, $email, $username, $password, $role)) {
        header("location: ../register.php?error=emptyinput&fname=$fname&lname=$lname&email=$email&username=$username&role=$role");
        exit();
    }

    if (invalidUsername($username)) {
        header("location: ../register.php?error=invalidusername&fname=$fname&lname=$lname&email=$email&username=$username&role=$role");
        exit();
    }

    if (invalidPassword($password)) {
        header("location: ../register.php?error=invalidpassword&fname=$fname&lname=$lname&email=$email&username=$username&role=$role");
        exit();
    }

    $database = new Connection();
    $dbs = $database->open();

    if (usernameExists($dbs, $username, $email)) {
        header("location: ../register.php?error=userexists&fname=$fname&lname=$lname&email=$email&username=$username&role=$role");
        exit();
    }

    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO tbl_users (user_fname, user_lname, user_email, user_name, user_pass, user_role) VALUES (:fname, :lname, :email, :username, :password, :role)";
        $stmt = $dbs->prepare($sql);
        $stmt->bindParam(':fname', $fname);
        $stmt->bindParam(':lname', $lname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $hashedPwd);
        $stmt->bindParam(':role', $role);
        $stmt->execute();
        header("location: ../user.php?error=none");
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $database->close();
} else {
    header("location: ../user.php");
    exit();
}
