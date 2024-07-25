<?php
include_once "../templates/header3.php";
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1> Account Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Accounts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
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
                                <h5 class="card-title">Accounts <span>| Registered</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">User ID</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Username</th>
                                            <th scope="col">Role</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $database = new Connection();
                                        $db = $database->open();

                                        try {
                                            // Prepare the SQL statement
                                            $sql = "SELECT s.*, u.*
                                                    FROM tbl_students s
                                                    INNER JOIN tbl_users u ON s.user_id = u.user_id
                                                    WHERE s.user_id = :user_id";

                                            $stmt = $db->prepare($sql);
                                            $stmt->bindParam(':user_id', $userid);
                                            $stmt->execute();
                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                            if ($row) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><a href="#"><?php echo htmlspecialchars($row["user_id"]); ?></a></th>
                                                    <td><?php echo htmlspecialchars($row["user_fname"]); ?>, <?php echo htmlspecialchars($row["user_lname"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["user_email"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["user_name"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["user_role"]); ?></td>
                                                    <td>
                                                        <button type="button" class="ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlspecialchars($row["user_id"]); ?>"></button>
                                                        <form method="POST" action="../admin/upload/delete-user.php" onsubmit="return confirm('Are you sure you want to delete this user?');" style="display:inline;">
                                                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row["user_id"]); ?>">
                                                            <button type="submit" class="ri-delete-bin-6-line"></button>
                                                        </form>
                                                    </td>
                                                    <?php include('modals/edit-employee.php'); ?>
                                                </tr>
                                        <?php
                                            } else {
                                                echo "<p>No user found.</p>";
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
    </section>

</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>