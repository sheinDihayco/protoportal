<?php include_once "../templates/header.php"; ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Subject Records</h1>
    <!-- <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#verticalycentered"></button>-->
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
                <li><a class="dropdown-item" href="subject.php">1</a></li>
                <li><a class="dropdown-item" href="subject-year-2.php">2</a></li>
                <li><a class="dropdown-item" href="subject-year-3.php">3</a></li>
                <li><a class="dropdown-item" href="subject-year-4.php">4</a></li>
              </ul>
            </div>

            <div class="card-body">
              <h5 class="card-title">Course <span>| BSIT - 2</span></h5>

              <table id="bsit2-table" class="table table-striped datatable">
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
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSIT' AND  year = '2' ";
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
              <button type="button" class="btn btn-sm btn-primary ri-printer-line" onclick="printTableBSIT2();"></button>
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
              <h5 class="card-title">Subject <span>| BSOA - 2 </span></h5>

              <table id="bsoa2-table" class="table table-striped datatable">
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
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSOA' AND year = '2' ";
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
              <button type="button" class="btn btn-sm btn-primary ri-printer-line" onclick="printTableBSOA2();"></button>
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
              <h5 class="card-title">Subject <span>| BSBA - 2 </span></h5>

              <table id="bsba2-table" class="table table-striped datatable">
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
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT * FROM tbl_subjects WHERE course = 'BSBA' AND year = '2' ";
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
              <button type="button" class="btn btn-sm btn-primary ri-printer-line" onclick="printTableBSBA2();"></button>
            </div>

          </div>
        </div>
      </div>
    </div>

  </section>
</main>

<?php include_once "../templates/footer.php"; ?>

<!--BSIT-->
<script>
  function printTableBSIT2() {
    // Open a new window for printing
    var printWindow = window.open('', '', 'height=600,width=800');

    // Select the HUMSS11 table specifically by its ID
    var table = document.querySelector('#bsit2-table');

    // Clone the table
    var tableClone = table.cloneNode(true);

    // Find the index of the "Semester" and "Action" columns
    var headerCells = tableClone.querySelectorAll('thead th');
    var semesterIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim().toLowerCase() === 'semester');
    var actionIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim().toLowerCase() === 'action');

    // Remove "Semester" column header if it exists
    if (semesterIndex !== -1) {
      headerCells[semesterIndex].parentElement.removeChild(headerCells[semesterIndex]);
    }

    // Remove "Action" column header if it exists
    if (actionIndex !== -1) {
      headerCells[actionIndex].parentElement.removeChild(headerCells[actionIndex]);
    }

    // Group rows by semester
    var rows = Array.from(tableClone.querySelectorAll('tbody tr'));
    var semesters = {};

    rows.forEach(function(row) {
      var cells = row.querySelectorAll('td');
      var semester = cells[semesterIndex].textContent.trim();

      // Remove the "Semester" cell from the row
      if (semesterIndex !== -1) {
        cells[semesterIndex].parentElement.removeChild(cells[semesterIndex]);
      }

      // Remove the "Action" cell from the row, if it exists
      if (actionIndex !== -1 && cells[actionIndex]) {
        cells[actionIndex].parentElement.removeChild(cells[actionIndex]);
      }

      // Group rows by semester
      if (!semesters[semester]) {
        semesters[semester] = [];
      }
      semesters[semester].push(row);
    });

    // Create a new document for printing
    var printDocument = printWindow.document;

    printDocument.open();
    printDocument.write('<html><head><title>Prospectus</title>');
    printDocument.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 2px; text-align: center; font-size: 12px; } h4 { text-align: center; margin: 10px 2px 2px 20px; } p { text-align: center; margin: 2px 2px 2px 20px; } h3 { text-align: left; margin-left: 20px; } img { position: absolute; top: 15px; left: 30px; max-width: 10%; }</style>');
    printDocument.write('</head><body>');

    // Add header information similar to the image
    printDocument.write('<img src="../assets/img/miit.png" alt="Logo">');
    printDocument.write('<h4>Microsystems International Institute of Technology, Inc.</h4><p>(Inayagan, City of Naga, Cebu)</p><p>(Tel. NO.: (032) 4273630)</p>');
    printDocument.write('<h4>Bachelor of Science in Information Technology</h4> <p>(CMO 25 S. 2015)</p> <p>(S.Y. 2021-2022)</p>');

    // Iterate over semesters and create a table for each
    Object.keys(semesters).forEach(function(semester) {
      printDocument.write('<h3> BSIT 2 - ' + (semester === '1' ? 'First Semester' : 'Second Semester') + '</h3>');

      // Create a new table for the semester
      var semesterTable = document.createElement('table');
      semesterTable.innerHTML = '<thead>' + tableClone.querySelector('thead').innerHTML + '</thead><tbody></tbody>';
      var semesterTbody = semesterTable.querySelector('tbody');

      semesters[semester].forEach(function(row) {
        semesterTbody.appendChild(row);
      });

      // Append the semester table to the print document
      printDocument.write(semesterTable.outerHTML);
    });

    printDocument.write('</body></html>');
    printDocument.close();
    printWindow.print();
  }
