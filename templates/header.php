<?php
include_once "includes/connect.php";
include_once "includes/connection.php";

session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php?error=loginfirst");
  exit;
}

$userid = $_SESSION["login"];

// Fetch user information from the database
$statements = $conn->prepare("SELECT user_fname, user_lname, user_image FROM tbl_users WHERE user_id = ?");
$statements->execute([$userid]);
$user = $statements->fetch(PDO::FETCH_ASSOC);

$fname = $user['user_fname'];
$lname = $user['user_lname'];
$image = $user['user_image'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MicroTech</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/miit.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../admin/index.php" class="logo d-flex align-items-center">
        <img src="../assets/img/miit.png" alt="">
        <span class="d-none d-lg-block">MicroTech</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <!-- End Search Ba -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <!-- <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a>End Notification Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul><!-- End Notification Dropdown Items -->

        </li><!-- End Notification Nav -->

        <!-- <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a>End Messages Icon -->

        <!-- <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="../assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="../assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="../assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul>End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <!--<li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $lname ?></span>
          </a>End Profile Iamge Icon -->

        <!--<ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header">
            <h6>
              <h6>
                <?php echo $lname ?>, <?php echo $fname ?>
              </h6>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
              <i class="bi bi-person"></i>
              <span>My Profile</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="users-profile.php">
              <i class="bi bi-gear"></i>
              <span>Account Settings</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
              <i class="bi bi-question-circle"></i>
              <span>Need Help?</span>
            </a>
          </li>
          <li>
            <hr class="dropdown-divider">
          </li>

          <li>
            <a class="dropdown-item d-flex align-items-center" href="../admin/includes/logout.inc.php">
              <i class="bi bi-box-arrow-right"></i>
              <span>Sign Out</span>
            </a>
          </li>

      </ul>End Profile Dropdown Items 
        </li> End Profile Nav

      </ul>
    </nav>End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <div class="profile-section">
        <div class="profile-img">
          <img src="upload-files/<?php echo htmlspecialchars($image); ?>" alt="Profile Image" class="rounded-circle">
        </div>

        <div class="profile-info">
          <h5><?php echo htmlspecialchars($lname) . ', ' . htmlspecialchars($fname); ?></h5>
        </div>
        <div class="settings-icon">
          <a href="javascript:void(0);" onclick="document.getElementById('fileInput').click();">
            <i class="ri-upload-fill"></i> <!-- Upload icon -->
          </a>
        </div>

        <form action="upload/upload-image1.php" method="post" enctype="multipart/form-data">
          <input type="file" id="fileInput" name="file" style="display: none;" onchange="showSaveButton();" />

          <!-- Save Button -->
          <div class="save-button" id="saveButton" style="display: none;">
            <button type="submit" class="btn btn-primary" name="save">Save</button>
          </div>
        </form>
      </div>

      <script>
        function showSaveButton() {
          var fileInput = document.getElementById('fileInput');
          var saveButton = document.getElementById('saveButton');
          if (fileInput.files.length > 0) {
            saveButton.style.display = 'block';
          } else {
            saveButton.style.display = 'none';
          }
        }
      </script>



      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/index.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/employee.php">
          <i class="ri ri-group-line"></i>
          <span>Employee</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/studentRecords1.php">
          <i class="ri ri-group-line"></i>
          <span>Student</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/event.php">
          <i class="ri-calendar-check-line"></i>
          <span>Events</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/schedule.php">
          <i class="ri-calendar-2-fill"></i>
          <span>Schedule</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/subject.php">
          <i class="ri-calendar-2-fill"></i>
          <span>Prospectus</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/payment.php">
          <i class="bx bx-wallet"></i>
          <span>Payment</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/user.php">
          <i class="ri-user-fill"></i>
          <span>Users</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/compensation.php">
          <i class="bi bi-layout-text-window-reverse"></i>
          <span>Compensation</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/includes/logout.inc.php">
          <i class="ri-logout-circle-r-line"></i>
          <span>Log out</span>
        </a>
      </li>

      <br>
      <div class="settings-icon">
        <a href="../admin/user-form.php">
          <i class="bi bi-gear"></i> <!-- Settings icon -->
        </a>
      </div>
      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
          <i class="ri ri-group-line"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../admin/student.php">
              <i class="bi bi-circle-fill"></i><span>Students</span>
            </a>
          </li>
          <li>
            <a href="../admin/instructor.php">
              <i class="bi bi-circle-fill"></i><span>Instructors</span>
            </a>
          </li>
        </ul>
      </li> -->
      <!-- End Components Nav -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../admin/enrollment.php">
              <i class="bi bi-circle"></i><span>Enrollment</span>
            </a>
          </li>
          <li>
            <a href="../admin/schedule.php">
              <i class="bi bi-circle"></i><span>Schedule</span>
            </a>
          </li>
          <li>
            <a href="../admin/upload.eval.php">
              <i class="bi bi-circle"></i><span>Evaluation</span>
            </a>
          </li>
          <li>
            <a href="../admin/grade.php">
              <i class="bi bi-circle"></i><span>Grade</span>
            </a>
          </li>
        </ul>
      </li> -->

      <!-- End Components Nav -->

    </ul>
  </aside><!-- End Sidebar-->

  <style>
    /* Inline styles for quick adjustments */
    .profile-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      /* Center horizontally */
      padding: 1rem;
      border-bottom: 1px solid #ddd;
    }

    .profile-img img {
      width: 80px;
      /* Adjust size as needed */
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
      /* Space between image and text */
    }

    .profile-info h5 {
      margin: 0;
      font-size: 1.1rem;
      text-align: center;
    }
  </style>