<?php include_once "../templates/header.php"; ?>
<?php include_once '../PHP/student-profile-con.php' ?>
<?php include_once '../PHP/user-student-con.php' ?>
<?php include('modals/add-payment-status.php'); ?>


<!-- Start #main -->
<main id="main" class="main">
  <div class="pagetitle">
      <h1>Student Information</h1>
      <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertPayment">
      </button>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Accounts</li>
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <!-- Start Section -->
  <section class="section profile">
    <div class="row">
     <div class="col-xl-4">
      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <a class="nav-link nav-profile" href="#" data-bs-toggle="dropdown">
                <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img">
            </a><!-- End Profile Iamge Icon -->

          <h2><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?> <span><?php echo htmlspecialchars($studs["middleInitial"]); ?></span></h2>
          <h3><?php echo htmlspecialchars($studs["course"]); ?> - <?php echo htmlspecialchars($studs["year"]); ?> <?php echo htmlspecialchars($studs["major"]); ?></h3>
         
          <div class="social-links mt-2">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      
        <div class="card">
          <div class="card-body pt-3">
            <ul class="nav nav-tabs nav-tabs-bordered">
                <button type="button" class="icon-button">
                  <a href="../admin/user-student.php" class="icon-link">
                    <i class="ri-arrow-go-back-line"></i>
                  </a>
                </button>

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Personal Details</button>
                </li>
              
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#education-overview">More</button>
                </li>
                
                <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Info</button>
                </li>
            </ul>

            <div class="tab-content pt-2">

              <div class="tab-pane fade show active profile-overview" id="profile-overview">
                  <!-- Personal Details-->
                  <div class="row mb-4 ">
                    <div class="col-md-12">
                      <h5 class="card-title">Personal Details</h5>
                      
                      <div class="row">
                        <div class="col-lg-4 label">School ID</div>
                        <div class="col-lg-8"><?php echo htmlspecialchars($studs["user_name"]); ?></div>
                      </div>
                      
                      <div class="row">
                        <div class="col-lg-4 label">Academic Year</div>
                        <div class="col-lg-8"><?php echo htmlspecialchars($studs["sy"]); ?></div>
                      </div>

                      <div class="row">
                        <div class="col-lg-4 label">Full Name</div>
                        <div class="col-lg-8"><?php echo htmlspecialchars($studs["lname"]) . ', ' . htmlspecialchars($studs["fname"]) . ' ' . htmlspecialchars($studs["middleInitial"]); ?> <?php echo htmlspecialchars($studs["Suffix"]); ?></div>
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
                      
                      <div class="row">
                        <div class="col-lg-4 label">Email Address</div>
                        <div class="col-lg-8"><?php echo htmlspecialchars($studs["email"]); ?></div>
                      </div>
                    </div>
                  </div>

                  <!-- Address & Contact Information  -->
                  <div class="row mb-4 ">
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
                  
              </div>

              <div class="tab-pane fade profile-overview" id="education-overview">
                  <div class="row mb-4 " >
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
                <h5 class="card-title">Initial Details</h5>
                  <form action="upload/insert-initial-data.php" method="post" class="needs-validation" novalidate>
                    <!-- Hidden field to pass user_id -->
                    <input type="hidden" name="user_id" value="<?= htmlspecialchars($studs['user_id']); ?>">

                    <!-- Student ID -->
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label for="studentID" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="studentID" name="studentID" value="<?= htmlspecialchars($studs['user_name']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid student ID.</div>
                      </div>

                      <!-- Last Name -->
                      <div class="col-md-6">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" value="<?= htmlspecialchars($studs['lname']); ?>" readonly>
                      </div>
                    </div>

                    <!-- First Name & Course -->
                    <div class="row mb-3">
                      <div class="col-md-6">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="<?= htmlspecialchars($studs['fname']); ?>" readonly>
                      </div>

                      <div class="col-md-6">
                        <label for="course" class="form-label">Course</label>
                        <input type="text" class="form-control" id="course" name="course" value="<?= htmlspecialchars($studs['course']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid course.</div>
                      </div>
                    </div>

                    <!-- Year & Semester -->
                    <div class="row mb-3">
                      <div class="col-md-4">
                        <label for="year" class="form-label">Year</label>
                        <input type="text" class="form-control" id="year" name="year" value="<?= htmlspecialchars($studs['year']); ?>" required>
                        <div class="invalid-feedback">Please provide a valid year.</div>
                      </div>

                      <div class="col-md-4">
                        <label for="sy" class="form-label">Academic Year</label>
                        <select type="text" class="form-control" id="sy" name="sy" value="<?= htmlspecialchars($studs['sy']); ?>" required>
                            <option value="">Select Academic Year</option>
                            <option value="2024-2025" <?= ($studs['sy'] == '2024-2025') ? 'selected' : ''; ?>>2024-2025</option>
                            <option value="2023-2024" <?= ($studs['sy'] == '2023-2024') ? 'selected' : ''; ?>>2023-2024</option>
                            <option value="2022-2023" <?= ($studs['sy'] == '2022-2023') ? 'selected' : ''; ?>>2022-2023</option>
                            <option value="2020-2021" <?= ($studs['sy'] == '2020-2021') ? 'selected' : ''; ?>>2020-2021</option>  
                        </select>
                        <div class="invalid-feedback">Please provide a valid year.</div>
                      </div>

                      <div class="col-md-4">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester" required>
                          <option value="" disabled>Select Semester</option>
                          <option value="1" <?= ($studs['semester'] == '1') ? 'selected' : ''; ?>>1</option>
                          <option value="2" <?= ($studs['semester'] == '2') ? 'selected' : ''; ?>>2</option>
                        </select>
                        <div class="invalid-feedback">Please select a valid semester.</div>
                      </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-3">
                      <label for="status" class="form-label">Status</label>
                      <select class="form-select" id="status" name="status" required>
                        <option value="" disabled>Select Status</option>
                        <option value="Enrolled" <?= ($studs['status'] == 'Enrolled') ? 'selected' : ''; ?>>Enrolled</option>
                        <option value="Unenrolled" <?= ($studs['status'] == 'Unenrolled') ? 'selected' : ''; ?>>Unenrolled</option>
                      </select>
                      <div class="invalid-feedback">Please select a valid status.</div>
                    </div>

                    <!-- Save and Close buttons -->
                    <div class="d-flex justify-content-end mt-3">
                      <button type="submit" class="btn btn-primary btn-sm me-2" name="submit">Save</button>
                      <!--<button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>-->
                    </div>
                  </form>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
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