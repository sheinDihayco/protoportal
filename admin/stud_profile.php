<?php
if (isset($_POST['stud_id']) && !empty($_POST['stud_id'])) {
  $_SESSION['stud'] = $_POST['stud_id'];
}

if (isset($_SESSION['stud']) && !empty($_SESSION['stud'])) {
  $studid = $_SESSION['stud'];
} else {
  exit('No student ID provided');
}

include_once "../templates/header.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';

try {
  $statement = $conn->prepare("
        SELECT s.fname, s.lname, s.course, s.year, sr.major, s.contact, sr.email, sr.cityAdd, sr.curAddress
        FROM tbl_students s
        INNER JOIN tbl_students sr ON s.studentID = sr.studentID
        WHERE s.studentID = :sid
    ");

  $statement->bindParam(':sid', $studid, PDO::PARAM_INT);
  $statement->execute();
  $studs = $statement->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo 'Query failed: ' . $e->getMessage();
}
?>

<main id="main" class="main">

  <div class="pagetitle">
    <?php if ($studs) : ?>
      <h1><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?></h1>
      <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
      </button>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><?php echo htmlspecialchars($studs["course"]); ?></li>
        </ol>
      </nav>
    <?php else : ?>
      <h1>No ID Found</h1>
    <?php endif; ?>
  </div><!-- End Page Title -->

  <div class="modal fade" id="insertStudent" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Insert Payment Status</h5>
        </div>
        <div class="modal-body">
          <form action="../admin/upload/insert-payment-status.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
            <div class="col-md-6">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="number" class="form-control" id="studentID" name="studentID" value="<?php echo htmlspecialchars($studid); ?>" required readonly>
              <div class="invalid-feedback">
                Please enter a valid student ID.
              </div>
            </div>
            <div class="col-md-6">
              <label for="payment_status" class="form-label">Status</label>
              <select class="form-select" id="payment_status" name="payment_status" required>
                <option value="">Choose...</option>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Overdue">Overdue</option>
              </select>
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

  <section class="section profile">
    <div class="col-lg-12">
      <div class="row">
        <!-- Recent Sales -->
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment-status">Payment Status</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
              </li>
            </ul>
            <!-- End Bordered Tabs -->

            <div class="tab-content pt-2">
              <div class="tab-pane fade show active" id="payment-status">
                <div class="card-body">
                  <h5 class="card-title">Students <span>| Enrolled</span></h5>

                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th scope="col">Student ID</th>
                        <th scope="col">Payment Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $servername = "localhost";
                      $username = "root";
                      $password = "";
                      $dbname = "schooldb";

                      // Create connection
                      $conn = new mysqli($servername, $username, $password, $dbname);

                      // Check connection
                      if ($conn->connect_error) {
                        die("Connection failed: " . $conn->connect_error);
                      }

                      // Query to fetch students with their payment status for the selected studentID
                      $sql = 'SELECT s.studentID, p.payment_status
                          FROM tbl_students s 
                          LEFT JOIN tbl_payments p ON s.studentID = p.studentID
                          WHERE s.studentID = ?';

                      if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("s", $studid);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                      ?>
                          <tr>
                            <th scope="row"><a href=""><?php echo htmlspecialchars($row["studentID"]); ?></a></th>
                            <td><?php echo htmlspecialchars($row["payment_status"]) ? htmlspecialchars($row["payment_status"]) : 'Not Available'; ?></td>
                            <td><button type="button" class="ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#updatePaymentStatus<?php echo $row["studentID"]; ?>"></button></td>
                            <?php include('modals/update-payment-form.php'); ?>
                          </tr>
                      <?php
                        }

                        $stmt->close();
                      } else {
                        echo "Error preparing statement: " . $conn->error;
                      }

                      $conn->close();
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="profile-overview">
                <h5 class="card-title">Student Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Full Name <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["fname"]); ?> <?php echo htmlspecialchars($studs["lname"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Course <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["course"]); ?> - <?php echo htmlspecialchars($studs["year"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Major <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["major"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["curAddress"]); ?> <?php echo htmlspecialchars($studs["cityAdd"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["contact"]); ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Email <span> : </span></div>
                  <div class="col-lg-9 col-md-8"><?php echo htmlspecialchars($studs["email"]); ?></div>
                </div>
              </div>
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div><!-- End Left side columns -->
    </div>
    </div>
  </section>

</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>