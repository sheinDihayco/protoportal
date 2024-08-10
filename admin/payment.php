<?php
include_once "../templates/header.php"; // Corrected PHP include tag
?>
<?php

if (isset($_SESSION['initial_update']) && $_SESSION['initial_update']) {
  echo "
        <div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
            Record successfully updated!
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.alert').style.opacity = '0';
                setTimeout(function() {
                    document.querySelector('.alert').style.display = 'none';
                }, 600);
            }, 5000);
        </script>";
  unset($_SESSION['initial_update']);
}

if (isset($_SESSION['initial_update_error'])) {
  echo "
        <div class='alert' style='background-color: #f44336;'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
            " . $_SESSION['initial_update_error'] . "
        </div>
        <script>
            setTimeout(function() {
                document.querySelector('.alert').style.opacity = '0';
                setTimeout(function() {
                    document.querySelector('.alert').style.display = 'none';
                }, 600);
            }, 5000);
        </script>";
  unset($_SESSION['initial_update_error']);
}
?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Payment Records</h1>
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
                          <th scope="row"><a href="student_profile.php?studentID=<?php echo htmlspecialchars($studs["studentID"]); ?>"><?php echo htmlspecialchars($row["studentID"]); ?></a></th>
                          <td><?php echo htmlspecialchars($row["lname"]) . ", " . htmlspecialchars($row["fname"]); ?></td>
                          <td><?php echo htmlspecialchars($row["course"]) . " - " . htmlspecialchars($row["year"]); ?></td>
                          <td>
                            <form action="student_profile.php" method="post">
                              <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['studentID']); ?>">
                              <button type="submit" class="btn btn-sm btn-success" name="submit"><i class="ri-arrow-right-circle-fill"></i></button>
                            </form>
                          </td>
                        </tr>
                    <?php
                      }
                    } catch (PDOException $e) {
                      echo "There is some problem in connection: " . htmlspecialchars($e->getMessage());
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

<style>
  .alert {
    padding: 20px;
    background-color: #4CAF50;
    /* Green background for success */
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

  .alert.error {
    background-color: #f44336;
    /* Red background for errors */
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
</style>