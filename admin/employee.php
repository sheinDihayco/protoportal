<?php include_once "../templates/header.php"; ?>


<main id="main" class="main">

  <div class="pagetitle">
    <h1>Employee</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#verticalycentered">
    </button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Employee</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <div class="modal fade" id="verticalycentered" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Employee</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="functions/add-employee.php" method="post" class="row g-3 needs-validation" novalidate>
            <div class="col-md-6">
              <label for="validationCustom01" class="form-label">First name</label>
              <input type="text" class="form-control" id="validationCustom01" name="fname" required>
              <div class="invalid-feedback">
                Please provide a valid first name.
              </div>
            </div>
            <div class="col-md-6">
              <label for="validationCustom02" class="form-label">Last name</label>
              <input type="text" class="form-control" id="validationCustom02" name="lname" required>
              <div class="invalid-feedback">
                Please provide a valid last name.
              </div>
            </div>

            <div class="col-md-4">
              <label for="validationCustom03" class="form-label">Birth Date</label>
              <input type="date" class="form-control" id="validationCustom03" name="bdate" required>
              <div class="invalid-feedback">
                Please provide a valid birth date.
              </div>
            </div>
            <div class="col-md-4">
              <label for="validationCustom04" class="form-label">Gender</label>
              <select class="form-select" id="validationCustom04" name="gend" required>
                <option selected disabled value="">Choose...</option>
                <option>Male</option>
                <option>Female</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid gender.
              </div>
            </div>
            <div class="col-md-4">
              <label for="validationCustom05" class="form-label">Date Hired</label>
              <input type="date" class="form-control" id="validationCustom05" name="dhire" required>
              <div class="invalid-feedback">
                Please provide a valid date.
              </div>
            </div>
            <div class="col-md-6">
              <label for="validationCustom06" class="form-label">Job Title</label>
              <input type="text" class="form-control" id="validationCustom06" name="title" required>
              <div class="invalid-feedback">
                Please provide a valid title.
              </div>
            </div>
            <div class="col-md-6">
              <label for="validationCustom07" class="form-label">Department</label>
              <input type="text" class="form-control" id="validationCustom07" name="dept" required>
              <div class="invalid-feedback">
                Please provide a valid department.
              </div>
            </div>

            <div class="col-md-6">
              <label for="validationCustom09" class="form-label">Contact Number</label>
              <input type="text" class="form-control" id="validationCustom09" name="cnum" required>
              <div class="invalid-feedback">
                Please provide a valid number.
              </div>
            </div>

            <div class="col-md-12">
              <label for="validationCustom10" class="form-label">Address</label>
              <input type="text" class="form-control" id="validationCustom10" name="add" required>
              <div class="invalid-feedback">
                Please provide a valid address.
              </div>
            </div>
            <!-- <div class="col-12">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">
                      Agree to terms and conditions
                    </label>
                    <div class="invalid-feedback">
                      You must agree before submitting.
                    </div>
                  </div>
                </div> -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Sales Card -->
          <!-- <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

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
                  <h5 class="card-title">Total <span>| Students</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6><?php echo $st_count["num"] ?></h6>
                      <span class="text-success small pt-1 fw-bold">Student</span> <span class="text-muted small pt-2 ps-1">Count</span>

                    </div>
                  </div>
                </div>

              </div>
            </div>
             -->
          <!-- End Sales Card -->

          <!-- Revenue Card -->
          <!-- <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

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
                  <h5 class="card-title">Revenue <span>| This Month</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-currency-dollar"></i>
                    </div>
                    <div class="ps-3">
                      <h6>$3,264</h6>
                      <span class="text-success small pt-1 fw-bold">8%</span> <span class="text-muted small pt-2 ps-1">increase</span>

                    </div>
                  </div>
                </div>

              </div>
            </div> -->

          <!-- End Revenue Card -->

          <!-- Customers Card -->
          <!-- <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

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
                  <h5 class="card-title">Customers <span>| This Year</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>1244</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div> -->
          <!-- End Customers Card -->

          <!-- Recent Sales -->
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
                <h5 class="card-title">Recent Sales <span>| Today</span></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Employee ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Job Title</th>
                      <th scope="col">Contact</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $database = new Connection();
                    $db = $database->open();

                    try {
                      $sql = 'SELECT * FROM tbl_employee
                          ORDER BY tbl_employee.last_name ASC';
                      foreach ($db->query($sql) as $row) {
                    ?>
                        <tr>
                          <th scope="row"><a href="#"><?php echo $row["employee_id"] ?></a></th>
                          <td><?php echo $row["last_name"] ?>, <?php echo $row["first_name"] ?></td>
                          <td><a href="#" class="text-primary"><?php echo $row["job_title"] ?></a></td>
                          <td><?php echo $row["phone_number"] ?></td>
                          <td> <button type="button" class=" btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row["employee_id"] ?>"></button></td>
                          <?php include('modals/edit-employee.php'); ?>
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