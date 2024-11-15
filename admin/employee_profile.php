<?php include_once "../templates/header.php"; ?>
<?php include_once '../PHP/Instructor-profile-con.php' ?>
<?php include_once '../PHP/user-profile-admin-con.php'; ?>

<!-- Start #main -->
<main id="main" class="main">
  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1>Employee Information</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"></li>
      </ol>
    </nav>

  </div>
  <!-- End Page Title -->

  <!-- Start Section -->
    <section class="section profile">
            <div class="row">
                <div class="col-xl-4">

                    <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <a class="nav-link nav-profile" href="#" data-bs-toggle="dropdown">
                            <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img ">
                        </a><!-- End Profile Iamge Icon -->

                        <h2><?php echo htmlspecialchars($userDetails['user_lname']); ?>, <?php echo htmlspecialchars($userDetails['user_fname']); ?> </h2>
                        <h3><?php echo htmlspecialchars($userDetails['user_role']); ?></h3>
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

                        <button type="button" class="icon-button">
                            <a href="../admin/user.php" class="icon-link">
                            <i class="ri-arrow-go-back-line"></i>
                            </a>
                        </button>

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Info</button>
                        </li>
                    </ul>

                    <div class="tab-content pt-2">
                        <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                            
                                        <h5 class="card-title">Profile Details</h5>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Fullname </div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['user_lname']); ?>, <?php echo htmlspecialchars($userDetails['user_fname']); ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Gender</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['gender']); ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Date of Birth</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['date_of_birth']); ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Address</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['address']); ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Email Address</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['user_email']); ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Hire Date</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['hire_date']); ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Department</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['department']); ?></div>
                                        </div>

                                        <div class="row">
                                            <div class="col-lg-3 col-md-4 label">Phone Number</div>
                                            <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($userDetails['phone_number']); ?></div>
                                        </div>
                            </div>
                        </div>
              
                    <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                        <h5 class="card-title"> Intial Details</h5>
                        <form action="functions/update_employee.php" method="post" class="needs-validation" novalidate>
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($userDetails['user_id']); ?>">


                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="last-name" class="form-label">Last Name:</label>
                                    <input type="text" id="last-name" name="last-name" class="form-control" value="<?php echo htmlspecialchars($userDetails['user_lname']); ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="first-name" class="form-label">First Name:</label>
                                    <input type="text" id="first-name" name="first-name" class="form-control" value="<?php echo htmlspecialchars($userDetails['user_fname']); ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <input type="text" id="gender" name="gender" class="form-control" value="<?php echo htmlspecialchars($userDetails['gender']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="date_of_birth" class="form-label">Date of Birth:</label>
                                    <input type="date" id="date_of_birth" name="bdate" class="form-control" value="<?php echo htmlspecialchars($userDetails['date_of_birth']); ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="hire_date" class="form-label">Hire Date:</label>
                                    <input type="date" id="hire_date" name="dhire" class="form-control" value="<?php echo htmlspecialchars($userDetails['hire_date']); ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" id="address" name="add" class="form-control" value="<?php echo htmlspecialchars($userDetails['address']); ?>" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email Address:</label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($userDetails['user_email']); ?>" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label for="department" class="form-label">Department:</label>
                                    <input type="text" id="department" name="dept" class="form-control" value="<?php echo htmlspecialchars($userDetails['department']); ?>" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="phone_number" class="form-label">Phone Number:</label>
                                    <input type="text" id="phone_number" name="cnum" class="form-control" value="<?php echo htmlspecialchars($userDetails['phone_number']); ?>" required>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-primary btn-sm me-2" name="submit">Save Changes</button>
                            </div>
                        </form>
                    </div>

                    </div>
                </div>
            </div>
    </section>
  <!-- Start Section -->
</main>

<style>
  .custom-profile-img {
    width: 100px; /* Set the desired width */
    height: 100px; /* Set the desired height */
    border-radius: 50%; /* Make it circular */
    object-fit: cover; /* Ensure the image covers the entire area */
    border: 3px solid blue; 
  }
</style>

<?php include_once "../templates/footer.php"; ?>