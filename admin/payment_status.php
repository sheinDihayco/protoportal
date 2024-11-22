<?php include_once "../templates/header.php"; ?>
<?php include_once '../PHP/student-profile-con.php' ?>
<?php include_once '../PHP/user-student-con.php' ?>
<?php include('modals/add-payment-status.php'); ?>


<!-- Start #main -->
<main id="main" class="main">
  <div class="pagetitle">
      <h1>Student Information</h1>
      <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertPayment">
      </button>
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Accounts</li>
          </ol>
      </nav>
  </div><!-- End Page Title -->

  <!-- Start Section -->
  <section class="section profile">
    <div class="row">
     <div class="col-xl-4">
      <div class="card">
        <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
            <a class="nav-link nav-profile" href="#" data-bs-toggle="dropdown">
                <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="custom-profile-img">
            </a><!-- End Profile Iamge Icon -->

          <h2><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?> <span><?php echo htmlspecialchars($studs["middleInitial"]); ?></span></h2>
          <h3><?php echo htmlspecialchars($studs["course"]); ?> - <?php echo htmlspecialchars($studs["year"]); ?></h3>
          <div class="social-links mt-2">
            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-8">
      
        <!-- Recent Sales -->
        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <button type="button" class="icon-button">
                <a href="../admin/user-student.php" class="icon-link">
                  <i class="ri-arrow-go-back-line"></i>
                </a>
              </button>

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment-status">Payment Status</button>
              </li>
            </ul>
            <!-- End Bordered Tabs -->

            <div class="tab-content pt-2">
              <!--Start Payment Overview-->
                <div class="tab-pane fade show active" id="payment-status">
                  <div class="card-body">
                    <h5 class="card-title">Payment Details</h5>
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Student ID</th>
                          <th scope="col">Semester</th>
                          <th scope="col">Payment Period</th>
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

                        $sql = 'SELECT s.*, p.*
                                FROM tbl_students s 
                                LEFT JOIN tbl_payments p ON s.user_id = p.user_id
                                WHERE s.user_id = ?';

                        if ($stmt = $conn->prepare($sql)) {
                          $stmt->bind_param("s", $studid);
                          $stmt->execute();
                          $result = $stmt->get_result();

                          while ($row = $result->fetch_assoc()) {
                            // Determine the badge class based on payment status
                            $payment_status = htmlspecialchars($row["payment_status"]);
                            $badge_class = '';

                            if ($payment_status === 'PENDING') {
                              $badge_class = 'badge-warning'; // Orange for Pending
                            } elseif ($payment_status === 'PAID') {
                              $badge_class = 'badge-success'; // Green for Paid
                            } elseif ($payment_status === 'OVERDUE') {
                              $badge_class = 'badge-danger'; // Red for Overdue
                            } else {
                              $badge_class = 'badge-secondary'; // Default gray for others
                            }
                        ?>
                            <tr>
                              <th scope="row"><a href=""><?php echo htmlspecialchars($row["user_name"]); ?></a></th>
                              <td><?php echo htmlspecialchars($row["semester"]) ? htmlspecialchars($row["semester"]) : 'Choose semester'; ?></td>
                              <td><?php echo htmlspecialchars($row["paymentPeriod"]) ? htmlspecialchars($row["paymentPeriod"]) : 'Choose payment period'; ?></td>
                              <td><span class="badge <?php echo $badge_class; ?>"><?php echo $payment_status ? $payment_status : 'Not Available'; ?></span></td>
                              <td>
                                <div style="display: inline;">
                                  <!-- Edit Button -->
                                  <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill"
                                    data-bs-toggle="modal" data-bs-target="#updatePaymentStatus<?php echo $row['payment_id']; ?>"></button>

                                  <!-- Space Between Buttons -->
                                  <div style="display: inline-block;"></div>

                                  <!-- Example PHP code to include user_id -->
                                  <?php
                                  // Assuming $row['user_id'] contains the user ID
                                  $user_id = htmlspecialchars($row['user_id']);
                                  $payment_id = htmlspecialchars($row['payment_id']);
                                  ?>

                                  <!-- Delete Button with SweetAlert Confirmation -->
                                  <form id="deleteForm<?php echo $payment_id; ?>" method="POST" action="../admin/upload/delete-payment.php" style="display: inline;">
                                    <input type="hidden" name="payment_id" value="<?php echo $payment_id; ?>">
                                    <input type="hidden" id="user_id<?php echo $payment_id; ?>" value="<?php echo $user_id; ?>">
                                    <button type="button" class="btn btn-sm btn-danger ri-delete-bin-6-line"
                                      onclick="confirmDelete(<?php echo $payment_id; ?>, '<?php echo $user_id; ?>')"></button>
                                  </form>
                                </div>

                                <?php include('modals/update-payment-form.php'); ?>
                              </td>
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
              <!--End Payment Overview-->
            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>
  <!-- Start Section -->

</main>
<style>
  .custom-profile-img {
    width: 100px; /* Set the desired width */
    height: 100px; /* Set the desired height */
    border-radius: 50%; /* Make it circular */
    border: 3px solid blue; 
    object-fit: cover; /* Ensure the image covers the entire area */
  }
</style>

<?php include_once "../templates/footer.php"; ?>