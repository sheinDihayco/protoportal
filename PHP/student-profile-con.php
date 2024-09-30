<?php
if (isset($_POST['stud_id']) && !empty($_POST['stud_id'])) {
  $_SESSION['stud'] = $_POST['stud_id'];
  $studid = $_POST['stud_id'];
} elseif (isset($_GET['user_id']) && !empty($_GET['user_id'])) {
  $_SESSION['stud'] = $_GET['user_id'];
  $studid = $_GET['user_id'];
} elseif (isset($_SESSION['stud']) && !empty($_SESSION['stud'])) {
  $studid = $_SESSION['stud'];
} else {
  exit('No student ID provided');
}

// Fetch student details and user image
$statement = $conn->prepare("SELECT user_id FROM tbl_students WHERE user_id = :sid");
$statement->bindParam(':sid', $studid, PDO::PARAM_INT);
$statement->execute();
$studs = $statement->fetch(PDO::FETCH_ASSOC);

if ($studs) {
  $userid = $studs['user_id'];

  // Fetch the user image from tbl_users
  $statementUser = $conn->prepare("SELECT user_image, lname FROM tbl_students WHERE user_id = :userid");
  $statementUser->bindParam(':userid', $userid, PDO::PARAM_INT);
  $statementUser->execute();
  $user = $statementUser->fetch(PDO::FETCH_ASSOC);

  if ($user && !empty($user["user_image"])) {
    $image = htmlspecialchars($user["user_image"]);
  } else {
    $image = "default.png";  // Set to default image if user doesn't have an image
  }

  // Get the student's last name
  $lname = htmlspecialchars($user["lname"]);
} else {
  exit('Student not found');
}

include_once "../templates/header.php";
include_once "includes/connect.php";
include_once "includes/connection.php";

try {
  // Fetching student details from tbl_students
  $statement = $conn->prepare("SELECT * FROM tbl_students WHERE user_id = :sid");
  $statement->bindParam(':sid', $studid, PDO::PARAM_INT);
  $statement->execute();
  $studs = $statement->fetch(PDO::FETCH_ASSOC);

  if ($studs) {
    $userid = $studs['user_id'];

    $statementUser = $conn->prepare("SELECT user_image FROM tbl_users WHERE user_id = :userid");
    $statementUser->bindParam(':userid', $userid, PDO::PARAM_INT);
    $statementUser->execute();
    $user = $statementUser->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user["user_image"])) {
      $userImage = htmlspecialchars($user["user_image"]);
    } else {
      $userImage = "default.jpg";
    }

    // Check if the studentID has a record in tbl_payments
    $paymentStmt = $conn->prepare("SELECT COUNT(*) AS count_payments FROM tbl_payments WHERE user_id = :user_id");
    $paymentStmt->bindParam(':user_id', $studid, PDO::PARAM_INT);
    $paymentStmt->execute();
    $paymentCount = $paymentStmt->fetch(PDO::FETCH_ASSOC);

    // Determine if the button should be displayed
    $showButton = ($paymentCount['count_payments'] == 0);
  } else {
    exit('Student not found');
  }
} catch (PDOException $e) {
  echo 'Query failed: ' . $e->getMessage();
  exit;
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
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
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

  #signature-pad {
    border: 1px solid #000;
    background-color: #fff;
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
       border: 5px solid gray; 
      border-radius: 0; 
      display: block; 
      margin: 0 auto; 
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