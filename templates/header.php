<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MicroTech</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../assets/img/favicon.png" rel="icon">
  <link href="../../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>
<?php
include_once "includes/connection.php"; // Use connection.php for database connection

session_start();
if (!isset($_SESSION["login"])) {
  header("location:login.php?error=loginfirst");
  exit;
}

$database = new Connection();
$conn = $database->open();

$userid = $_SESSION["login"];

// Fetch user information from the database
$statements = $conn->prepare("SELECT user_fname, user_lname, user_image FROM tbl_users WHERE user_id = ?");
$statements->execute([$userid]);
$user = $statements->fetch(PDO::FETCH_ASSOC);

$fname = $user['user_fname'];
$lname = $user['user_lname'];
$image = $user['user_image'];

// Close the connection when done
$database->close();
?>
<body>

  <?php
  if (isset($_SESSION['login_success']) && $_SESSION['login_success']) {
    echo "
        <div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
            Successfully logged in!
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
    unset($_SESSION['login_success']);
  }
  ?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../admin/index.php" class="logo d-flex align-items-center">
        <img src="../assets/img/miit.png" alt="">
        <span class="d-none d-lg-block">MicroTech</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <div class="profile-section">
        <div class="profile-img">
          <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="rounded-circle">
        </div>

        <div class="profile-info">
          <h5><?php echo htmlspecialchars($lname) . ', ' . htmlspecialchars($fname); ?></h5>
        </div>
        <div class="settings-icon">
          <a href="javascript:void(0);" onclick="document.getElementById('fileInput').click();">
            <i class="ri-image-add-line"></i>
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


      <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/studentRecords1.php">
          <i class="ri ri-group-line"></i>
          <span>Student</span>
        </a
      </li>-->

      <!-- Start Forms Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Academics</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../admin/set-schedule.php">
              <i class="ri-checkbox-blank-circle-fill"></i><span>Schedule</span>
            </a>
          </li>

          <li>
            <a href="../admin/Grades.php">
              <i class="ri-checkbox-blank-circle-fill"></i><span>Grades</span>
            </a>
          </li>

          <li>
            <a href="../admin/course.php">
              <i class="ri-checkbox-blank-circle-fill"></i><span>Courses</span>
            </a>
          </li>

          <li>
            <a href="../admin/assign-student-instructors.php">
              <i class="ri-checkbox-blank-circle-fill"></i><span>Assign Students</span>
            </a>
          </li>

        </ul>
      </li>
      <!-- End Forms Nav -->

      <!-- Start User Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
          <i class="ri ri-group-line"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="../admin/user-student.php">
              <i class="bi bi-circle-fill"></i><span>Students</span>
            </a>
          </li>
          <li>
            <a href="../admin/user.php">
              <i class="bi bi-circle-fill"></i><span>Instructors</span>
            </a>
          </li>
        </ul>
      </li>
      <!-- End User Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/event2.php">
          <i class="ri-calendar-check-line"></i>
          <span>Events</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/subject.php">
          <i class="ri-book-3-line"></i>
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
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse"></i><span>Form</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/enrollment-form.php">
              <i class="ri-checkbox-blank-circle-fill"></i>
              <span>Enrollment Form</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed" href="#">
              <i class="ri-checkbox-blank-circle-fill"></i>
              <span>Permit Form</span>
            </a>
          </li>
        </ul>
      </li><!-- End Tables Nav -->

      <!--<li class="nav-item">
        <a class="nav-link collapsed" href="../admin/employee.php">
          <i class="ri ri-group-line"></i>
          <span>Employee</span>
        </a>
      </li>-->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/includes/logout.inc.php">
          <i class="ri-logout-circle-r-line"></i>
          <span>Log out</span>
        </a>
      </li>

      <br>
      <div class="settings-icon" style="display: none;">
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

    <!-- <div style="margin-top: -5.5%; position:sticky">
      <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider round"></span>
      </label>
    </div>-->

  </aside><!-- End Sidebar-->

  <script>
    document.querySelectorAll('.sidebar .nav-link').forEach(anchor => {
      anchor.addEventListener('click', function(e) {
        if (this.hash !== "") {
          e.preventDefault();

          const target = document.querySelector(this.hash);
          if (target) {
            target.scrollIntoView({
              behavior: 'smooth'
            });
          }
        }
      });
    });
  </script>


  <script>
    // Get the toggle button and the body element
    const toggleButton = document.getElementById('darkModeToggle');
    const body = document.body;

    // Check if dark mode is already enabled
    if (localStorage.getItem('darkMode') === 'enabled') {
      body.classList.add('dark-mode');
      toggleButton.checked = true;
    }

    // Function to enable dark mode
    const enableDarkMode = () => {
      body.classList.add('dark-mode');
      localStorage.setItem('darkMode', 'enabled');
    };

    // Function to disable dark mode
    const disableDarkMode = () => {
      body.classList.remove('dark-mode');
      localStorage.setItem('darkMode', 'disabled');
    };

    // Add an event listener to toggle dark mode
    toggleButton.addEventListener('click', () => {
      if (toggleButton.checked) {
        enableDarkMode();
      } else {
        disableDarkMode();
      }
    });
  </script>

  <style>
    html {
      scroll-behavior: smooth;
    }

    .sidebar .nav-link {
      transition: background-color 0.3s ease, color 0.3s ease;
    }

    .sidebar .nav-link:hover {
      background-color: #f0f0f0;
      color: #333;
    }

    .profile-section {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 1rem;
      border-bottom: 1px solid #ddd;
    }

    .profile-img img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      margin-bottom: 10px;
    }

    .profile-info h5 {
      margin: 0;
      font-size: 1.1rem;
      text-align: center;
    }

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

    /* Universal Dark Mode Styles */
    .dark-mode {
      background-color: #222;
      color: #e0e0e0;
    }

    /* Header and Sidebar Styling */
    .dark-mode .header,
    .dark-mode .sidebar {
      background-color: #2c2c2c;
      color: #f0f0f0;
    }

    /* Text Color for Various Titles and Links */
    .dark-mode .nav-link,
    .dark-mode .profile-info h5,
    .dark-mode .card-title,
    .dark-mode .pagetitle h1,
    .dark-mode .title,
    .dark-mode .nav-item a,
    .dark-mode .sidebar-nav li,
    .dark-mode .settings-icon a {
      color: #d1d1d1;
    }

    .dark-mode .save-button button {
      background-color: #555;
      border: 1px solid #666;
      color: #f0f0f0;
    }

    .dark-mode .card,
    .dark-mode .card-body,
    .dark-mode .list-group-item,
    .dark-mode .mb-3 input,
    .dark-mode .mb-3 textarea,
    .dark-mode .table th,
    .dark-mode .modal-content,
    .dark-mode .modal-content input,
    .dark-mode .modal-content select {
      background-color: #3c3c3c;
      color: #f0f0f0;
    }

    .dark-mode .card a,
    .dark-mode .table td,
    .dark-mode .d-none,
    .dark-mode .ps-3 h6,
    .dark-mode .col-md-2 label,
    .dark-mode .modal-title {
      color: #ffffff;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 40px;
      height: 20px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #1a1a1a;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 16px;
      width: 16px;
      left: 2px;
      bottom: 2px;
      background-color: #0088ff;
      transition: .4s;
    }

    input:checked+.slider {
      background-color: #555;
    }

    input:checked+.slider:before {
      transform: translateX(20px);
    }

    .slider.round {
      border-radius: 20px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
  </style>