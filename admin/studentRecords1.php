<?php include_once "../templates/header.php"; ?>
<main id="main" class="main">

  <div class="pagetitle">
    <h1>Student Records</h1>
    <a href="../admin/register.php">
      <button type="button" class="tablebutton"><i class="ri-user-add-fill"></i></button>
    </a>

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Student</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="card-body">
              <h5 class="card-title">Students <span>| Enrolled</span></h5>

              <!-- Custom alert for new student creation -->
              <?php
              if (isset($_SESSION['student_created']) && $_SESSION['student_created']) {
                echo "
                  <div class='alert'>
                      <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
                      New student successfully created!
                  </div>
                  <script>
                      // Automatically close the alert after 5 seconds
                      setTimeout(function() {
                          document.querySelector('.alert').style.opacity = '0';
                          setTimeout(function() {
                              document.querySelector('.alert').style.display = 'none';
                          }, 600);
                      }, 5000);
                  </script>";
                unset($_SESSION['student_created']); // Unset session variable to prevent repeated alerts
              }
              ?>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Username</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">User ID</th>
                    <th scope="col">Role</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_users WHERE user_role = 'student' ORDER BY user_id ASC";
                    foreach ($db->query($sql) as $row) {
                  ?>
                      <tr>
                        <th scope="row"><a href="../admin/payment.php"><?php echo $row["user_name"] ?></a></th>
                        <td><?php echo $row["user_fname"] ?>, <?php echo $row["user_lname"] ?></td>
                        <td><?php echo $row["user_email"] ?></td>
                        <td><?php echo $row["user_id"] ?></td>
                        <td><?php echo $row["user_role"] ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $row["user_id"] ?>"></button>

                          <form method="POST" action="../admin/upload/delete-student.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
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
        </div>
      </div>
    </div>
  </section>
</main>

<?php include_once "../templates/footer.php"; ?>


<style>
  .alert {
    padding: 20px;
    background-color: #4CAF50;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
    border-radius: 4px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
  }

  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover {
    color: black;
  }
</style>