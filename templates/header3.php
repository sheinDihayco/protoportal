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
include_once "includes/connection.php"; // Ensure connection.php is correctly included

session_start();

if (!isset($_SESSION["login"])) {
  header("location:login.php?error=loginfirst");
  exit;
}

$database = new Connection();
$conn = $database->open();

$userid = $_SESSION["login"];

// Debugging: Check if $userid is set correctly
if (empty($userid)) {
    die("User ID is not set.");
}

// Fetch user information from the database
$statements = $conn->prepare("SELECT u.fname, u.lname, u.user_image, u.course, u.user_role
    FROM tbl_students u
    LEFT JOIN tbl_users s ON u.user_id = s.user_id
    WHERE u.user_id = :userid
");

$statements->bindParam(':userid', $userid, PDO::PARAM_INT);
$statements->execute();
$user = $statements->fetch(PDO::FETCH_ASSOC);

if ($user) {
  $fname = $user['fname'];
  $lname = $user['lname'];
  $role = $user['user_role'];
  $image = $user['user_image'];
  $course = isset($user['course']) ? $user['course'] : 'No course available';
} else {
  // Handle the case where no user was found
  echo "User or student information not found.";
  exit;
}

// Close the connection
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
  <header id="header" class="header fixed-top d-flex align-items-center" style="background-color: #008000;">
    <div class="d-flex align-items-center justify-content-between">
      <a href="../admin/index3.php" class="logo d-flex align-items-center">
        <img src="../assets/img/miit.png" alt="">
        <span class="d-none d-lg-block">MicroTech</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a><!-- End Notification Icon -->

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

        <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a><!-- End Messages Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="../../assets/img/messages-1.jpg" alt="" class="rounded-circle">
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
                <img src="../../assets/img/messages-2.jpg" alt="" class="rounded-circle">
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
                <img src="../../assets/img/messages-3.jpg" alt="" class="rounded-circle">
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

          </ul><!-- End Messages Dropdown Items -->

        </li><!-- End Messages Nav -->

        <!-- Start Profile Nav -->
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
           <img src="upload-files/<?php echo htmlspecialchars($image); ?>" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo htmlspecialchars($lname)?></span>
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
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
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
              <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" onclick="document.getElementById('fileInput').click();">
                <i class="ri-image-add-line"></i>
                <span>Update Profile</span>
              </a>

              <!-- Profile Section for Image Upload -->
                <form action="upload/upload-image1.php" method="post" enctype="multipart/form-data">
                  <input type="file" id="fileInput" name="file" style="display: none;" onchange="showSaveButton();" />

                  <!-- Save Button -->
                   <div class="save-button" id="saveButton" style="display: none; margin-left: 75%; margin-top:-15%;position:absolute">
                    <button type="submit" class="btn btn-primary btn-sm" name="save">Save</button>
                  </div>
                </form>
         
            </li>

            <script>
              function showSaveButton() {
                var fileInput = document.getElementById('fileInput');
                var saveButton = document.getElementById('saveButton');
                if (fileInput.files.length > 0) {
                  saveButton.style.display = 'inline-block';
                } else {
                  saveButton.style.display = 'none';
                }
              }
            </script>

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

  <aside id="sidebar" class="sidebar" style="background-color: #008000;">
    <ul class="sidebar-nav" id="sidebar-nav">

       <div class="profile-section">
        <div class="profile-img">
          <img src="../admin/images/miit.png" id="currentPhoto" onerror="this.src='images/default.png'" alt="Profile Image" class="rounded-circle">
        </div>

        <div class="text-white" >
          <h6>Microsystems International Institute of Technology Inc.</h6 >
        </div>
       
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/index3.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/schedule-students.php">
          <i class="ri ri-group-line"></i>
          <span>Schedule</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/event-student.php">
          <i class="ri ri-group-line"></i>
          <span>Events</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
          <i class="ri ri-group-line"></i><span>Prospectus</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <?php
          switch (strtoupper(trim($course))) {
            case 'BSIT':
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="../admin/bsit-prospectus.php">
                    <i class="bi bi-circle-fill"></i><span>BSIT</span>
                  </a>
                </li>';
              break;
            case 'BSBA':
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="../admin/bsba-prospectus.php">
                    <i class="bi bi-circle-fill"></i><span>BSBA</span>
                  </a>
                </li>';
              break;
            case 'BSOA':
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="../admin/bsoa-prospectus.php">
                    <i class="bi bi-circle-fill"></i><span>BSOA</span>
                  </a>
                </li>';
              break;
            case 'ABM':
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="../admin/ABM-prospectus.php">
                    <i class="bi bi-circle-fill"></i><span>ABM</span>
                  </a>
                </li>';
              break;
            case 'GAS':
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="../admin/grade12-prospectus.php">
                    <i class="bi bi-circle-fill"></i><span>GAS</span>
                  </a>
                </li>';
              break;
            case 'ICT':
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="../admin/grade12-prospectus.php">
                    <i class="bi bi-circle-fill"></i><span>ICT</span>
                  </a>
                </li>';
              break;
            case 'HUMSS':
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="../admin/grade12-prospectus.php">
                    <i class="bi bi-circle-fill"></i><span>HUMSS</span>
                  </a>
                </li>';
              break;
            default:
              echo '
                <li class="nav-item">
                  <a class="nav-link collapsed" href="#">
                    <i class="bi bi-circle-fill"></i><span>No Prospectus Available</span>
                  </a>
                </li>';
              break;
          }
          ?>
        </ul>
      </li><!-- End Prospectus Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/payment1.php">
          <i class="bx bx-wallet"></i>
          <span>Payment</span>
        </a>
      </li>

    </ul>

    <!--<div style="margin-top: 35%; position:sticky">
      <label class="switch">
        <input type="checkbox" id="darkModeToggle">
        <span class="slider round"></span>
      </label>
    </div>-->


  </aside><!-- End Sidebar -->

<script>
    // Show preview and save button when file is selected
    function previewImage() {
        const fileInput = document.getElementById('fileInput');
        const preview = document.getElementById('preview');
        const saveButton = document.getElementById('saveButton');
        const previewSection = document.querySelector('.preview-section');

        if (fileInput.files.length > 0) {
            const file = fileInput.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                previewSection.style.display = 'block'; // Show preview
                saveButton.style.display = 'block'; // Show save button
            };

            reader.readAsDataURL(file);
        } else {
            previewSection.style.display = 'none'; // Hide preview
            saveButton.style.display = 'none'; // Hide save button
        }
    }
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
      /* Adjust color as needed */
      color: #333;
      /* Adjust color as needed */
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
      max-width: 300px;
      width: 100%;
      padding: 20px;
      background-color: #4CAF50;
      color: white;
      opacity: 1;
      transition: opacity 0.6s;
      margin-bottom: 15px;
      border-radius: 4px;
      position: fixed;
      top: 20px;
      left: 80%;
      z-index: 5000;
    }

    .closebtn {
      margin-left: 15px;
      color: white;
      font-weight: bold;
      float: right;
      font-size: 22px;
      line-height: 20px;
      cursor: pointer;
      transition: color 0.3s;
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