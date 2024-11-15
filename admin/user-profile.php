<?php include_once "../templates/header3.php"; ?>
<?php include_once '../PHP/user-profile-con.php' ?>

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

                <h2><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?> <span><?php echo htmlspecialchars($studs["middleInitial"]); ?></span></h2>
                <h3><?php echo htmlspecialchars($studs["course"]); ?> - <?php echo htmlspecialchars($studs["year"]); ?></h3>
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
                          <!-- Personal Details and Academic Details -->
                          <div class="row mb-4 card">
                            <!-- Personal Details -->
                            <div class="col-md-6">
                              <h5 class="card-title">Personal Details</h5>
                          
                              <div class="row">
                                <div class="col-lg-4 label">Full Name</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["lname"]) . ', ' . htmlspecialchars($studs["fname"]) . ' ' . htmlspecialchars($studs["middleInitial"]); ?> <?php echo htmlspecialchars($studs["Suffix"]); ?></div>
                              </div>

                              <div class="row">
                                <div class="col-lg-4 label">School ID</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["user_name"]); ?></div>
                              </div>

                              <div class="row">
                                <div class="col-lg-4 label">Gender</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["gender"]); ?></div>
                              </div>

                              <div class="row">
                                <div class="col-lg-4 label">Date of Birth</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["bdate"]); ?></div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 label">Place of Birth</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["pob"]); ?></div>
                              </div>

                              <div class="row">
                                <div class="col-lg-4 label">Nationality</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["nationality"]); ?></div>
                              </div>
                            </div>

                            <div class="col-lg-6">
                              <div class="row">
                                <div class="col-lg-4 label">Email Address</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["email"]); ?></div>
                              </div>
                            </div>
                          </div>
                          
                          <!-- Academic Details -->
                          <div class="row mb-4 card" >
                            <div class="col-lg-6">
                              <h5 class="card-title">Academic Details</h5>
                              <div class="row">
                                <div class="col-lg-4 label">Course</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["course"]); ?></div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 label">Year</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["year"]); ?></div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 label">Major</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["major"]); ?></div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 label">Civil Status</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["civilStatus"]); ?></div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 label">Religion</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["religion"]); ?></div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 label">Modality</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["modality"]); ?></div>
                              </div>
                              <div class="row">
                                <div class="col-lg-4 label">Facebook Account</div>
                                <div class="col-lg-8"><?php echo htmlspecialchars($studs["fb"]); ?></div>
                              </div>
                            </div>
                          </div>

                          <!-- Address & Contact Information  -->
                          <div class="row mb-4 card">
                                <!-- Address & Contact Information -->
                                <div class="col-md-12">
                                  <h5 class="card-title">Address & Contact Information</h5>
                                  <div class="row">
                                    <div class="col-lg-4 label">Current Address</div>
                                    <div class="col-lg-8"><?php echo htmlspecialchars($studs["curAddress"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-4 label">City</div>
                                    <div class="col-lg-8"><?php echo htmlspecialchars($studs["cityAdd"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-4 label">Zip Code</div>
                                    <div class="col-lg-8"><?php echo htmlspecialchars($studs["zipcode"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-4 label">Phone Number</div>
                                    <div class="col-lg-8"><?php echo htmlspecialchars($studs["contact"]); ?></div>
                                  </div>
                                </div>

                          </div> 

                          <!-- Educational Attainment -->
                          <div class="row mb-4 card" >
                            <!-- Educational Attainment -->
                            <div class="col-md-12">
                              <h5 class="card-title">Educational Attainment</h5>
                              <div class="row">
                                <!-- Primary Details -->
                                <div class="col-lg-6">
                                  <h6 class="card-title">Primary Details</h6>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Name</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["primarySchool"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Address</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["primaryAddress"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">Year Completed</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["primaryCompleted"]); ?></div>
                                  </div>
                                </div>

                                <!-- Intermediate Details -->
                                <div class="col-lg-6">
                                  <h6 class="card-title">Intermediate Details</h6>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Name</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["entermediateSchool"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Address</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["entermediateAddress"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">Year Completed</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["entermediateCompleted"]); ?></div>
                                  </div>
                                </div>
                              </div>

                              <div class="row mt-4">
                                <!-- High School Details -->
                                <div class="col-lg-6">
                                  <h6 class="card-title">Secondary Details</h6>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Name</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["hsSchool"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Address</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["hsAddress"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">Year Completed</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["hsCompleted"]); ?></div>
                                  </div>
                                </div>

                                <!-- Senior High School Details -->
                                <div class="col-lg-6">
                                  <h6 class="card-title">Senior High Details</h6>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Name</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["shSchool"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Address</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["shAddress"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">Year Completed</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["shCompleted"]); ?></div>
                                  </div>
                                </div>
                              </div>

                              <div class="row mt-4">
                                <!-- College Details -->
                                <div class="col-lg-12">
                                  <h6 class="card-title">College Details</h6>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Name</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["collegeSchool"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">School Address</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["collegeAddress"]); ?></div>
                                  </div>
                                  <div class="row">
                                    <div class="col-lg-12 label">Year Completed</div>
                                    <div class="col-lg-12"><?php echo htmlspecialchars($studs["collegeCompleted"]); ?></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
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
                                                  <a href="#" class="btn btn-primary btn-sm" title="Upload new profile image" onclick="document.getElementById('fileInput').click();">
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
                                                  <form action="upload/upload-image1.php" method="post" enctype="multipart/form-data">
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
                                  
                          <form action="upload/insert-student-rec.php" method="post" novalidate>
                              <div class="row mb-3">
                                      <div class="col-md-1">
                                        <label for="user_id" class="form-label">ID:</label>
                                        <input type="text" id="user_id" name="user_id" class="form-control" value="<?php echo htmlspecialchars($studs["user_id"]); ?>" required>
                                      </div>

                                      <div class="col-md-4">
                                        <label for="lname" class="form-label">Last Name:</label>
                                        <input type="text" id="lname" name="lname" class="form-control" value="<?php echo htmlspecialchars($studs["lname"]); ?>" required>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="fname" class="form-label">First Name:</label>
                                        <input type="text" id="fname" name="fname" class="form-control" value="<?php echo htmlspecialchars($studs["fname"]); ?>" required>
                                      </div>
                                      <div class="col-md-2">
                                        <label for="middleInitial" class="form-label">Middle :</label>
                                        <input type="text" id="middleInitial" name="middleInitial" class="form-control" value="<?php echo htmlspecialchars($studs["middleInitial"]); ?>" required>
                                      </div>
                                      <div class="col-md-1">
                                        <label for="Suffix" class="form-label">Suffix:</label>
                                        <input type="text" id="Suffix" name="Suffix" class="form-control" value="<?php echo htmlspecialchars($studs["Suffix"]); ?>" required>
                                      </div>
                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-4">
                                        <label for="user_name" class="form-label">ID Number:</label>
                                        <input type="text" id="user_name" name="user_name" class="form-control" value="<?php echo htmlspecialchars($studs["user_name"]); ?>" required>
                                      </div>
                                      <div class="col-md-3">
                                        <label for="gender" class="form-label">Gender:</label>
                                        <select id="gender" name="gender" class="form-select">
                                          <option value="Male" <?php echo ($studs["gender"] == 'Male') ? 'selected' : ''; ?>required>Male</option>
                                          <option value="Female" <?php echo ($studs["gender"] == 'Female') ? 'selected' : ''; ?>required>Female</option> 
                                        </select>
                                      </div>

                                      
                                      <div class="col-md-4">
                                        <label for="bdate" class="form-label">Date of Birth:</label>
                                        <input type="date" id="bdate" name="bdate" class="form-control" value="<?php echo htmlspecialchars($studs["bdate"]); ?>" required>
                                      </div>
                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-4">
                                        <label for="pob" class="form-label">Place of Birth:</label>
                                        <input type="text" id="pob" name="pob" class="form-control" value="<?php echo htmlspecialchars($studs["pob"]) ?>" required>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="nationality" class="form-label">Nationality :</label>
                                        <input type="text" id="nationality" name="nationality" class="form-control" value="<?php echo htmlspecialchars($studs["nationality"]); ?>" required>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="email" class="form-label">Email Address:</label>
                                        <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($studs["email"]); ?>" required>
                                      </div>
                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-3">
                                        <label for="course" class="form-label">Course:</label>
                                        <input type="text" id="course" name="course" class="form-control" value="<?php echo htmlspecialchars($studs["course"]); ?>" required>
                                      </div>
                                      <div class="col-md-2">
                                        <label for="year" class="form-label">Year:</label>
                                        <input type="text" id="year" name="year" class="form-control" value="<?php echo htmlspecialchars($studs["year"]); ?>" required>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="major" class="form-label">Major :</label>
                                        <input type="text" id="major" name="major" class="form-control" value="<?php echo htmlspecialchars($studs["major"]); ?>" required>
                                      </div>
                                      <div class="col-md-3">
                                        <label for="civilStatus" class="form-label">Civil Status :</label>
                                        <input type="text" id="civilStatus" name="civilStatus" class="form-control" value="<?php echo htmlspecialchars($studs["civilStatus"]); ?>" required>
                                      </div>

                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-4">
                                        <label for="religion" class="form-label">Religion:</label>
                                        <input type="text" id="religion" name="religion" class="form-control" value="<?php echo htmlspecialchars($studs["religion"]) ?>" required>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="modality" class="form-label">Modality :</label>
                                        <input type="text" id="modality" name="modality" class="form-control" value="<?php echo htmlspecialchars($studs["modality"]); ?>" required>
                                      </div>
                                      <div class="col-md-4">
                                        <label for="fb" class="form-label">Facebook Account:</label>
                                        <input type="text" id="fb" name="fb" class="form-control" value="<?php echo htmlspecialchars($studs["fb"]); ?>" required>
                                      </div>
                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-4">
                                        <label for="curAddress" class="form-label">Current Address:</label>
                                        <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" required>
                                      </div>
                                      <div class="col-md-3">
                                        <label for="cityAdd" class="form-label">City :</label>
                                        <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>" required>
                                      </div>
                                      <div class="col-md-3">
                                        <label for="zipcode" class="form-label">Zip Code :</label>
                                        <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" required>
                                      </div>
                                      <div class="col-md-2">
                                        <label for="contact" class="form-label">Phone Number :</label>
                                        <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" required>
                                      </div>

                                    </div>
                                    <div style="margin-top: 5%;"></div>
                                    <div class="row mb-3">
                                      <div class="col-md-4" required>
                                        <label for="curAddress" class="form-label">Permanent Address:</label>
                                        <input type="text" id="curAddress" name="curAddress" class="form-control" value="<?php echo htmlspecialchars($studs["curAddress"]) ?>" required>
                                      </div>
                                      <div class="col-md-3">
                                        <label for="cityAdd" class="form-label">City :</label>
                                        <input type="text" id="cityAdd" name="cityAdd" class="form-control" value="<?php echo htmlspecialchars($studs["cityAdd"]); ?>">
                                      </div>
                                      <div class="col-md-3">
                                        <label for="zipcode" class="form-label">Zip Code :</label>
                                        <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php echo htmlspecialchars($studs["zipcode"]); ?>" required>
                                      </div>
                                      <div class="col-md-2">
                                        <label for="contact" class="form-label">Phone Number :</label>
                                        <input type="text" id="contact" name="contact" class="form-control" value="<?php echo htmlspecialchars($studs["contact"]); ?>" required>
                                      </div>

                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-6">
                                        <label for="fatherName" class="form-label">Father's Name:</label>
                                        <input type="text" id="fatherName" name="fatherName" class="form-control" value="<?php echo htmlspecialchars($studs["fatherName"]); ?>" required>
                                      </div>
                                      <div class="col-md-6">
                                        <label for="fwork" class="form-label">Occupation:</label>
                                        <input type="text" id="fwork" name="fwork" class="form-control" value="<?php echo htmlspecialchars($studs["fwork"]); ?>" required>
                                      </div>
                                    </div>

                                    <div class="row mb-3">
                                      <div class="col-md-6">
                                        <label for="motherName" class="form-label">Mother's Name:</label>
                                        <input type="text" id="motherName" name="motherName" class="form-control" value="<?php echo htmlspecialchars($studs["motherName"]); ?>" required>
                                      </div>
                                      <div class="col-md-6">
                                        <label for="mwork" class="form-label">Occupation:</label>
                                        <input type="text" id="mwork" name="mwork" class="form-control" value="<?php echo htmlspecialchars($studs["mwork"]); ?>" required>
                                      </div>
                                    </div>

                                    <h3 class="text-center mb-4">Educational Attainment</h3>

                                    <table class="table table-bordered">
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
                                          <td><input type="text" name="primarySchool" class="form-control" value="<?php echo htmlspecialchars($studs["primarySchool"]); ?>" required></td>
                                          <td><input type="text" name="primaryAddress" class="form-control" value="<?php echo htmlspecialchars($studs["primaryAddress"]); ?>" required></td>
                                          <td><input type="text" name="primaryCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["primaryCompleted"]); ?>" required></td>
                                        </tr>
                                        <tr>
                                          <td>Intermediate (Grade 5-6)</td>
                                          <td><input type="text" name="entermediateSchool" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateSchool"]); ?>" required></td>
                                          <td><input type="text" name="entermediateAddress" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateAddress"]); ?>" required></td>
                                          <td><input type="text" name="entermediateCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["entermediateCompleted"]); ?>" required></td>
                                        </tr>
                                        <tr>
                                          <td>High School</td>
                                          <td><input type="text" name="hsSchool" class="form-control" value="<?php echo htmlspecialchars($studs["hsSchool"]); ?>" required></td>
                                          <td><input type="text" name="hsAddress" class="form-control" value="<?php echo htmlspecialchars($studs["hsAddress"]); ?>" required></td>
                                          <td><input type="text" name="hsCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["hsCompleted"]); ?>" required></td>
                                        </tr>
                                        <tr>
                                          <td>K12</td>
                                          <td><input type="text" name="shSchool" class="form-control" value="<?php echo htmlspecialchars($studs["shSchool"]); ?>" required></td>
                                          <td><input type="text" name="shAddress" class="form-control" value="<?php echo htmlspecialchars($studs["shAddress"]); ?>" required></td>
                                          <td><input type="text" name="shCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["shCompleted"]); ?>" required></td>
                                        </tr>
                                        <tr>
                                          <td>College</td>
                                          <td><input type="text" name="collegeSchool" class="form-control" value="<?php echo htmlspecialchars($studs["collegeSchool"]); ?>" required></td>
                                          <td><input type="text" name="collegeAddress" class="form-control" value="<?php echo htmlspecialchars($studs["collegeAddress"]); ?>" required></td>
                                          <td><input type="text" name="collegeCompleted" class="form-control" value="<?php echo htmlspecialchars($studs["collegeCompleted"]); ?>" required></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <div style="margin-top: 10%"></div>
                                    <h6 class="text-justify mb-4">I hereby certify that all entries herein are true and correct. I certify further that I will read thoroughly the agreement/policy and commit myself to follow its provision.</h6>

                                    <div class="row mb-3">

                                      <div class="col-md-4">
                                        <label for="date" class="form-label">Date: </label>
                                        <input type="date" id="date" name="date" class="form-control" value="<?php echo htmlspecialchars($studs["date"]); ?>" required>
                                      </div>


                                    </div>

                                    <div class="d-flex justify-content-end">
                                      <button type="submit" class="btn btn-primary" name="submit">Save</button>
                                    </div>
                          </form>
                      </div>
                        
                    </div>
                  </div>
                </div>
              </div>
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
    border: 3px solid blue; 
    object-fit: cover; /* Ensure the image covers the entire area */
  }
</style>
<?php include_once "../templates/footer.php"; ?>

  