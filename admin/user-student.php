<?php include_once "../templates/header.php" ?>;
<?php include_once '../PHP/user-student-con.php' ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Student Account Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Accounts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="modal fade" id="insertStudent" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register Account</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="includes/register.inc.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
                        <div class="col-12">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="" disabled selected>Select your role</option>
                                <option value="admin">Admin</option>
                                <option value="teacher">Teacher</option>
                                <option value="student">Student</option>
                            </select>
                            <div class="invalid-feedback">Please select a role.</div>
                        </div>

                        <div class="col-12">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" name="firstName" class="form-control" id="firstName" required>
                            <div class="invalid-feedback">Please enter your first name.</div>
                        </div>

                        <div class="col-12">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" name="lastName" class="form-control" id="lastName" required>
                            <div class="invalid-feedback">Please enter your last name.</div>
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>

                        <div class="col-12" id="usernameDiv">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" id="username">
                            <div class="invalid-feedback">Please enter a valid username.</div>
                        </div>

                        <div class="col-12" id="schoolidDiv" style="display: none;">
                            <label for="schoolid" class="form-label">School ID</label>
                            <input type="text" name="schoolid" class="form-control" id="schoolid" pattern="[A-Za-z0-9\-]+" title="School ID can only contain letters, numbers, and dashes.">
                            <div class="invalid-feedback">Please enter a valid school ID (letters, numbers, and dashes only).</div>
                        </div>

                        <div class="col-12">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" id="password" required>
                            <div class="invalid-feedback">Please enter a password.</div>
                        </div>

                        <div class="col-12">
                            <label for="repeatPassword" class="form-label">Repeat Password</label>
                            <input type="password" name="repeatPassword" class="form-control" id="repeatPassword" required>
                            <div class="invalid-feedback">Please repeat your password.</div>
                        </div>

                        <div class="col-12">
                            <button class="btn btn-primary w-100" type="submit" name="register">Register</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    <section class="section dashboard">
        <!-- End Students Enrolled -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Students <span>| Enrolled</span></h5>
                        
                    <!-- Search Bar 
                    <form method="GET" action="">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search_user" placeholder="Search by username" value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </form>-->
                        <table class="table table-borderless datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                          <tbody>
                                <?php
                                // Database connection
                                $database = new Connection();
                                $db = $database->open();

                                try {
                                    // Check if the search input is set
                                    $searchQuery = "";
                                    if (isset($_GET['search_user']) && !empty($_GET['search_user'])) {
                                        $search_user = htmlspecialchars($_GET['search_user']);
                                        $searchQuery = " WHERE user_name LIKE '%$search_user%'";
                                    }

                                    // Query to fetch students based on search criteria
                                    $sql = "SELECT * FROM tbl_students $searchQuery ORDER BY lname ASC";
                                    foreach ($db->query($sql) as $row) {
                                ?>
                                        <tr>
                                            <th scope="row" style="font-size:bold;"><a href=""><?php echo $row["user_name"] ?></a></th>
                                            <td><?php echo $row["lname"] ?>, <?php echo $row["fname"] ?></td>
                                            <td><?php echo $row["status"] ?></td>
                                            <td>
                                                <!-- Edit Button -->
                                                <button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo htmlspecialchars($row['user_id']); ?>"></button>

                                                <!-- View Profile Button -->
                                                <form action="student_profile.php" method="post" style="display:inline;">
                                                    <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                                    <button type="submit" class="btn btn-sm btn-success" name="submit">
                                                        <i class="ri-arrow-right-circle-fill"></i>
                                                    </button>
                                                </form>

                                                <!-- Delete Button -->
                                                <form method="POST" action="../admin/upload/delete-student.php" style="display:inline;" id="deleteStudentForm">
                                                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                                                    <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line" onclick="confirmDelete()"></button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php include('modals/form-edit-Student.php'); ?>
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
        <!-- End Students Enrolled -->

    </section>


</main><!-- End #main -->

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>
<script>
    document.getElementById('role').addEventListener('change', function() {
        var role = this.value;
        if (role === 'student') {
            document.getElementById('usernameDiv').style.display = 'none';
            document.getElementById('schoolidDiv').style.display = 'block';
        } else {
            document.getElementById('usernameDiv').style.display = 'block';
            document.getElementById('schoolidDiv').style.display = 'none';
        }
    });
</script>

<?php include_once "../templates/footer.php" ?>;