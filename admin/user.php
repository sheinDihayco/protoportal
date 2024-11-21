<?php include_once "../templates/header.php";?>
<?php include_once '../PHP/user-con.php' ?>
<?php include('modals/register-admin-employee.php'); ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Instructor Account Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertEmployeeAdmin">
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
                <h5 class="card-title">Search Employee <span>| Hired</span></h5>
                <!-- Search Form -->
                <form method="GET" action="" class="row g-3 align-items-center">
                    <!-- Search Input -->
                    <div class="col-md-8 d-flex gap-2">
                        <input type="text" class="form-control" name="search_user" placeholder="Enter Last Name" value="<?php echo isset($_GET['search_user']) ? htmlspecialchars($_GET['search_user']) : ''; ?>">
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
    
        <!-- Instructors Registered -->
        <?php if (isset($_GET['search_user']) && !empty($_GET['search_user'])): ?>
            <!-- Display Table -->
            <div class="col-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <h5 class="card-title">Result <span>| Registered Instructor</span></h5>

                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Username</th>
                                    <th scope="col">Full Name</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Database connection
                                $database = new Connection();
                                $db = $database->open();

                                try {
                                    // Get search query and filter by last name
                                    $search_user = htmlspecialchars($_GET['search_user']);
                                    $sql = "SELECT * FROM tbl_users 
                                            WHERE (user_role = 'teacher' OR user_role = 'admin') 
                                            AND user_lname LIKE :search_user 
                                            ORDER BY user_id ASC";
                                    $stmt = $db->prepare($sql);
                                    $stmt->execute(['search_user' => "%$search_user%"]);

                                    // Check for results
                                    if ($stmt->rowCount() > 0) {
                                        // Display results
                                        while ($row = $stmt->fetch()) {
                                ?>
                                            <tr>
                                                <th scope="row"><a href="#"><?php echo htmlspecialchars($row["user_name"]); ?></a></th>
                                                <td><?php echo htmlspecialchars($row["user_fname"]) . ' ' . htmlspecialchars($row["user_lname"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["user_email"]); ?></td>
                                                <td>
                                                    <!-- Profile Button -->
                                                    <form action="../admin/employee_profile.php" method="post" style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
                                                        <button type="submit" class="btn btn-sm btn-success" name="submit">
                                                            <i class="ri-arrow-right-circle-fill"></i>
                                                        </button>
                                                    </form>

                                                    <!-- Delete Button -->
                                                    <form method="POST" action="../admin/upload/delete-user.php" style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line" onclick="return confirm('Are you sure you want to delete this user?')"></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php include('modals/edit-info-employee.php'); ?>
                                <?php
                                        }
                                    } else {
                                        // No results found
                                        echo "<tr><td colspan='4' class='text-danger'>No records found.</td></tr>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }

                                $database->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- End Instructors Registered -->

    </div>

</main><!-- End #main -->
<style>
    .text-danger{
        font-style: italic;
        text-align: center;
    }
</style>
<?php include_once "../templates/footer.php"; ?>

