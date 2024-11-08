<?php include_once "../templates/header.php" ?>;
<?php include_once '../PHP/user-student-con.php' ?>
<?php include('modals/register-student.php'); ?>

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

    <div class="container">
        
        <div class="card mt-4">
            <div class="card-body">
                  <h5 class="card-title">Search students <span>| Enrolled</span></h5>
                <!-- Search Form -->
                <form method="GET" action="" class="row g-3 align-items-center">
                    <!-- Search Input -->
                    <div class="col-md-8 d-flex gap-2">
                        <input type="text" class="form-control" name="search_user" placeholder="Enter Student ID (e.g., MIIT-0000-000)" value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
                    </div>

                    <!-- Search and Clear Buttons -->
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" name="search" class="btn btn-primary" title="Search">
                            <i class="bx bx-search-alt"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearInputField()" title="Clear Search">
                            <i class="bx bx-eraser"></i> Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            // Only display the table if search_user is not empty
            if (isset($_GET['search_user']) && !empty($_GET['search_user'])):
                ?>
                    <!-- Display Table -->
                    <div class="col-12 tblStudents">
                        <div class="card mt-4">
                            <div class="card-body">
                                <h5 class="card-title">Result <span>| Enrolled Student</span></h5>

                                <table class="table table-striped ">
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
                                            // Query to fetch students based on search criteria
                                            $search_user = htmlspecialchars($_GET['search_user']);
                                            $sql = "SELECT * FROM tbl_students WHERE user_name LIKE :search_user ORDER BY lname ASC";
                                            $stmt = $db->prepare($sql);
                                            $stmt->execute(['search_user' => "%$search_user%"]);

                                            while ($row = $stmt->fetch()) {
                                        ?>
                                            <tr>
                                                <th scope="row" style="font-weight:bold;"><a href=""><?php echo $row["user_name"] ?></a></th>
                                                <td><?php echo $row["lname"] ?>, <?php echo $row["fname"] ?></td>
                                                <td><?php echo $row["status"] ?></td>
                                                <td>
                                                    <!-- Action Buttons -->
                                                    <!--<button type="button" class="btn btn-sm btn-warning ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo htmlspecialchars($row['user_id']); ?>"></button>-->
                                                    <form action="student_profile.php" method="post" style="display:inline;">
                                                        <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                                        <button type="submit" class="btn btn-sm btn-success" name="submit">
                                                            <i class="ri-arrow-right-circle-fill"></i>
                                                        </button>
                                                    </form>
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
                <?php
            endif;
        ?>
    </div>
        <!-- End Students Enrolled -->
</main><!-- End #main -->

<?php include_once "../templates/footer.php" ?>;