<?php include_once "../templates/header.php" ?>;


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
                <li><a class="dropdown-item" href="#">BSIT</a></li>
                <li><a class="dropdown-item" href="#">BSBA</a></li>
                <li><a class=" dropdown-item" href="#">BSOA</a></li>
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
                        <td><?php echo $row["user_email"] ?></td>
                        <td><?php echo $row["user_name"] ?></td>
                        <td><?php echo $row["user_role"] ?></td>
                        <td>
                          <button type="button" class=" btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $row["user_id"] ?>"></button>

                          <form method="POST" action="../admin/upload/delete-user.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                            <button type="submit" class=" btn btn-sm btn-danger ri-delete-bin-6-line"></button>
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