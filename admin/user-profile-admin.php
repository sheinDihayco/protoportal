<?php include_once "../templates/header.php";?>
<?php include_once '../PHP/user-profile-admin-con.php'; ?>
<?php include_once '../PHP/user-con.php' ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="../admin/index3.php">Home</a></li>
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
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Profile</button>
                </li>

              </ul>
        <div class="tab-content pt-2">

            <div class="tab-pane fade show active profile-overview" id="profile-overview">
                <form action="" method="post">
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"> 

                    <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="last-name" class="form-label">Last Name:</label>
                                    <input type="text" id="last-name" name="last-name" class="form-control" value="<?php echo htmlspecialchars($studs['user_lname']); ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="first-name" class="form-label">First Name:</label>
                                    <input type="text" id="first-name" name="first-name" class="form-control" value="<?php echo htmlspecialchars($studs['user_fname']); ?>" readonly>
                                </div>

                                <div class="col-md-3">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <input type="text" id="gender" name="gend" class="form-control" value="<?php echo ($studs['gender'] == 'M') ? 'Male' : 'Female'; ?>" readonly>
                                </div>


                    </div>

                    <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="date_of_birth" class="form-label">Date of Birth:</label>
                                    <input type="date" id="date_of_birth" name="bdate" class="form-control" value="<?php echo htmlspecialchars($studs['date_of_birth']); ?>" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" id="address" name="add" class="form-control" value="<?php echo htmlspecialchars($studs['address']); ?>" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="email" class="form-label">Email Address:</label>
                                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($studs['user_email']); ?>" readonly>
                                </div>
                    </div>

                    <div class="row mb-3">

                                <div class="col-md-4">
                                    <label for="department" class="form-label">Department:</label>
                                    <input type="text" id="department" name="dept" class="form-control" value="<?php echo htmlspecialchars($studs['department']); ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="phone_number" class="form-label">Phone Number:</label>
                                    <input type="text" id="phone_number" name="cnum" class="form-control" value="<?php echo htmlspecialchars($studs['phone_number']); ?>" readonly>
                                </div>

                    </div>
                </form>
            </div>
      
            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <!-- Profile Edit Form -->
                <div class="row mb-3">
                            <label for="profileImage" class="col-md-4 col-lg-3 col-form-label">Profile Image</label>
                            <div>
                                <!-- Profile Section -->
                                <div class="d-flex flex-column align-items-center">
                                    <a class="nav-link nav-profile" href="#" data-bs-toggle="dropdown">
                                        <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img">
                                    </a>

                                    <div class="mt-2">
                                        <a href="#" class="btn btn-primary btn-s" title="Upload new profile image" onclick="document.getElementById('fileInput').click();">
                                            <i class="bi bi-upload"></i>
                                        </a>
                                        <a class="btn btn-success btn-sm" id="saveButton" href="javascript:void(0);" style="display: none;" onclick="document.getElementById('saveButtonForm').click();">
                                            <i class="ri-save-line"></i>
                                        </a>
                                    </div>
                                </div><!-- End Profile Image Section -->

                                <!-- Dropdown Menu for Profile Update -->
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <!-- Update Profile Button to trigger file input -->
                                        <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" onclick="document.getElementById('fileInput').click();">
                                            <i class="ri-image-add-line" id="updateProfileIcon"></i>
                                            <span id="updateProfileText">Update Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <!-- Profile Section for Image Upload -->
                                        <form action="upload/upload-image.php" method="post" enctype="multipart/form-data">
                                            <input type="file" id="fileInput" name="file" style="display: none;" onchange="previewImageAndShowSaveButton();" />

                                            <!-- Hidden submit button for the form -->
                                            <button type="submit" id="saveButtonForm" style="display: none;" name="save"></button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                </div>

                <script>
                            function previewImageAndShowSaveButton() {
                                var fileInput = document.getElementById('fileInput');
                                var currentPhoto = document.getElementById('currentPhoto');
                                var saveButton = document.getElementById('saveButton');
                                var updateProfileText = document.getElementById('updateProfileText');
                                var updateProfileIcon = document.getElementById('updateProfileIcon');

                                // Check if a file is selected
                                if (fileInput.files && fileInput.files[0]) {
                                    var reader = new FileReader();
                                    reader.onload = function (e) {
                                        // Replace the current profile image with the new selected image
                                        currentPhoto.src = e.target.result;
                                    }
                                    reader.readAsDataURL(fileInput.files[0]);

                                    // Display the save button and hide "Update Profile" text and icon
                                    saveButton.style.display = 'block';
                                    updateProfileText.style.display = 'none';
                                    updateProfileIcon.style.display = 'none';
                                }
                            }
                </script>

                <form action="functions/update-admin.php" method="post" class="needs-validation" novalidate>
                    <!-- Hidden field to pass user_id -->
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']); ?>">

                    <!-- Date of Birth -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="bdate" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="bdate" name="bdate" value="<?= htmlspecialchars($row['date_of_birth']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid date of birth.</div>
                        </div>
                        <!-- Gender -->
                        <div class="col-md-6">
                        <label for="gend" class="form-label">Gender</label>
                        <select class="form-select" id="gend" name="gend" required>
                            <option value="" disabled>Select Gender</option>
                            <option value="Male" <?= ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?= ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                        </select>
                        <div class="invalid-feedback">Please select a valid gender.</div>
                        </div>
                    </div>

                    <!-- Date Hired & Job Title -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="dhire" class="form-label">Date Hired</label>
                        <input type="date" class="form-control" id="dhire" name="dhire" value="<?= htmlspecialchars($row['hire_date']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid hire date.</div>
                        </div>

                        <div class="col-md-6">
                        <label for="user_role" class="form-label">Job Title</label>
                        <input type="text" class="form-control" id="user_role" name="user_role" value="<?= htmlspecialchars($row['user_role']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid job title.</div>
                        </div>
                    </div>

                    <!-- Department & Contact Number -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                        <label for="dept" class="form-label">Department</label>
                        <input type="text" class="form-control" id="dept" name="dept" value="<?= htmlspecialchars($row['department']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid department.</div>
                        </div>

                        <div class="col-md-6">
                        <label for="cnum" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="cnum" name="cnum" value="<?= htmlspecialchars($row['phone_number']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid contact number.</div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="mb-3">
                        <label for="add" class="form-label">Address</label>
                        <input type="text" class="form-control" id="add" name="add" value="<?= htmlspecialchars($row['address']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid address.</div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary btn-sm me-2" name="submit">Save Changes</button>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
                
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->
<?php include_once "../templates/footer.php"; ?>

  