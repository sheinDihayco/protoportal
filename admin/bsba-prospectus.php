<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/BSBA-con.php"; ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>BACHELOR OF SCIENCE IN BUSINESS ADMINISTRATION (BSBA)</h1>
    <p>(CMO no. 17 S. 2017)</p>
    <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#verticalycentered"></button>
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Course <span>| BSBA - 1 </span></h5>

              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '1' AND semester = '1' ";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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

            <div class="card-body">

              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '1'AND semester = '2' ";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Course <span>| BSBA - 2 </span></h5>

              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '2' AND semester ='1' ";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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
            <div class="card-body">
              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '2' AND semester ='2' ";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Course <span>| BSBA - 3 </span></h5>

              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '3' AND semester ='1' ";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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
            <div class="card-body">

              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '3' AND semester = '2' ";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Course <span>| BSBA - 4 </span></h5>

              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '4' AND semester = '1'";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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

            <div class="card-body">

              <table class="table table-striped datatable">
                <thead>
                  <tr>
                    <th scope="col">Year</th>
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '4' AND semester = '2' ";
                    foreach ($db->query($sql) as $subject) {
                  ?>
                      <tr>
                        <td><?php echo htmlspecialchars($subject['year']); ?></td>
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
                          <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editSubject<?php echo $subject['id']; ?>"></button>
                          <form method="POST" action="../admin/upload/delete_subject.php" onsubmit="return confirm('Are you sure you want to delete this subject?');" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($subject['id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>

                        </td>
                        <?php include('modals/form-edit-subjects.php'); ?>
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