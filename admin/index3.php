<?php
include_once "../templates/header3.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';
?>
<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">

            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">

                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">This Month</a></li>
                                    <li><a class="dropdown-item" href="#">This Year</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title"><?php echo $lname ?> <span>| Enrolled</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">School ID</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Payment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $database = new Connection();
                                        $db = $database->open();

                                        try {
                                            // Define your SQL query
                                            $sql = 'SELECT *, p.payment_status
                                                FROM tbl_student_records s
                                                INNER JOIN tbl_payments p  ON s.studentID = p.studentID
                                                WHERE lname = ?
                                                ORDER BY lname ASC';;

                                            // Prepare the statement
                                            $stmt = $db->prepare($sql);

                                            // Execute the statement with parameters
                                            $stmt->execute([$lname]); // Ensure $studentID is set before this

                                            // Fetch all results
                                            $results = $stmt->fetchAll();

                                            // Iterate over the results and display them
                                            foreach ($results as $rows) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><a href="#"><?php echo htmlspecialchars($rows["studentID"], ENT_QUOTES, 'UTF-8'); ?></a></th>
                                                    <td><?php echo htmlspecialchars($rows["lname"], ENT_QUOTES, 'UTF-8'); ?>, <?php echo htmlspecialchars($rows["fname"], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($rows["course"], ENT_QUOTES, 'UTF-8'); ?> - <?php echo htmlspecialchars($rows["year"], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <td><?php echo htmlspecialchars($rows["payment_status"], ENT_QUOTES, 'UTF-8'); ?></td>
                                                    <!--<td>
                                                        <button type="button" class="ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo htmlspecialchars($row["studentID"]); ?>"></button>
                                                        <form method="POST" action="../admin/upload/delete-student.php" onsubmit="return confirm('Are you sure you want to delete this student?');" style="display:inline;">
                                                            <input type="hidden" name="studentID" value="<?php echo htmlspecialchars($row["studentID"]); ?>">
                                                            <button type="submit" class="ri-delete-bin-6-line"></button>
                                                        </form>
                                                    </td>-->
                                                </tr>
                                        <?php
                                            }
                                        } catch (PDOException $e) {
                                            echo "There was a problem with the connection: " . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
                                        }

                                        // Close the database connection
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