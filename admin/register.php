<?php include_once "../templates/header.php" ?>;


<body>
  <main id="main" class="main">


    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-6 d-flex flex-column align-items-center justify-content-center">


            <div class="card mb-5">
              <div class="card-body">
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Register Your Account</h5>
                </div>

                <form class="row g-3 needs-validation" action="includes/register.inc.php" method="post" novalidate>
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
                  <div class="col-12">
                    <p class="small mb-0">Already have an account? <a href="login.php">Login here</a></p>
                  </div>
                </form>

              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>
  <script>
    document.getElementById('role').addEventListener('change', function() {
      var role = this.value;
      if (role === 'student') {
        document.getElementById('usernameDiv').style.display = 'none';
        document.getElementById('schoolidDiv').style.display = 'block';
      } else {
        document.getElementById('usernameDiv').style.display = 'block';
        document.getElementById('schoolidDiv').style.display = 'none';
      }
    });
  </script>
</body>

</html>