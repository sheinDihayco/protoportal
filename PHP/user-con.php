
<!-- Vendor JS Files -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

// Check for success or error after deletion
if (isset($_SESSION['delete_success']) && $_SESSION['delete_success'] === true) {
    echo '<script>
    Swal.fire({
        title: "Deleted!",
        text: "Student has been successfully deleted.",
        icon: "success",
        confirmButtonText: "OK"
    });
    </script>';
    unset($_SESSION['delete_success']); // Clear the session variable
}

if (isset($_SESSION['delete_error'])) {
    echo '<script>
    Swal.fire({
        title: "Error!",
        text: "' . $_SESSION['delete_error'] . '",
        icon: "error",
        confirmButtonText: "OK"
    });
    </script>';
    unset($_SESSION['delete_error']); // Clear the session variable
}
?>

<?php
if (isset($_GET['update']) && $_GET['update'] == 'success') {
  echo "
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
            Swal.fire({
                title: 'Updated!',
                text: 'The employee details have been successfully updated.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                }
            });
        </script>";
}
?>

<!-- Vendor JS Files 
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  function confirmDelete() {
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
        // Submit the form if confirmed
        document.getElementById('deleteEmployee').submit();
      }
    });
  }
</script>-->

<script>
  // Check if the session variable 'user_created' is set
  <?php if (isset($_SESSION['user_created']) && $_SESSION['user_created']): ?>
    // Show SweetAlert success message with OK button
    Swal.fire({
      icon: 'success',
      title: 'Registration Successful',
      text: 'The user has been successfully registered!',
      confirmButtonText: 'OK'
    }).then((result) => {
      if (result.isConfirmed) {
        // Redirect to the student page when OK is clicked
        window.location.href = '../admin/user.php';
      }
    });

    // Unset the session variable to prevent repeated alerts
    <?php unset($_SESSION['user_created']); ?>
  <?php endif; ?>
</script>

    <style>
        .custom-profile-img {
        width: 100px; /* Set the desired width */
        height: 100px; /* Set the desired height */
        border-radius: 50%; /* Make it circular */
        object-fit: cover; /* Ensure the image covers the entire area */
        }

    </style>

    
<!-- Vendor JS Files -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Check if the session variable 'user_updated' is set
    <?php if (isset($_SESSION['admin_updated']) && $_SESSION['admin_updated']): ?>
        // Show SweetAlert success message with OK button
        Swal.fire({
            icon: 'success',
            title: 'Update Success',
            text: 'The data has been successfully updated!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the student page when OK is clicked
                window.location.href = '../admin/user-profile-admin.php';
            }
        });

        // Unset the session variable to prevent repeated alerts
        <?php unset($_SESSION['admin_updated']); ?>
    <?php endif; ?>
</script>

<script>
    // Check if the session variable 'user_updated' is set
    <?php if (isset($_SESSION['instructor_updated']) && $_SESSION['instructor_updated']): ?>
        // Show SweetAlert success message with OK button
        Swal.fire({
            icon: 'success',
            title: 'Update Success',
            text: 'The data has been successfully updated!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the student page when OK is clicked
                window.location.href = '../admin/user-profile-instructor.php';
            }
        });

        // Unset the session variable to prevent repeated alerts
        <?php unset($_SESSION['instructor_updated']); ?>
    <?php endif; ?>
</script>
