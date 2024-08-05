<?php
include_once "../templates/header.php";

$userId = $_SESSION['user_id'];

if (isset($_POST["updateProfile"])) {
    // Handle file upload
    $imagePath = '';
    if (isset($_FILES['user_image']) && $_FILES['user_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'upload-files/'; // Ensure this directory exists and is writable
        $uploadFile = $uploadDir . basename($_FILES['user_image']['name']);

        // Validate file type and size (optional)
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['user_image']['type'], $allowedTypes)) {
            header("location:../profile.php?error=invalidfiletype");
            exit;
        }

        if ($_FILES['user_image']['size'] > 2 * 1024 * 1024) {
            header("location:../profile.php?error=filesizeexceeded");
            exit;
        }

        if (move_uploaded_file($_FILES['user_image']['tmp_name'], $uploadFile)) {
            $imagePath = $uploadFile;
        } else {
            header("location:../profile.php?error=imageuploaderror");
            exit;
        }
    }

    // Update or insert image path
    $statement = $conn->prepare("UPDATE tbl_users SET user_image = :image WHERE user_id = :user_id");
    $statement->bindParam(':image', $imagePath);
    $statement->bindParam(':user_id', $userId);

    // Execute the query
    if ($statement->execute()) {
        header("location:../profile.php?update=success");
    } else {
        $errorInfo = $statement->errorInfo();
        header("location:../profile.php?error=sqlerror");
    }
    exit;
}
