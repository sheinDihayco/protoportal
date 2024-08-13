<?php include_once "../templates/header2.php"; ?>
<?php
// Assuming you have a database connection class
$database = new Connection();
$db = $database->open();

$subjects = []; // Initialize as an empty array

try {
  $sql = "SELECT * FROM tbl_subjects ORDER BY code ASC";
  $subjects = $db->query($sql);
} catch (PDOException $e) {
  echo "There was an error fetching subjects: " . $e->getMessage();
}

$database->close();
?>


<main id="main" class="main">

  <div class="pagetitle">
    <h1> Student Records</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Accounts</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="col-lg-12">
      <div class="row">
        <div class="col-12">
          <div class="card recent-sales overflow-auto">
            <div class="card-body">
              <h5 class="card-title">Students <span>| Enrolled</span></h5>

              <!-- Custom alert for new student creation -->
              <?php
              if (isset($_SESSION['student_created']) && $_SESSION['student_created']) {
                echo "
                        <div class='alert'>
                            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
                            New student successfully created!
                        </div>
                        <script>
                            // Automatically close the alert after 5 seconds
                            setTimeout(function() {
                                document.querySelector('.alert').style.opacity = '0';
                                setTimeout(function() {
                                    document.querySelector('.alert').style.display = 'none';
                                }, 600);
                            }, 5000);
                        </script>";
                unset($_SESSION['student_created']); // Unset session variable to prevent repeated alerts
              }
              ?>
              <table class="table table-borderless datatable">
                <thead>
                  <tr>
                    <th scope="col">User ID</th>
                    <th scope="col">School ID</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $database = new Connection();
                  $db = $database->open();

                  try {
                    $sql = "SELECT s.*, u.studentID
                            FROM tbl_users s
                            JOIN tbl_students u ON s.user_id = u.user_id
                            WHERE s.user_role = 'student'
                            ORDER BY s.user_id ASC";
                    foreach ($db->query($sql) as $row) {
                  ?>
                      <tr>
                        <td>
                          <a href="../admin/payment.php?studentID=<?php echo htmlspecialchars($row['user_id']); ?>">
                            <?php echo htmlspecialchars($row['user_id']); ?>
                          </a>
                        </td>

                        <td><?php echo htmlspecialchars($row['studentID']) . ' ' . htmlspecialchars($row['studentID']); ?></td>

                        <td><?php echo htmlspecialchars($row['user_fname']) . ' ' . htmlspecialchars($row['user_lname']); ?></td>


                        <td>
                          <button type="button" class="btn btn-sm btn-warning ri-add-box-fill" data-bs-toggle="modal" data-bs-target="#insertGrade<?php echo $row["user_id"] ?>"></button>
                          <!-- Form to delete student -->
                          <form method="POST" action="../admin/upload/delete-student.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                            <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                          </form>
                        </td>
                        <?php include('modals/insert-grade.php'); ?>
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


<style>
  .alert {
    padding: 20px;
    background-color: #4CAF50;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
    border-radius: 4px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 1000;
  }

  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover {
    color: black;
  }

  .dropdown-container {
    position: relative;
    width: 100%;
  }

  .select2-container--default .select2-selection--single {
    height: 38px;
    /* Adjust based on your design */
    line-height: 36px;
  }

  .select2-dropdown {
    z-index: 5000;
    /* Ensure dropdown appears above other elements */
  }
</style>