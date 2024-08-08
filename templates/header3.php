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
$statements = $conn->prepare("SELECT u.user_fname, u.user_lname, u.user_image, s.course
    FROM tbl_users u
    JOIN tbl_students s ON u.user_id = s.user_id
    WHERE u.user_id = :userid
");
$statements->bindParam(':userid', $userid, PDO::PARAM_INT);
$statements->execute();
$user = $statements->fetch(PDO::FETCH_ASSOC);

if ($user) {
  $fname = $user['user_fname'];
  $lname = $user['user_lname'];
  $image = $user['user_image'];
  $course = $user['course'];
} else {
  // Handle the case where no user was found
  echo "User or student information not found.";
  exit;
}
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
            <i class="ri-image-add-line"></i> <!-- Upload icon -->
          </a>
        </div>

        <form action="upload/upload-image.php" method="post" enctype="multipart/form-data">
          <input type="file" id="fileInput" name="file" style="display: none;" onchange="showSaveButton();" />

          <!-- Save Button -->
          <div class="save-button" id="saveButton" style="display: none;">
            <button type="submit" class="btn btn-primary btn-sm" name="save">Save</button>
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
        <a class="nav-link collapsed" href="../admin/index3.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="#">
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
        <a class="nav-link collapsed" href="#">
          <i class="bx bx-book"></i>
          <span>Grades</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="Subjects">
          <i class="ri-calendar-2-fill"></i>
          <span>Prospectus</span>
          <i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
          <?php
          // Debugging: Output the course value
          // echo '<li><a href="#"><i class="bi bi-circle"></i><span>Course: ' . htmlspecialchars($course) . '</span></a></li>';

          // Display prospectus links based on the course
          switch (strtoupper(trim($course))) {
            case 'BSIT':
              echo '<li>
              <a href="../admin/bsit-prospectus.php">
                <i class="bi bi-circle"></i><span>BSIT</span>
              </a>
            </li>';
              break;
            case 'BSBA':
              echo '<li>
              <a href="../admin/bsba-prospectus.php">
                <i class="bi bi-circle"></i><span>BSBA</span>
              </a>
            </li>';
              break;
            case 'BSOA':
              echo '<li>
              <a href="../admin/bsoa-prospectus.php">
                <i class="bi bi-circle"></i><span>BSOA</span>
              </a>
            </li>';
              break;
            case 'GRADE11':
              echo '<li>
              <a href="../admin/grade11-prospectus.php">
                <i class="bi bi-circle"></i><span>Grade 11 Subjects</span>
              </a>
            </li>';
              break;
            case 'GRADE12':
              echo '<li>
              <a href="../admin/grade12-prospectus.php">
                <i class="bi bi-circle"></i><span>Grade 12 Subjects</span>
              </a>
            </li>';
              break;
            default:
              // Optionally handle the case where $course does not match any known values
              echo '<li>
              <a href="#">
                <i class="bi bi-circle"></i><span>No Prospectus Available</span>
              </a>
            </li>';
              break;
          }
          ?>
        </ul>
      </li>


      <li class="nav-item">
        <a class="nav-link collapsed" href="">
          <i class="bx bx-book"></i>
          <span>Enrollment</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/payment1.php">
          <i class="bx bx-wallet"></i>
          <span>Payment</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/includes/logout.inc.php">
          <i class="ri-logout-circle-r-line"></i>
          <span>Log out</span>
        </a>
      </li>
    </ul>
  </aside><!-- End Sidebar -->


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