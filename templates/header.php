<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>MicroTech</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../admin/images/miit.png" rel="icon">
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
$statements = $conn->prepare("SELECT user_fname, user_lname, user_image, user_role FROM tbl_users WHERE user_id = ?");
$statements->execute([$userid]);
$user = $statements->fetch(PDO::FETCH_ASSOC);

// Check if user data was fetched successfully
if ($user) {
    $fname = $user['user_fname'];
    $lname = $user['user_lname'];
    $role = $user['user_role'];
    $image = $user['user_image'];
} else {
    // Handle the case where no user is found (perhaps redirect or display an error)
    $fname = '';
    $lname = '';
    $role = '';
    $image = 'default.png'; // Fallback image if user not found
    // Optional: Log the error, redirect to login, or show a message
    echo "User not found!";
}

// Close the connection when done
$database->close();
?>

<body style="background-color:#e6ffe6;">

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
  <header id="header" class="header fixed-top d-flex align-items-center" style="background-color: #00674f;">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../admin/index.php" class="logo d-flex align-items-center">
        <!--<img src="../assets/img/miit.png" alt="">-->
        <span class="d-none d-lg-block text-white">MicroTech</span> 
      </a>
      <i class="bi bi-list toggle-sidebar-btn text-white"></i>
    </div><!-- End Logo -->


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- Start Profile Nav -->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0 " href="#" data-bs-toggle="dropdown">
           <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-white"><?php echo htmlspecialchars($lname)?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo htmlspecialchars($lname) . ', ' . htmlspecialchars($fname); ?></h6>
              <span><?php echo htmlspecialchars($role)?></span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../admin/user-profile-admin.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../admin/account-settings-admin.php">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
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

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar" style="background-color: #00674f;">

    <ul class="sidebar-nav" id="sidebar-nav">

    <div class="profile-section">
      <div>
        <img src="../admin/images/miit-logo.png" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="rotate-flip">
      </div>

      <div class="logo-text" style="padding: 10px; text-align: center;">
        <h6>Microsystems International Institute of Technology Inc.</h6>
      </div>
    </div>

    <style>
      /*.rotate-flip {
        width: 150; 
        height: auto; 
        animation: flip360 4s infinite alternate; 
        transform-style: preserve-3d; 
      }

      @keyframes flip360 {
        0% {
          transform: rotateY(0deg); 
        }
        100% {
          transform: rotateY(180deg); 
        }
      }*/

      .logo-text h6 {
        font-family: 'Arial', sans-serif;
        font-size: 0.8rem;
        font-weight: 600;
        letter-spacing: 1px;
        color: #ffffff;
        text-transform: uppercase;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
      }
    </style>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/index.php">
          <i class="bi bi-grid-fill"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <li class="nav-item">
          <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-book-fill"></i><span>Academics</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/set-schedule.php">
              <i class="bi bi-circle-fill"></i>
              <span>Schedules</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/Grades.php">
              <i class="bi bi-circle-fill"></i>
              <span>Grades</span>
            </a>
          </li>
          
          <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/assign-student-instructors.php">
              <i class="bi bi-circle-fill"></i>
              <span>Assign Class</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/classes.php">
              <i class="bi bi-circle-fill"></i>
              <span>Class Records</span>
            </a>
          </li>


          </ul>
      </li><!-- End Tables Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
          <i class="ri-user-fill"></i><span>Users</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="user-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/user-student.php">
              <i class="bi bi-circle-fill"></i>
              <span>Students</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link collapsed" href="../admin/user.php">
              <i class="bi bi-circle-fill"></i>
              <span>Instructors</span>
            </a>
          </li>
          
        </ul>
      </li><!-- End Tables Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/event.php">
          <i class="bi bi-calendar-fill"></i>
          <span>Events</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/subject.php">
          <i class="bi bi-file-earmark-text-fill"></i>
          <span>Prospectus</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/payment.php">
          <i class="bi bi-wallet-fill"></i>
          <span>Payment</span>
        </a>
      </li>

      <!--<li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-file-earmark-fill"></i><span>Form</span><i class="bi bi-chevron-down ms-auto"></i>
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
      </li> End Tables Nav -->

      <br>
    </ul>

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

    .profile-image img {
      width: 150px;
      height: 100px;
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
    
  </style>