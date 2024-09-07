<?php include_once "../templates/header.php";

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

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Instructor Account Records</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
    </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Accounts</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <!-- Start Insert Employee-->
  <div class="modal fade" id="insertStudent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="includes/register.inc.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
            <div class="col-12">
              <label for="role" class="form-label">Role</label>
              <select name="role" id="role" class="form-select" required>
                <option value="" disabled selected>Select your role</option>
                <option value="admin">Admin</option>
                <option value="teacher">Teacher</option>
                <option value="student">Student</option>
              </select>
              <div class="invalid-feedback">Please select a role.</div>
            </div>

            <div class="col-12">
              <label for="firstName" class="form-label">First Name</label>
              <input type="text" name="firstName" class="form-control" id="firstName" required>
              <div class="invalid-feedback">Please enter your first name.</div>
            </div>

            <div class="col-12">
              <label for="lastName" class="form-label">Last Name</label>
              <input type="text" name="lastName" class="form-control" id="lastName" required>
              <div class="invalid-feedback">Please enter your last name.</div>
            </div>

            <div class="col-12">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <div class="col-12" id="usernameDiv">
              <label for="username" class="form-label">Username</label>
              <input type="text" name="username" class="form-control" id="username">
              <div class="invalid-feedback">Please enter a valid username.</div>
            </div>

            <div class="col-12" id="schoolidDiv" style="display: none;">
              <label for="schoolid" class="form-label">School ID</label>
              <input type="text" name="schoolid" class="form-control" id="schoolid" pattern="[A-Za-z0-9\-]+" title="School ID can only contain letters, numbers, and dashes.">
              <div class="invalid-feedback">Please enter a valid school ID (letters, numbers, and dashes only).</div>
            </div>

            <div class="col-12">
              <label for="password" class="form-label">Password</label>
              <input type="password" name="password" class="form-control" id="password" required>
              <div class="invalid-feedback">Please enter a password.</div>
            </div>

            <div class="col-12">
              <label for="repeatPassword" class="form-label">Repeat Password</label>
              <input type="password" name="repeatPassword" class="form-control" id="repeatPassword" required>
              <div class="invalid-feedback">Please repeat your password.</div>
            </div>

            <div class="col-12">
              <button class="btn btn-primary w-100" type="submit" name="register">Register</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Insert Employee-->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="filter">
                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                  <li class="dropdown-header text-start">
                    <h6>Filter</h6>
                  </li>
                  <li><a class="dropdown-item" href="../admin/user-instructor.php">Instructor</a></li>
                  <li><a class="dropdown-item" href="../admin/user-student.php">Student</a></li>
                  <li><a class="dropdown-item" href="../admin/user.php">Admin</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Accounts <span>| Registered</span></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Username</th>
                      <th scope="col">Full Name</th>
                      <th scope="col">Email</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $database = new Connection();
                    $db = $database->open();

                    try {
                      $sql = "SELECT * FROM tbl_users WHERE user_role = 'teacher' ORDER BY user_id ASC";
                      foreach ($db->query($sql) as $row) {
                    ?>
                        <tr>
                          <th scope="row"><a href="#"><?php echo htmlspecialchars($row["user_name"]); ?></a></th>
                          <td><?php echo htmlspecialchars($row["user_fname"]) . ' ' . htmlspecialchars($row["user_lname"]); ?></td>
                          <td><?php echo htmlspecialchars($row["user_email"]); ?></td>
                          <td>
                            <!-- Edit Button -->
                            <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlspecialchars($row['user_id']); ?>"></button>

                            <form method="POST" action="../admin/upload/delete-user.php" style="display:inline;">
                              <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                              <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                            </form>
                          </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?php echo htmlspecialchars($row['user_id']); ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo htmlspecialchars($row['user_id']); ?>" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg">
                              <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="editModalLabel">
                                  Edit Employee Details
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>

                              <div class="modal-body">
                                <div class="card-body p-4">
                                  <form action="functions/update-employee.php" method="post" class="needs-validation" novalidate>
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


                    <?php
                      }
                    } catch (PDOException $e) {
                      echo "Error: " . $e->getMessage();
                    }

                    $database->close();
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

</main><!-- End #main -->

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


<?php include_once "../templates/footer.php"; ?>