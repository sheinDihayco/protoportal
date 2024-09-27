<?php
if (!isset($_SESSION["login"])) {
    header("location:login.php?error=loginfirst");
    exit;
}

$userid = $_SESSION["login"];

// Prepare and execute the query
$statements = $conn->prepare("SELECT * FROM tbl_students WHERE user_id = :userid");
$statements->bindParam(':userid', $userid, PDO::PARAM_INT);
$statements->execute();
$user = $statements->fetch(PDO::FETCH_ASSOC);

// Check if user data was found
if ($user) {
    $fname = $user['fname'];
    $lname = $user['lname'];
} else {
    // Handle the case where the user is not found
    echo "User not found.";
    exit;
}
?>

<style>
    .alert {
        padding: 20px;
        background-color: #4CAF50;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
        border-radius: 4px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 1000;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>