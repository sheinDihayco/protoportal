<?php include_once "../templates/header.php" ?>;


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Student Records</h1>
    </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Student</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <section class="section dashboard">
    <div class="row">
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
                  <li><a class="dropdown-item" href="../admin/bsit-payment.php">BSIT</a></li>
                  <li><a class="dropdown-item" href="../admin/bsba-payment.php">BSBA</a></li>
                  <li><a class="dropdown-item" href="../admin/bsoa-payment.php">BSOA</a></li>
                </ul>
              </div>

              <div class="card-body">
                <h5 class="card-title">Students <span>| Enrolled</span></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Student ID</th>
                      <th scope="col">Full Name</th>
                      <th scope="col">Course</th>
                      <th scope="col">Contact</th>
                      <th scope="col">Status</th>
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
                          <th scope="row"><a href="#"><?php echo $row["studentID"] ?></a></th>
                          <td><?php echo $row["lname"] ?>, <?php echo $row["fname"] ?></td>
                          <td><?php echo $row["course"] ?> - <?php echo $row["year"] ?></td>
                          <td><?php echo $row["contact"] ?></td>
                          <td>
                            <form action="stud_profile.php" method="post">
                              <input type="hidden" name="stud_id" value="<?php echo $row['studentID']; ?>">
                              <button type="submit" class="" name="submit"><i class="ri-arrow-right-circle-fill"></i></button>
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
          </div><!-- End Recent Sales -->
        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>


</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>