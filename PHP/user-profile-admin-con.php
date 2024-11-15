<?php

// Include connection
include_once "includes/connection.php";
$connection = new Connection();
$pdo = $connection->open();

// Fetch the logged-in user's data using the session variable
$userid = $_SESSION['login']; // Assuming 'login' stores the user_id of the logged-in user

$sql = "SELECT * FROM tbl_users WHERE user_id = :userid";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':userid', $userid, PDO::PARAM_INT);
$stmt->execute();

// Fetch the user data
$studs = $stmt->fetch(PDO::FETCH_ASSOC);

// Close the connection
$connection->close();
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  // Check if the session variable 'user_created' is set
  <?php if (isset($_SESSION['profile_updated']) && $_SESSION['profile_updated']): ?>
    // Show SweetAlert success message with OK button
    Swal.fire({
      icon: 'success',
      title: 'Update Completed',
      text: 'Your profile has been successfully updated.',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect to the student page when OK is clicked
        window.location.href = '../admin/user-profile-admin.php';
      }
    });

    // Unset the session variable to prevent repeated alerts
    <?php unset($_SESSION['profile_updated']); ?>
  <?php endif; ?>
</script>

<style>
  .icon-button {
    border: none;
    background: transparent;
    padding: 0;
    cursor: pointer;
    display: flex;
    align-items: center;
  }

  .icon-link {
    color: black;
    text-decoration: none;
    display: flex;
    align-items: center;
  }

  .icon-button i {
    font-size: 20px;
  }

  a {
    text-decoration: none !important;
  }

  .breadcrumb-item a {
    text-decoration: none !important;
  }

  .breadcrumb-item.active {
    text-decoration: none;
  }

  .navbar-brand {
    text-decoration: none !important;
  }
  /* Styling the profile name */
  .custom-name {
    font-weight: 500; /* Medium weight for the text */
    font-size: 16px; /* Font size */
    color: #f8f9fa; /* Text color */
  }

  /* Add some padding between image and text */
  .custom-nav-link .ps-2 {
    padding-left: 10px;
  }

</style>
