<?php include_once "../templates/header.php" ?>;


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Student Records</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent"></button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Student</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <!--<div class="modal fade" id="insertStudent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Insert Stduent</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

          <form action="../admin/upload/insert-initial-data.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">

            <div class="col-md-6">
              <label for="fname" class="form-label">First name</label>
              <input type="text" class="form-control" id="fname" name="fname" required>
              <div class="invalid-feedback">
                Please provide a valid first name.
              </div>
            </div>
            <div class="col-md-5">
              <label for="lname" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lname" name="lname" required>
              <div class="invalid-feedback">
                Please provide a valid last name.
              </div>
            </div>
            <div class="col-md-1">
              <label for="middleInitial" class="form-label">M.I</label>
              <input type="text" class="form-control" id="middleInitial" name="middleInitial" required>
              <div class="invalid-feedback">
                Please provide a valid last name.
              </div>
            </div>


            <div class="col-md-4">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="studentID" name="studentID" required>
              <div class="invalid-feedback">
                Please provide a valid department.
              </div>
            </div>

            <div class="col-md-6">
              <label for="course" class="form-label">Course</label>
              <input type="text" class="form-control" id="course" name="course" required>
              <div class="invalid-feedback">
                Please provide a valid date.
              </div>
            </div>

            <div class="col-md-2">
              <label for="year" class="form-label">Year</label>
              <input type="text" class="form-control" id="year" name="year" required>
              <div class="invalid-feedback">
                Please provide a valid title.
              </div>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>-->

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
                          <td>
                            <form action="student_profile.php" method="post">
                              <input type="hidden" name="stud_id" value="<?php echo $row['studentID']; ?>">
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
          </div><!-- End Recent Sales -->
        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>


</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>