<?php include_once "../templates/header.php";?>
<?php include_once '../PHP/user-con.php' ?>
<?php include('modals/register-admin-employee.php'); ?>

<main id="main" class="main">
 
  <div class="pagetitle">
    <h1>Instructor Account Records</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertEmployeeAdmin">
    </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Accounts</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

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

                <table class="table table-striped datatable">
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

                            <form action="student_profile.php" method="post" style="display:inline;">
                                <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                <button type="submit" class="btn btn-sm btn-success" name="submit">
                                    <i class="ri-arrow-right-circle-fill"></i>
                                </button>
                            </form>
                            
                            <form method="POST" action="../admin/upload/delete-user.php" style="display:inline;">
                              <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                              <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                            </form>
                          </td>
                        </tr>
                         <?php include('modals/edit-info-employee.php'); ?>
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

<?php include_once "../templates/footer.php"; ?>