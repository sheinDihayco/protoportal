<?php include_once "../templates/header3.php"; ?>
<?php include_once '../PHP/user-profile-con.php' ?>

<!-- Start #main -->
<main id="main" class="main" >

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
                        <a class="nav-link nav-profile d-flex align-items-center pe-0 " href="#" data-bs-toggle="dropdown">
                            <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img">
                            <span class="d-none d-md-block dropdown-toggle ps-2 text-white"><?php echo htmlspecialchars($lname)?></span>
                        </a><!-- End Profile Iamge Icon -->

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
                                <form action="upload/upload-image1.php" method="post" enctype="multipart/form-data">
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

                        <form>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                <label for="last-name" class="form-label">Last Name:</label>
                                <input type="text" id="last-name" name="last-name" class="form-control" value="<?php echo htmlspecialchars($studs["lname"]); ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                <label for="first-name" class="form-label">First Name:</label>
                                <input type="text" id="first-name" name="first-name" class="form-control" value="<?php echo htmlspecialchars($studs["fname"]); ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                <label for="middleInitial" class="form-label">Middle :</label>
                                <input type="text" id="middleInitial" name="middleInitial" class="form-control" value="<?php echo htmlspecialchars($studs["middleInitial"]); ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                <label for="Suffix" class="form-label">Suffix:</label>
                                <input type="text" id="Suffix" name="Suffix" class="form-control" value="<?php echo htmlspecialchars($studs["Suffix"]); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                <label for="user_name" class="form-label">ID Number:</label>
                                <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo htmlspecialchars($studs["user_name"]); ?>" readonly>
                                </div>
                                
                                 <div class="col-md-3">
                                    <label for="gender" class="form-label">Gender:</label>
                                    <input type="text" id="gender" name="gend" class="form-control" value="<?php echo ($studs['gender'] == 'M') ? 'Male' : 'Female'; ?>" readonly>
                                </div>

                                <div class="col-md-4">
                                <label for="bdate" class="form-label">Date of Birth:</label>
                                <input type="date" id="bdate" name="bdate" class="form-control" value="<?php echo htmlspecialchars($studs["bdate"]); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                <label for="pob" class="form-label">Place of Birth:</label>
                                <input type="text" id="pob" name="pob" class="form-control" value="<?php echo htmlspecialchars($studs["pob"]) ?>">
                                </div>
                                <div class="col-md-4">
                                <label for="nationality" class="form-label">Nationality :</label>
                                <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo htmlspecialchars($studs["nationality"]); ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                <label for="email" class="form-label">Email Address:</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($studs["email"]); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                <label for="course" class="form-label">Course:</label>
                                <input type="text" id="course" name="course" class="form-control" value="<?php echo htmlspecialchars($studs["course"]); ?>">
                                </div>
                                <div class="col-md-2">
                                <label for="year" class="form-label">Year:</label>
                                <input type="text" id="year" name="year" class="form-control" value="<?php echo htmlspecialchars($studs["year"]); ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                <label for="major" class="form-label">Major :</label>
                                <input type="text" id="major" name="major" class="form-control" value="<?php echo htmlspecialchars($studs["major"]); ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                <label for="civilStatus" class="form-label">Civil Status :</label>
                                <input type="text" id="civilStatus" name="civilStatus" class="form-control" value="<?php echo htmlspecialchars($studs["civilStatus"]); ?>" readonly>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                <label for="religion" class="form-label">Religion:</label>
                                <input type="text" id="religion" name="religion" class="form-control" value="<?php echo htmlspecialchars($studs["religion"]) ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                <label for="modality" class="form-label">Modality :</label>
                                <input type="text" id="modality" name="modality" class="form-control" value="<?php echo htmlspecialchars($studs["modality"]); ?>" readonly>
                                </div>
                                <div class="col-md-4">
                                <label for="fb" class="form-label">Facebook Account:</label>
                                <input type="text" id="fb" name="fb" class="form-control" value="<?php echo htmlspecialchars($studs["fb"]); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-4">
                                <label for="curAddress" class="form-label">Current Address:</label>
                                <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                <label for="cityAdd" class="form-label">City :</label>
                                <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                <label for="zipcode" class="form-label">Zip Code :</label>
                                <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                <label for="contact" class="form-label">Phone Number :</label>
                                <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" readonly>
                                </div>

                            </div>
                            <div style="margin-top: 5%;"></div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                <label for="curAddress" class="form-label">Permanent Address:</label>
                                <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                <label for="cityAdd" class="form-label">City :</label>
                                <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>" readonly>
                                </div>
                                <div class="col-md-3">
                                <label for="zipcode" class="form-label">Zip Code :</label>
                                <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" readonly>
                                </div>
                                <div class="col-md-2">
                                <label for="contact" class="form-label">Phone Number :</label>
                                <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" readonly>
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                <label for="fatherName" class="form-label">Father's Name:</label>
                                <input type="text" id="fatherName" name="fatherName" class="form-control" value="<?php echo htmlspecialchars($studs["fatherName"]); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                <label for="fwork" class="form-label">Occupation:</label>
                                <input type="text" id="fwork" name="fwork" class="form-control" value="<?php echo htmlspecialchars($studs["fwork"]); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                <label for="motherName" class="form-label">Mother's Name:</label>
                                <input type="text" id="motherName" name="motherName" class="form-control" value="<?php echo htmlspecialchars($studs["motherName"]); ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                <label for="mwork" class="form-label">Occupation:</label>
                                <input type="text" id="mwork" name="mwork" class="form-control" value="<?php echo htmlspecialchars($studs["mwork"]); ?>" readonly>
                                </div>
                            </div>

                            <h3 class="text-center mb-4">Educational Attainment</h3>

                            <table class="table table-bordered" readonly>
                                <thead>
                                <tr class="table-secondary">
                                    <th>Level</th>
                                    <th>Name of School</th>
                                    <th>School Address</th>
                                    <th>Year Completed</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td>Primary (Grade 1-4)</td>
                                    <td><input type="text" name="primarySchool" class="form-control" value="<?php echo htmlspecialchars($studs["primarySchool"]); ?>" readonly></td>
                                    <td><input type="text" name="primaryAddress" class="form-control" value="<?php echo htmlspecialchars($studs["primaryAddress"]); ?>" readonly></td>
                                    <td><input type="text" name="primaryCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["primaryCompleted"]); ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td>Intermediate (Grade 5-6)</td>
                                    <td><input type="text" name="entermediateSchool" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateSchool"]); ?>" readonly></td>
                                    <td><input type="text" name="entermediateAddress" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateAddress"]); ?>" readonly></td>
                                    <td><input type="text" name="entermediateCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateCompleted"]); ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td>High School</td>
                                    <td><input type="text" name="hsSchool" class="form-control" value="<?php echo htmlspecialchars($studs["hsSchool"]); ?>" readonly></td>
                                    <td><input type="text" name="hsAddress" class="form-control" value="<?php echo htmlspecialchars($studs["hsAddress"]); ?>" readonly></td>
                                    <td><input type="text" name="hsCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["hsCompleted"]); ?>" readonly></td>
                                </tr>
                                <tr>
                                    <td>K12</td>
                                    <td><input type="text" name="shSchool" class="form-control" value="<?php echo htmlspecialchars($studs["shSchool"]); ?>" readonly></td>
                                    <td><input type="text" name="shAddress" class="form-control" value="<?php echo htmlspecialchars($studs["shAddress"]); ?>" readonly></td>
                                    <td><input type="text" name="shCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["shCompleted"]); ?>" readonly></td>
                                </tr>
                                </tbody>
                            </table>
                            <div style="margin-top: 10%"></div>
                            <h6 class="text-justify mb-4">I hereby certify that all entries herein are true and correct. I certify further that I will read thoroughly the agreement/policy and commit myself to follow its provision.</h6>

                            <div class="row mb-3">

                                <div class="col-md-4">
                                <label for="date" class="form-label">Date Enrolled: </label>
                                <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($studs["date"]); ?>" readonly>
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