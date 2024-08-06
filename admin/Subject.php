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
                <option>BSIT-SUMMER</option>

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
                <option>0</option>
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Course <span>| BSIT - 1 </span></h5>

              <table class="table table-striped datatable">
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSIT' AND year = '1' ";
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
              <button type="button" class="btn btn-sm btn-primary ri-printer-line" onclick="printTable();"></button>
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
              <h5 class="card-title">Subject <span>| BSOA - 1</span></h5>

              <table class="table table-striped datatable">
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSOA' AND year = '1' ";
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
              <button type="button" class="btn btn-sm btn-primary ri-printer-line" onclick="printTableBSOA();"></button>
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
              <h5 class="card-title">Subject <span>| BSBA - 1 </span></h5>

              <table class="table table-striped datatable">
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
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '1' ";
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Subject <span>| Grade 11 </span></h5>

              <table class="table table-striped datatable">
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Subject <span>| Grade 12 </span></h5>

              <table class="table table-striped datatable">
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

<script>
  function printTable() {
    // Open a new window for printing
    var printWindow = window.open('', '', 'height=600,width=800');
    var table = document.querySelector('.datatable'); // Select the table

    // Clone the table
    var tableClone = table.cloneNode(true);

    // Remove action column header and cells
    var headerCells = tableClone.querySelectorAll('thead th');
    var actionIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim() === 'Action');
    var actionCourse = Array.from(headerCells).findIndex(cell => cell.textContent.trim() === 'Course');

    if (actionIndex !== -1) {
      // Remove action column header
      headerCells[actionIndex].parentElement.removeChild(headerCells[actionIndex]);

      // Remove action column cells from each row
      var rows = tableClone.querySelectorAll('tbody tr');
      rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if (cells.length > actionIndex) {
          cells[actionIndex].parentElement.removeChild(cells[actionIndex]);
        }
      });
    }
    if (actionCourse !== -1) {
      // Remove action column header
      headerCells[actionCourse].parentElement.removeChild(headerCells[actionCourse]);

      // Remove action column cells from each row
      var rows = tableClone.querySelectorAll('tbody tr');
      rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if (cells.length > actionCourse) {
          cells[actionCourse].parentElement.removeChild(cells[actionCourse]);
        }
      });
    }

    // Create a new document for printing
    var printDocument = printWindow.document;

    printDocument.open();
    printDocument.write('<html><head><title>Prospectus</title>');
    printDocument.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 2px; text-align: center; } h4 { text-align: center; margin: 10px 2px 2px 20px } p { text-align: center; margin: 2px 2px 2px 20px } h3 { text-align: left; } img { position: absolute; top: 15px; left: 30px; max-width: 10%; }</style>');


    printDocument.write('</head><body>');
    printDocument.write('<img src="../assets/img/miit.png" alt="Logo">');
    printDocument.write('<h4>Microsystems International Institute of Technology, Inc.</h4> <p>(Inayagan, City of Naga, Cebu )</p> <p>(Tel. NO.: (032) 4273630</p>');

    printDocument.write('<h4>Bachelor of Science in Information Technology</h4> <p>(CMO 25 S. 2015)</p> <p>(S.Y. 2021-2022)</p>');

    // Group by semester
    var tbody = tableClone.querySelector('tbody');
    var rows = Array.from(tbody.querySelectorAll('tr'));
    var semesters = new Set(rows.map(row => row.children[0].textContent.trim())); // Assuming semester is in the first column

    semesters.forEach(function(semester) {
      printDocument.write('<h3>Semester: ' + semester + '</h3> <h3> First Year </h3>');

      var semesterTable = document.createElement('table');
      semesterTable.innerHTML = '<thead>' + tableClone.querySelector('thead').innerHTML + '</thead><tbody></tbody>';
      var semesterTbody = semesterTable.querySelector('tbody');

      rows.forEach(function(row) {
        if (row.children[0].textContent.trim() === semester) {
          semesterTbody.appendChild(row.cloneNode(true));
        }
      });

      printDocument.write(semesterTable.outerHTML);
    });

    printDocument.write('</body></html>');
    printDocument.close();
    printWindow.print();
  }
