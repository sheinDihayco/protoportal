<?php
include_once "../templates/header.php"; // Corrected PHP include tag
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Payment Records</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Student</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->
  <section class="section dashboard">
    <div class="col-12">
      <div class="card recent-sales overflow-auto">
        <div class="filter">
          <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <li class="dropdown-header text-start">
              <h6>Filter</h6>
            </li>
            <li><a class="dropdown-item" href="#">Today</a></li>
            <li><a class="dropdown-item" href="#">This Month</a></li>
            <li><a class="dropdown-item" href="#">This Year</a></li>
          </ul>
        </div>
        <div class="card-body">
          <h5 class="card-title">Students <span>| Enrolled</span></h5>
          <table class="table table-borderless datatable">
            <thead>
              <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Full Name</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $database = new Connection();
              $db = $database->open();

              try {
                $sql = 'SELECT * FROM tbl_students ORDER BY lname ASC';
                foreach ($db->query($sql) as $row) {
              ?>
                  <tr>
                    <th scope="row"><a href=""><?php echo $row["user_name"] ?></a></th>
                    <td><?php echo $row["lname"] ?>, <?php echo $row["fname"] ?></td>
                    <td>
                      <form action="student_profile.php" method="post">
                        <input type="hidden" name="stud_id" value="<?php echo $row['user_id']; ?>">
                        <button type="submit" class="btn btn-sm btn-success" name="submit"><i class="ri-arrow-right-circle-fill"></i></button>
                      </form>
                    </td>

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
    </div><!-- End Students Enrolled -->


  </section>

</main><!-- End #main -->


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<?php
include_once "../templates/footer.php";
?>