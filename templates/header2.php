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

// Check if the user exists before trying to access array keys
if ($user) {
    $fname = $user['user_fname'];
    $lname = $user['user_lname'];
    $image = $user['user_image'];
} else {
    // Handle case where user is not found (optional handling)
    echo "User not found.";
    // Optionally redirect or show an error message
    header("location:login.php?error=usernotfound");
    exit;
}

// Close the connection when done
$database->close();
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
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">
      <div class="profile-section">
          <div class="profile-img">
              <!-- Display current profile image with a default fallback -->
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

          <form action="upload/upload-image2.php" method="post" enctype="multipart/form-data">
              <input type="file" id="fileInput" name="file" style="display: none;" onchange="previewImage();" />

              <!-- Save Button -->
              <div class="save-button" id="saveButton" style="display: none;">
                  <button type="submit" class="btn btn-primary" name="save">Save</button>
              </div>
          </form>

          <!-- Preview Image Section -->
          <div class="preview-section" style="display: none;">
              <img id="preview" src="" alt="Image Preview" class="img-thumbnail">
          </div>
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
        <a class="nav-link collapsed" href="../admin/index2.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/schedule-teacher.php">
          <i class="ri-time-line"></i>
          <span>Schedule</span>
        </a>
      </li>

      <!-- <li class="nav-item">
                <a class="nav-link collapsed" href="../admin/stud_recs.php">
                    <i class="ri ri-group-line"></i>
                    <span>Student</span>
                </a>
            </li>-->

      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-journal-text"></i><span>Academics</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <!-- LIST OF ALL STUDENT UNDER-->
            <a href="../admin/studentRecords.php">
              <i class="ri-booklet-fill"></i><span>Students</span>
            </a>
          </li>

          <li>
            <!-- TO GIVE GRADES-->
            <a href="../admin/grade.php">
              <i class="ri-booklet-fill"></i><span>Grades</span>
            </a>
          </li>
        </ul>
      </li><!-- End Components Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/event-teacher.php">
          <i class="ri-calendar-check-fill"></i>
          <span>Events</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="../admin/includes/logout.inc.php">
          <i class="ri-logout-circle-r-line"></i>
          <span>Log out</span>
        </a>
      </li>
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

    <!-- <div style="margin-top: 13%; position:fixed">
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