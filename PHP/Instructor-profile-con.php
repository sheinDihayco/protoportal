<?php
if (isset($_POST['user_id']) && !empty($_POST['user_id'])) {
  $_SESSION['user'] = $_POST['user_id'];
  $userid = $_POST['user_id'];
} elseif (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
  $_SESSION['user'] = $_GET['user_id'];
  $userid = $_GET['user_id'];
} elseif (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
  $userid = $_SESSION['user'];
} else {
  exit('No user ID provided');
}

// Fetch user details and user image
$statement = $conn->prepare("SELECT user_id FROM tbl_users WHERE user_id = :uid");
$statement->bindParam(':uid', $userid, PDO::PARAM_INT);
$statement->execute();
$userDetails = $statement->fetch(PDO::FETCH_ASSOC);

if ($userDetails) {
  $userid = $userDetails['user_id'];

  // Fetch the user image from tbl_users
  $statementUser = $conn->prepare("SELECT * FROM tbl_users WHERE user_id = :userid");
  $statementUser->bindParam(':userid', $userid, PDO::PARAM_INT);
  $statementUser->execute();
  $user = $statementUser->fetch(PDO::FETCH_ASSOC);

  if ($user && !empty($user["user_image"])) {
    $image = htmlspecialchars($user["user_image"]);
  } else {
    $image = "default.png";  // Set to default image if user doesn't have an image
  }

  // Get the user's last name and role
  $lname = htmlspecialchars($user["user_lname"]);
  $gender = htmlspecialchars($user["gender"]);
  $role = htmlspecialchars($user["user_role"]);
} else {
  exit('User not found');
}

include_once "../templates/header.php";
include_once "includes/connect.php";
include_once "includes/connection.php";

try {
  // Fetching user details from tbl_users
  $statement = $conn->prepare("SELECT * FROM tbl_users WHERE user_id = :uid");
  $statement->bindParam(':uid', $userid, PDO::PARAM_INT);
  $statement->execute();
  $userDetails = $statement->fetch(PDO::FETCH_ASSOC);

  if ($userDetails) {
    $userid = $userDetails['user_id'];

    $statementUser = $conn->prepare("SELECT user_image FROM tbl_users WHERE user_id = :userid");
    $statementUser->bindParam(':userid', $userid, PDO::PARAM_INT);
    $statementUser->execute();
    $user = $statementUser->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user["user_image"])) {
      $userImage = htmlspecialchars($user["user_image"]);
    } else {
      $userImage = "default.jpg";
    }

  } else {
    exit('User not found');
  }
} catch (PDOException $e) {
  echo 'Query failed: ' . $e->getMessage();
  exit;
}
?>

<?php
if (isset($_GET['user_id'])) {
  $user_id = htmlspecialchars($_GET['user_id']);
  // Fetch and display user profile information based on user_id
}

if (isset($_GET['delete-success']) && $_GET['delete-success'] === 'true') {
  echo '<p>Record successfully deleted!</p>';
}
?>


<?php
if (isset($_GET['user_id'])) {
  $user_id = htmlspecialchars($_GET['user_id']);
  // Fetch and display student profile information based on user_id
}

if (isset($_GET['delete-success']) && $_GET['delete-success'] === 'true') {
  echo '<p>Record successfully deleted!</p>';
}
?>

<!-- End #main -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const userId = urlParams.get('user_id');

    // Check if the 'success' parameter is present and if 'user_id' is provided
    if (success === 'created' && userId) {
      Swal.fire({
        icon: 'success',
        title: 'Success',
        text: `Payment status for student ID ${userId} has been successfully added.`,
        showConfirmButton: true
      });
    }
  });
</script>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const success = urlParams.get('success');
    const userId = urlParams.get('user_id');

    // Check if the 'success' parameter is present and if 'user_id' is provided
    if (success === 'updated' && userId) {
      Swal.fire({
        icon: 'success',
        title: 'Update Successful',
        text: `Payment status for student ID ${userId} has been successfully updated.`,
        showConfirmButton: true
      });
    }
  });
</script>

<script>
  function confirmDelete(payment_id, user_id) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Yes, delete it!',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        var formData = new FormData();
        formData.append('payment_id', payment_id);

        fetch('../admin/upload/delete-payment.php', {
            method: 'POST',
            body: formData
          })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              Swal.fire(
                'Deleted!',
                'Your record has been deleted.',
                'success'
              ).then(() => {
                // Redirect using user_id
                window.location.href = "../admin/student_profile.php?user_id=" + encodeURIComponent(user_id) + "&delete-success=true";
              });
            } else {
              Swal.fire(
                'Error!',
                'There was an error deleting the record.',
                'error'
              );
            }
          })
          .catch(error => {
            Swal.fire(
              'Error!',
              'There was an error deleting the record.',
              'error'
            );
          });
      }
    });
  }
</script>

<script>
    // Check if the session variable 'user_updated' is set
    <?php if (isset($_SESSION['employee_updated']) && $_SESSION['employee_updated']): ?>
        // Show SweetAlert success message with OK button
        Swal.fire({
            icon: 'success',
            title: 'Update Completed!',
            text: 'The details have been successfully updated.',
            confirmButtonText: 'OK'
        });

        // Unset the session variable to prevent repeated alerts
        <?php unset($_SESSION['employee_updated']); ?>
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
  .custom-profile-img {
      width: 150px;
      height: 160px;
      object-fit: cover; 
      border-radius: 0; 
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