</script>

<script>
  function printTableBSOA() {
    // Open a new window for printing
    var printWindow = window.open('', '', 'height=600,width=800');
    var table = document.querySelector('.datatable'); // Select the table

    // Clone the table
    var tableClone = table.cloneNode(true);

    // Remove action column header and cells
    var headerCells = tableClone.querySelectorAll('thead th');
    var actionIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim() === 'Action');
    var actionCourse = Array.from(headerCells).findIndex(cell => cell.textContent.trim() === 'Course');

    if (actionIndex !== -1) {
      // Remove action column header
      headerCells[actionIndex].parentElement.removeChild(headerCells[actionIndex]);

      // Remove action column cells from each row
      var rows = tableClone.querySelectorAll('tbody tr');
      rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if (cells.length > actionIndex) {
          cells[actionIndex].parentElement.removeChild(cells[actionIndex]);
        }
      });
    }
    if (actionCourse !== -1) {
      // Remove action column header
      headerCells[actionCourse].parentElement.removeChild(headerCells[actionCourse]);

      // Remove action column cells from each row
      var rows = tableClone.querySelectorAll('tbody tr');
      rows.forEach(function(row) {
        var cells = row.querySelectorAll('td');
        if (cells.length > actionCourse) {
          cells[actionCourse].parentElement.removeChild(cells[actionCourse]);
        }
      });
    }

    // Create a new document for printing
    var printDocument = printWindow.document;

    printDocument.open();
    printDocument.write('<html><head><title>Prospectus</title>');
    printDocument.write('<style>');
    printDocument.write('table { width: 100%; border-collapse: collapse; }');
    printDocument.write('th, td { border: 1px solid black; padding: 2px; text-align: center; }');
    printDocument.write('h4 { text-align: center; margin: 10px 2px 2px 20px; }');
    printDocument.write('p { text-align: center; margin: 2px 2px 2px 20px; }');
    printDocument.write('h3 { text-align: left; }');
    printDocument.write('img { position: absolute; top: 15px; left: 30px; max-width: 10%; }');
    printDocument.write('</style>');
    printDocument.write('</head><body>');

    // Add the image at the top-left corner
    printDocument.write('<img src="../assets/img/miit.png" alt="Logo">');

    // Add institution and document title
    printDocument.write('<h4>Microsystems International Institute of Technology, Inc.</h4>');
    printDocument.write('<p>(Inayagan, City of Naga, Cebu)</p>');
    printDocument.write('<p>(Tel. NO.: (032) 4273630)</p>');
    printDocument.write('<h4>Bachelor of Science in Office Administration</h4>');
    printDocument.write('<p>(CMO 17 S. 2017)</p>');
    printDocument.write('<p>(S.Y. 2023-2024)</p>');

    // Group by semester
    var tbody = tableClone.querySelector('tbody');
    var rows = Array.from(tbody.querySelectorAll('tr'));
    var semesters = new Set(rows.map(row => row.children[0].textContent.trim())); // Assuming semester is in the first column

    semesters.forEach(function(semester) {
      printDocument.write('<h3>Semester: ' + semester + '</h3> <h3>First Year</h3>');

      var semesterTable = document.createElement('table');
      semesterTable.innerHTML = '<thead>' + tableClone.querySelector('thead').innerHTML + '</thead><tbody></tbody>';
      var semesterTbody = semesterTable.querySelector('tbody');

      rows.forEach(function(row) {
        if (row.children[0].textContent.trim() === semester) {
          semesterTbody.appendChild(row.cloneNode(true));
        }
      });

      printDocument.write(semesterTable.outerHTML);
    });

    printDocument.write('</body></html>');
    printDocument.close();
    printWindow.print();
  }
</script>
<button type="button" class="btn btn-sm btn-primary ri-printer-line" onclick="printTableBSOA();">Print</button>