</script>

<!--BSOA-->
<script>
  function printTableBSOA2() {
    // Open a new window for printing
    var printWindow = window.open('', '', 'height=600,width=800');

    // Select the HUMSS11 table specifically by its ID
    var table = document.querySelector('#bsoa2-table');

    // Clone the table
    var tableClone = table.cloneNode(true);

    // Find the index of the "Semester" and "Action" columns
    var headerCells = tableClone.querySelectorAll('thead th');
    var semesterIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim().toLowerCase() === 'semester');
    var actionIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim().toLowerCase() === 'action');

    // Remove "Semester" column header if it exists
    if (semesterIndex !== -1) {
      headerCells[semesterIndex].parentElement.removeChild(headerCells[semesterIndex]);
    }

    // Remove "Action" column header if it exists
    if (actionIndex !== -1) {
      headerCells[actionIndex].parentElement.removeChild(headerCells[actionIndex]);
    }

    // Group rows by semester
    var rows = Array.from(tableClone.querySelectorAll('tbody tr'));
    var semesters = {};

    rows.forEach(function(row) {
      var cells = row.querySelectorAll('td');
      var semester = cells[semesterIndex].textContent.trim();

      // Remove the "Semester" cell from the row
      if (semesterIndex !== -1) {
        cells[semesterIndex].parentElement.removeChild(cells[semesterIndex]);
      }

      // Remove the "Action" cell from the row, if it exists
      if (actionIndex !== -1 && cells[actionIndex]) {
        cells[actionIndex].parentElement.removeChild(cells[actionIndex]);
      }

      // Group rows by semester
      if (!semesters[semester]) {
        semesters[semester] = [];
      }
      semesters[semester].push(row);
    });

    // Create a new document for printing
    var printDocument = printWindow.document;

    printDocument.open();
    printDocument.write('<html><head><title>Prospectus</title>');
    printDocument.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 2px; text-align: center; font-size: 12px; } h4 { text-align: center; margin: 10px 2px 2px 20px; } p { text-align: center; margin: 2px 2px 2px 20px; } h3 { text-align: left; margin-left: 20px; } img { position: absolute; top: 15px; left: 30px; max-width: 10%; }</style>');
    printDocument.write('</head><body>');

    // Add header information similar to the image
    printDocument.write('<img src="../assets/img/miit.png" alt="Logo">');
    printDocument.write('<h4>Microsystems International Institute of Technology, Inc.</h4><p>(Inayagan, City of Naga, Cebu)</p><p>(Tel. NO.: (032) 4273630)</p>');
    printDocument.write('<h4>Bachelor of Science in Office Administration</h4> <p>(CMO 17 S. 2017)</p> <p>(S.Y. 2023-2024)</p>');

    // Iterate over semesters and create a table for each
    Object.keys(semesters).forEach(function(semester) {
      printDocument.write('<h3> BSOA 2 - ' + (semester === '1' ? 'First Semester' : 'Second Semester') + '</h3>');

      // Create a new table for the semester
      var semesterTable = document.createElement('table');
      semesterTable.innerHTML = '<thead>' + tableClone.querySelector('thead').innerHTML + '</thead><tbody></tbody>';
      var semesterTbody = semesterTable.querySelector('tbody');

      semesters[semester].forEach(function(row) {
        semesterTbody.appendChild(row);
      });

      // Append the semester table to the print document
      printDocument.write(semesterTable.outerHTML);
    });

    printDocument.write('</body></html>');
    printDocument.close();
    printWindow.print();
  }
