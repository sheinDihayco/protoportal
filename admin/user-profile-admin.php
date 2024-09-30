<?php include_once "../templates/header.php"; ?>
<?php include_once '../PHP/user-profile-admin-con.php'; ?>

<!-- Start #main -->
<main id="main" class="main">

    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Personal Information</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../admin/index3.php">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <!-- Start Section Page -->
    <section class="section dashboard">
        <div class="tab-pane" id="profile-overview">
            <div class="container my-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">

                        <!-- Profile Section -->
                        <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                            <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img">
                            <span class="d-none d-md-block dropdown-toggle ps-2 text-white"><?php echo htmlspecialchars($user_lname); ?></span>
                        </a><!-- End Profile Image Icon -->

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

                                    <!-- Save Button styled as a dropdown item, initially hidden -->
                                    <a class="dropdown-item d-flex align-items-center" id="saveButton" href="javascript:void(0);" style="display: none;" onclick="document.getElementById('saveButtonForm').click();">
                                        <i class="ri-save-line"></i>
                                        <span>Save</span>
                                    </a>

                                    <!-- Hidden submit button for the form -->
                                    <button type="submit" id="saveButtonForm" style="display: none;" name="save"></button>
                                </form>
                            </li>
                        </ul>

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

                        <!-- End Profile Image Icon -->
                        <hr class="mb-4">

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

                                <div class="col-md-2">
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
                </div>
            </div>
        </div>
    </section>
    <!-- End Section Page -->

</main><!-- End #main -->

<?php include_once "../templates/footer.php"; ?>
