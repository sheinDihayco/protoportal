<?php include_once "../templates/header2.php"; ?>
<?php include_once '../PHP/user-profile-admin-con.php'; ?>
<?php include_once '../PHP/user-con.php' ?>


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../admin/index2.php">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                <a class="nav-link nav-profile" href="#" data-bs-toggle="dropdown">
                    <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img">
                </a><!-- End Profile Iamge Icon -->

              <h2><?php echo htmlspecialchars($studs['user_lname']); ?>, <?php echo htmlspecialchars($studs['user_fname']); ?> </h2>
              <h3><?php echo htmlspecialchars($studs['user_role']); ?></h3>
              <div class="social-links mt-2">
                <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-settings">Settings</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li>

              </ul>
              
            <div class="tab-content pt-2">

                <div class="tab-pane show active fade pt-3" id="profile-settings">
                  <!-- Settings Form -->
                    <form>

                      <div class="row mb-3">
                        <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                        <div class="col-md-8 col-lg-9">
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="changesMade" checked>
                            <label class="form-check-label" for="changesMade">
                              Changes made to your account
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="newProducts" checked>
                            <label class="form-check-label" for="newProducts">
                              Information on new products and services
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="proOffers">
                            <label class="form-check-label" for="proOffers">
                              Marketing and promo offers
                            </label>
                          </div>
                          <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="securityNotify" checked disabled>
                            <label class="form-check-label" for="securityNotify">
                              Security alerts
                            </label>
                          </div>
                        </div>
                      </div>

                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                      </div>
                    </form><!-- End settings Form -->
                </div>

                <div class="tab-pane fade pt-3" id="profile-change-password">
                  <!-- Change Password Form -->
                  <form action="../admin/includes/change-pass-instructor.php" method="post" accept-charset="UTF-8">

                      <div class="row mb-3">
                          <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="currentPassword" type="password" class="form-control" id="currentPassword" required>
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="newPassword" type="password" class="form-control" id="newPassword" required>
                          </div>
                      </div>

                      <div class="row mb-3">
                          <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                          <div class="col-md-8 col-lg-9">
                              <input name="renewPassword" type="password" class="form-control" id="renewPassword" required>
                          </div>
                      </div>

                      <div class="text-center">
                          <button type="submit" class="btn btn-primary">Change Password</button>
                      </div>
                  </form>
                  <!-- End Change Password Form -->
                </div>

              </div><!-- End Bordered Tabs -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

   <style>
        .custom-profile-img {
        width: 100px; /* Set the desired width */
        height: 100px; /* Set the desired height */
        border-radius: 50%; /* Make it circular */
        object-fit: cover; /* Ensure the image covers the entire area */
        }

    </style>

<?php include_once "../templates/footer.php"; ?>

<script>
    // Check if the session variable 'user_updated' is set
    <?php if (isset($_SESSION['change_password']) && $_SESSION['change_password']): ?>
        // Show SweetAlert success message with customized button and styling
        Swal.fire({
            icon: 'success',
            title: 'Update Completed!',
            text: 'Your password has been successfully updated.',
            confirmButtonText: 'OK',
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the admin page when OK is clicked
                window.location.href = '../admin/index2.php';
            }
        });

        // Unset the session variable to prevent repeated alerts
        <?php unset($_SESSION['change_password']); ?>
    <?php endif; ?>
</script>

<script>
    // Check if the session variable 'not_change_password' is set
    <?php if (isset($_SESSION['not_change_password']) && $_SESSION['not_change_password']): ?> 
        // Show SweetAlert error message with customized button and styling
        Swal.fire({
            icon: 'error',  // Use 'error' icon for failed updates
            title: 'Update Failed!',
            text: 'Your password could not be updated. Please check your inputs and try again.',
            confirmButtonText: 'Try Again',
        }).then((result) => {
            if (result.isConfirmed) {
                // Optionally redirect to the change password page or stay on the same page
                window.location.href = '../admin/change-pass-instructor.php';  // Redirect to the change password page
            }
        });

        // Unset the session variable to prevent repeated alerts
        <?php unset($_SESSION['not_change_password']); ?>
    <?php endif; ?>
</script>