<?php
include_once "../templates/header.php";
include_once "includes/connect.php";
include_once 'includes/connection.php'; // Assuming this is where $conn is defined

// Prepare and execute SQL queries to count employees and students
$statements = $conn->prepare("SELECT COUNT(user_id) AS count_emp FROM tbl_users");
$statements->execute();
$empcount = $statements->fetch(PDO::FETCH_ASSOC);

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud FROM tbl_students");
$statements->execute();
$studcount = $statements->fetch(PDO::FETCH_ASSOC);

// Fetch all events
$sql = "SELECT * FROM tbl_events ORDER BY date DESC";
$stmt = $conn->query($sql); // Use $conn here if $pdo was a typo
$events = $stmt->fetchAll(PDO::FETCH_ASSOC);

$today = date('Y-m-d');
$todaysEvent = null;

// Separate today's event
foreach ($events as $event) {
  if ($event['date'] === $today) {
    $todaysEvent = $event;
    break;
  }
}
?>


<main id="main" class="main">
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../admin/index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">
          <!-- Employee Count Card -->
          <div class="col-xxl-4 col-md-6">
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
                <h5 class="card-title">Employee <span>| Count</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $empcount['count_emp'] ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Employee Count Card -->

          <!-- Student Count Card -->
          <div class="col-xxl-4 col-md-6">
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
                <h5 class="card-title">Student <span>| Count</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-people"></i>
                  </div>
                  <div class="ps-3">
                    <h6><?php echo $studcount['count_stud'] ?></h6>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Student Count Card -->

          <!-- EVENT -->
          <div class="col-xxl-4 col-md-6">
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
                <h5 class="card-title">Today's Event <span>| Details</span></h5>
                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-day"></i>
                  </div>
                  <div class="ps-3">
                    <?php if ($todaysEvent) : ?>
                      <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div style="flex-grow: 1;">
                          <h6 class="card-title"><?php echo htmlspecialchars($todaysEvent['title']); ?> <span class="badge bg-success" style="color: white;">Today's Event</span></h6>
                          <p><?php echo htmlspecialchars($todaysEvent['date']); ?></p>
                          <!-- <p><?php echo htmlspecialchars($todaysEvent['description']); ?></p>-->
                        </div>
                      </li>
                    <?php else : ?>
                      <p>No events scheduled for today.</p>
                    <?php endif; ?>
                  </div>
                </div>
              </div>
            </div>
          </div><!-- End Event -->

          <!-- Students Enrolled -->
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
                <h5 class="card-title">Students <span>| Enrolled</span></h5>
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Student ID</th>
                      <th scope="col">Full Name</th>
                      <th scope="col">Action</th>
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
                          <th scope="row"><a href=""><?php echo $row["user_name"] ?></a></th>
                          <td><?php echo $row["lname"] ?>, <?php echo $row["fname"] ?></td>
                          <td>
                            <form action="student_profile.php" method="post">
                              <input type="hidden" name="stud_id" value="<?php echo $row['user_id']; ?>">
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
          </div><!-- End Students Enrolled -->

          <!-- Employee -->
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
                      <li><a class="dropdown-item" href="../admin/user-instructor.php">Instructor</a></li>
                      <li><a class="dropdown-item" href="../admin/user-student.php">Student</a></li>
                      <li><a class="dropdown-item" href="../admin/user.php">Admin</a></li>
                    </ul>
                  </div>

                  <div class="card-body">
                    <h5 class="card-title">Instructor <span>| Hired</span></h5>

                    <table class="table table-borderless datatable">
                      <thead>
                        <tr>
                          <th scope="col">Username</th>
                          <th scope="col">Full Name</th>
                          <th scope="col">Email</th>
                          <th scope="col">Action</th>
                        </tr>
                      </thead>
                      <!--$sql = "SELECT * FROM tbl_users WHERE user_role = 'admin' OR user_role = 'teacher'
                                ORDER BY user_id ASC";-->
                      <tbody>
                        <?php
                        $database = new Connection();
                        $db = $database->open();

                        try {
                          $sql = "SELECT * FROM tbl_users WHERE user_role = 'teacher'
                                ORDER BY user_id ASC";

                          foreach ($db->query($sql) as $row) {
                        ?>
                            <tr>
                              <th scope="row"><a href="#"><?php echo $row["user_name"] ?></a></th>
                              <td><?php echo $row["user_fname"] ?>, <?php echo $row["user_lname"] ?></td>
                              <td><?php echo $row["user_email"] ?></td>
                              <td>
                                <form method="POST" action="../admin/upload/delete-user.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                                  <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                                  <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                                </form>
                              </td>
                              <?php include('modals/insert-student.php'); ?>
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
      </div>
    </div>
  </section>

</main><!-- End #main -->

<!-- Link to Bootstrap JS and its dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

<?php
include_once "../templates/footer.php";
?>