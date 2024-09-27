<?php 

if (isset($_SESSION['delete_success']) && $_SESSION['delete_success']) {
  echo "
<script>
  Swal.fire({
    title: 'Deleted!',
    text: 'The employee has been successfully deleted.',
    icon: 'success',
    confirmButtonText: 'OK'
  }).then(function() {
  });
</script>";
  unset($_SESSION['delete_success']);
}

if (isset($_SESSION['delete_error'])) {
  echo "
<script>
  Swal.fire({
    title: 'Error!',
    text: '" . addslashes($_SESSION['
    delete_error ']) . "',
    icon: 'error',
    confirmButtonText: 'OK'
  }).then(function() {
  });
</script>";
  unset($_SESSION['delete_error']);
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

<!-- Vendor JS Files -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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
</script>

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
