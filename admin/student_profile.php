<?php include_once "../templates/header.php"; ?>
<?php include_once '../PHP/student-profile-con.php' ?>

<!-- Start #main -->
<main id="main" class="main">
  <!-- Start Page Title -->
  <div class="pagetitle">
    <h1><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?></h1>

    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
    </button>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo htmlspecialchars($studs["course"]); ?></li>
      </ol>
    </nav>

  </div>
  <!-- End Page Title -->

  <!-- Start Modal Insert Student -->
  <div class="modal fade" id="insertStudent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Insert Payment Status</h5>
        </div>
        <div class="modal-body">
          <form action="../admin/upload/insert-payment-status.php" id="paymentForm" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
            <div class="col-md-6">
              <label for="user_id" class="form-label">Student ID</label>
              <input type="number" class="form-control" id="user_id" name="user_id" value="<?php echo htmlspecialchars($studid); ?>" required readonly>
              <div class="invalid-feedback">
                Please enter a valid student ID.
              </div>
            </div>
            <div class="col-md-6">
              <label for="semester" class="form-label">Semester</label>
              <select class="form-select" id="semester" name="semester" required>
                <option value="">Choose...</option>
                <option value="1st">1st</option>
                <option value="2nd">2nd</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="col-md-6">
              <label for="paymentPeriod" class="form-label">Payment Period</label>
              <select class="form-select" id="paymentPeriod" name="paymentPeriod" required>
                <option value="">Choose...</option>
                <option value="Prelim">Prelim</option>
                <option value="Midterm">Midterm</option>
                <option value="Pre-final">Pre-final</option>
                <option value="Final">Final</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="col-md-6">
              <label for="payment_status" class="form-label">Status</label>
              <select class="form-select" id="payment_status" name="payment_status" required>
                <option value="">Choose...</option>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Overdue">Overdue</option>
              </select>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit" id="savePayment">Save</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- End Modal Insert Student -->

  <!-- Start Section -->
  <section class="section profile">
    <div class="col-lg-12">
      <div class="row">
        <!-- Recent Sales -->
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <button type="button" class="icon-button">
                <a href="../admin/user-student.php" class="icon-link">
                  <i class="ri-arrow-go-back-line"></i>
                </a>
              </button>


              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment-status">Payment Status</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit Info</button>
              </li>
            </ul>
            <!-- End Bordered Tabs -->

            <div class="tab-content pt-2">
              <div class="tab-pane fade show active" id="payment-status">
                <div class="card-body">
                  <h5 class="card-title">Students <span>| Enrolled</span></h5>

                  <table class="table table-borderless">
                    <thead>
                      <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">Semester</th>
                        <th scope="col">Payment Period</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $servername = "localhost";
                      $username = "root";
                      $password = "";
                      $dbname = "schooldb";

                      // Create connection
                      $conn = new mysqli($servername, $username, $password, $dbname);

                      // Check connection
                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }

                      $sql = 'SELECT s.*, p.*
                          FROM tbl_students s 
                          LEFT JOIN tbl_payments p ON s.user_id = p.user_id
                          WHERE s.user_id = ?';

                      if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("s", $studid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                      ?>
                          <tr>
                            <th scope="row"><a href=""><?php echo htmlspecialchars($row["user_name"]); ?></a></th>

                            <td><?php echo htmlspecialchars($row["semester"]) ? htmlspecialchars($row["semester"]) : 'Choose semester'; ?></td>

                            <td><?php echo htmlspecialchars($row["paymentPeriod"]) ? htmlspecialchars($row["paymentPeriod"]) : 'Choose payment period'; ?></td>

                            <td><?php echo htmlspecialchars($row["payment_status"]) ? htmlspecialchars($row["payment_status"]) : 'Not Available'; ?></td>

                            <td>
                              <div style="display: inline;">
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill"
                                  data-bs-toggle="modal" data-bs-target="#updatePaymentStatus<?php echo $row['payment_id']; ?>"></button>

                                <!-- Space Between Buttons -->
                                <div style="display: inline-block;"></div>

                                <!-- Example PHP code to include user_id -->
                                <?php
                                // Assuming $row['user_id'] contains the user ID
                                $user_id = htmlspecialchars($row['user_id']);
                                $payment_id = htmlspecialchars($row['payment_id']);
                                ?>

                                <!-- Delete Button with SweetAlert Confirmation -->
                                <form id="deleteForm<?php echo $payment_id; ?>" method="POST" action="../admin/upload/delete-payment.php" style="display: inline;">
                                  <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
                                  <input type="hidden" id="user_id<?php echo $payment_id; ?>" value="<?php echo $user_id; ?>">
                                  <button type="button" class="btn btn-sm btn-danger ri-delete-bin-6-line"
                                    onclick="confirmDelete(<?php echo $payment_id; ?>, '<?php echo $user_id; ?>')"></button>
                                </form>


                              </div>

                              <?php include('modals/update-payment-form.php'); ?>
                            </td>




                          </tr>
                      <?php
                        }

                        $stmt->close();
                      } else {
                        echo "Error preparing statement: " . $conn->error;
                      }

                      $conn->close();
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <!--Start Profile Overview-->
              <div class="tab-pane fade" id="profile-overview">
                <div class="container my-5">
                  <div class="card shadow-sm"> 
                    <h3 class="text-center mb-4">Student Personal Data - Enrollment</h3>
                    <div class="card-body p-4">
                    
                   <a class="nav-link nav-profile d-flex align-items-center pe-0 custom-nav-link" href="#" data-bs-toggle="dropdown">
                      <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img">
                      <span class="d-none d-md-block dropdown-toggle ps-2 text-white custom-name"><?php echo htmlspecialchars($lname); ?></span>
                  </a>

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

                          <div class="col-md-4">
                            <label for="gender" class="form-label"> Gender </label>
                            <input type="text" id="gender" name="gender" class="form-control" value="<?php echo htmlspecialchars($studs["gender"]); ?>" readonly>
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

                        <!-- <div class="d-flex justify-content-end">
                          <button type="submit" class="btn btn-primary">Update</button>
                        </div>-->
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!--End Profile Overview-->

              <!--Start Profile Edit-->
              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                <div class="row mb-3">
                  <div class="col-md-2 col-lg-9">
                    <label class="col-sm-6 col-form-label">Editing is not permitted on this page.</label>
                  </div>
                </div>
              </div>
              <!--End Profile Edit-->
            </div>




          </div><!-- End Bordered Tabs -->
        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>
  <!-- Start Section -->

</main>

<?php include_once "../templates/footer.php"; ?>