</script>

<!--BSBA-->
<script>
  function printTableBSBA2() {
    // Open a new window for printing
    var printWindow = window.open('', '', 'height=600,width=800');

    // Select the HUMSS11 table specifically by its ID
    var table = document.querySelector('#bsba2-table');

    // Clone the table
    var tableClone = table.cloneNode(true);

    // Find the index of the "Semester" and "Action" columns
    var headerCells = tableClone.querySelectorAll('thead th');
    var semesterIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim().toLowerCase() === 'semester');
    var actionIndex = Array.from(headerCells).findIndex(cell => cell.textContent.trim().toLowerCase() === 'action');

    // Remove "Semester" column header if it exists
    if (semesterIndex !== -1) {
      headerCells[semesterIndex].parentElement.removeChild(headerCells[semesterIndex]);
    }

    // Remove "Action" column header if it exists
    if (actionIndex !== -1) {
      headerCells[actionIndex].parentElement.removeChild(headerCells[actionIndex]);
    }

    // Group rows by semester
    var rows = Array.from(tableClone.querySelectorAll('tbody tr'));
    var semesters = {};

    rows.forEach(function(row) {
      var cells = row.querySelectorAll('td');
      var semester = cells[semesterIndex].textContent.trim();

      // Remove the "Semester" cell from the row
      if (semesterIndex !== -1) {
        cells[semesterIndex].parentElement.removeChild(cells[semesterIndex]);
      }

      // Remove the "Action" cell from the row, if it exists
      if (actionIndex !== -1 && cells[actionIndex]) {
        cells[actionIndex].parentElement.removeChild(cells[actionIndex]);
      }

      // Group rows by semester
      if (!semesters[semester]) {
        semesters[semester] = [];
      }
      semesters[semester].push(row);
    });

    // Create a new document for printing
    var printDocument = printWindow.document;

    printDocument.open();
    printDocument.write('<html><head><title>Prospectus</title>');
    printDocument.write('<style>table { width: 100%; border-collapse: collapse; } th, td { border: 1px solid black; padding: 2px; text-align: center; font-size: 12px; } h4 { text-align: center; margin: 10px 2px 2px 20px; } p { text-align: center; margin: 2px 2px 2px 20px; } h3 { text-align: left; margin-left: 20px; } img { position: absolute; top: 15px; left: 30px; max-width: 10%; }</style>');
    printDocument.write('</head><body>');

    // Add header information similar to the image
    printDocument.write('<img src="../assets/img/miit.png" alt="Logo">');
    printDocument.write('<h4>Microsystems International Institute of Technology, Inc.</h4><p>(Inayagan, City of Naga, Cebu)</p><p>(Tel. NO.: (032) 4273630)</p>');
    printDocument.write('<h4>Bachelor of Science in Business Administration</h4> <p>(CMO 17 S. 2017)</p> <p>(S.Y. 2021-2022)</p>');

    // Iterate over semesters and create a table for each
    Object.keys(semesters).forEach(function(semester) {
      printDocument.write('<h3> BSBA 2 - ' + (semester === '1' ? 'First Semester' : 'Second Semester') + '</h3>');

      // Create a new table for the semester
      var semesterTable = document.createElement('table');
      semesterTable.innerHTML = '<thead>' + tableClone.querySelector('thead').innerHTML + '</thead><tbody></tbody>';
      var semesterTbody = semesterTable.querySelector('tbody');

      semesters[semester].forEach(function(row) {
        semesterTbody.appendChild(row);
      });

      // Append the semester table to the print document
      printDocument.write(semesterTable.outerHTML);
    });

    printDocument.write('</body></html>');
    printDocument.close();
    printWindow.print();
  }
</script>