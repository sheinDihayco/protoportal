<?php include_once "../templates/header.php"; ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Subject Records</h1>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#verticalycentered"></button>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Subject</li>
      </ol>
    </nav>
  </div>

  <div class="modal fade" id="verticalycentered" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add Subjects</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="functions/add-subject.php" method="post" class="row g-3 needs-validation" novalidate>

            <div class="col-md-6">
              <label for="course" class="form-label">Course</label>
              <select class="form-select" id="course" name="course" required>
                <option selected disabled value="">Choose...</option>
                <option>11</option>
                <option>12</option>
                <option>BSIT</option>
                <option>BSBA</option>
                <option>BSOA</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid course.
              </div>
            </div>
            <div class="col-md-2">
              <label for="year" class="form-label">Year</label>
              <select class="form-select" id="year" name="year" required>
                <option selected disabled value="">Choose...</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="col-md-2">
              <label for="semester" class="form-label">Semester</label>
              <select class="form-select" id="semester" name="semester" required>
                <option selected disabled value="">Choose...</option>
                <option>1</option>
                <option>2</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="col-md-4">
              <label for="code" class="form-label">Course Code</label>
              <input type="text" class="form-control" id="code" name="code" required>
              <div class="invalid-feedback">
                Please provide a valid Course Code.
              </div>
            </div>
            <div class="col-md-6">
              <label for="description" class="form-label">Description</label>
              <input type="text" class="form-control" id="description" name="description" required>
              <div class="invalid-feedback">
                Please provide a valid description.
              </div>
            </div>

            <div class="col-md-2">
              <label for="lec" class="form-label">Lecture</label>
              <input type="number" class="form-control" id="lec" name="lec" required>
              <div class="invalid-feedback">
                Please provide a valid number.
              </div>
            </div>

            <div class="col-md-2">
              <label for="lab" class="form-label">Laboratory</label>
              <input type="number" class="form-control" id="lab" name="lab" required>
              <div class="invalid-feedback">
                Please provide a valid number.
              </div>
            </div>
            <div class="col-md-2">
              <label for="unit" class="form-label">Units</label>
              <input type="number" class="form-control" id="unit" name="unit" required>
              <div class="invalid-feedback">
                Please provide a valid number.
              </div>
            </div>

            <div class="col-md-4">
              <label for="pre_req" class="form-label">Pre-requisite</label>
              <input type="text" class="form-control" id="pre_req" name="pre_req" required>
              <div class="invalid-feedback">
                Please provide a valid Pre-requisite.
              </div>
            </div>
            <div class="col-md-2">
              <label for="total" class="form-label">Total Hours</label>
              <input type="number" class="form-control" id="total" name="total" required>
              <div class="invalid-feedback">
                Please provide a valid number.
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
  </div>

  <section class="section dashboard">
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
                <li><a class="dropdown-item" href="#">1</a></li>
                <li><a class="dropdown-item" href="#">2</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Course <span>| BSIT </span></h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Semester</th>
                    <th scope="col">Code</th>
                    <th scope="col">Description</th>
                    <th scope="col">Lec</th>
                    <th scope="col">Lab</th>
                    <th scope="col">Units</th>
                    <th scope="col">Pre-requisite</th>
                    <th scope="col">Total Hours</th>
                    <th scope="col">Course</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSIT'";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['semester']); ?></td>
                        <td><?php echo htmlspecialchars($subject['code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['description']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lec']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lab']); ?></td>
                        <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                        <td><?php echo htmlspecialchars($subject['pre_req']); ?></td>
                        <td><?php echo htmlspecialchars($subject['total']); ?></td>
                        <td><?php echo htmlspecialchars($subject['course']); ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
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
                <li><a class="dropdown-item" href="#">1</a></li>
                <li><a class="dropdown-item" href="#">2</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Subject <span>| BSOA </span></h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Semester</th>
                    <th scope="col">Code</th>
                    <th scope="col">Description</th>
                    <th scope="col">Lec</th>
                    <th scope="col">Lab</th>
                    <th scope="col">Units</th>
                    <th scope="col">Pre-requisite</th>
                    <th scope="col">Total Hours</th>
                    <th scope="col">Course</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSOA'";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['semester']); ?></td>
                        <td><?php echo htmlspecialchars($subject['code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['description']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lec']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lab']); ?></td>
                        <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                        <td><?php echo htmlspecialchars($subject['pre_req']); ?></td>
                        <td><?php echo htmlspecialchars($subject['total']); ?></td>
                        <td><?php echo htmlspecialchars($subject['course']); ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
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
                <li><a class="dropdown-item" href="#">1</a></li>
                <li><a class="dropdown-item" href="#">2</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Subject <span>| BSBA </span></h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Semester</th>
                    <th scope="col">Code</th>
                    <th scope="col">Description</th>
                    <th scope="col">Lec</th>
                    <th scope="col">Lab</th>
                    <th scope="col">Units</th>
                    <th scope="col">Pre-requisite</th>
                    <th scope="col">Total Hours</th>
                    <th scope="col">Course</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects  WHERE course = 'BSBA'";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['semester']); ?></td>
                        <td><?php echo htmlspecialchars($subject['code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['description']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lec']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lab']); ?></td>
                        <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                        <td><?php echo htmlspecialchars($subject['pre_req']); ?></td>
                        <td><?php echo htmlspecialchars($subject['total']); ?></td>
                        <td><?php echo htmlspecialchars($subject['course']); ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
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
                <li><a class="dropdown-item" href="#">1</a></li>
                <li><a class="dropdown-item" href="#">2</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Subject <span>| Grade 11 </span></h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Semester</th>
                    <th scope="col">Code</th>
                    <th scope="col">Description</th>
                    <th scope="col">Lec</th>
                    <th scope="col">Lab</th>
                    <th scope="col">Units</th>
                    <th scope="col">Pre-requisite</th>
                    <th scope="col">Total Hours</th>
                    <th scope="col">Course</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects  WHERE course = 'GRADE11'";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['semester']); ?></td>
                        <td><?php echo htmlspecialchars($subject['code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['description']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lec']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lab']); ?></td>
                        <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                        <td><?php echo htmlspecialchars($subject['pre_req']); ?></td>
                        <td><?php echo htmlspecialchars($subject['total']); ?></td>
                        <td><?php echo htmlspecialchars($subject['course']); ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
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
                <li><a class="dropdown-item" href="#">1</a></li>
                <li><a class="dropdown-item" href="#">2</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Subject <span>| Grade 12 </span></h5>

              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">Semester</th>
                    <th scope="col">Code</th>
                    <th scope="col">Description</th>
                    <th scope="col">Lec</th>
                    <th scope="col">Lab</th>
                    <th scope="col">Units</th>
                    <th scope="col">Pre-requisite</th>
                    <th scope="col">Total Hours</th>
                    <th scope="col">Course</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects  WHERE course = 'GRADE12'";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['semester']); ?></td>
                        <td><?php echo htmlspecialchars($subject['code']); ?></td>
                        <td><?php echo htmlspecialchars($subject['description']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lec']); ?></td>
                        <td><?php echo htmlspecialchars($subject['lab']); ?></td>
                        <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                        <td><?php echo htmlspecialchars($subject['pre_req']); ?></td>
                        <td><?php echo htmlspecialchars($subject['total']); ?></td>
                        <td><?php echo htmlspecialchars($subject['course']); ?></td>
                        <td>
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
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