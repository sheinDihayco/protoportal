<?php include_once "../templates/header.php" ?>;


<main id="main" class="main">
  <div class="pagetitle">
    <h1>Student Records</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
    </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Student</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <div class="modal fade" id="insertStudent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Register Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="includes/register.inc2.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
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
        </div>
        </form>
      </div>
    </div>
  </div>

  <section class="section dashboard">
    <!-- Left side columns -->
    <div class="col-lg-12">
      <div class="row">
        <!-- Recent Sales -->
        <div class="col-12">
          <div class="card recent-sales overflow-auto">

            <div class="filter">
              <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
              <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <li class="dropdown-header text-start">
                  <h6>Filter</h6>
                </li>
                <li><a class="dropdown-item" href="../admin/bsit.php">BSIT</a></li>
                <li><a class="dropdown-item" href="../admin/bsba.php">BSBA</a></li>
                <li><a class=" dropdown-item" href="../admin/bsoa.php">BSOA</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Students <span>| Enrolled</span></h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_users WHERE user_role = 'student'
                            ORDER BY user_id ASC";
                    foreach ($db->query($sql) as $row) {
                  ?>
                      <tr>
                        <th scope="row"><a href="#"><?php echo $row["user_id"] ?></a></th>
                        <td><?php echo $row["user_fname"] ?>, <?php echo $row["user_lname"] ?></td>
                        <td><?php echo $row["user_email"] ?>
                        <td><?php echo $row["user_name"] ?></td>
                        <td><?php echo $row["user_role"] ?></td>
                        <td>
                          <button type="button" class="ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $row["user_id"] ?>"></button>
                          <form method="POST" action="../admin/upload/delete-user.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                            <button type="submit" class="ri-delete-bin-6-line"></button>
                          </form>
                        </td>
                        <?php include('modals/form-edit-Student.php'); ?>
                      </tr>
                  <?php
                    }
                  } catch (PDOException $e) {
                    echo "There is some problem in connection: " . $e->getMessage();
                  }
                  $database->close();
                  ?>
                </tbody>
              </table>
            </div>

          </div>
        </div><!-- End Recent Sales -->
      </div>
    </div><!-- End Left side columns -->
  </section>


</main><!-- End #main -->

<!-- Template Main JS File -->

<?php
include_once "../templates/footer.php";
?>