<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/classes-con.php"; ?>


<main id="main" class="main">
    <div class="pagetitle">
        <h1>Assigned Classes to Instructors</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Classes</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Classes <span>| Enrolled </span></h5>
                               <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Instructor</th>
                                            <th scope="col">Course & Year</th>
                                            <th scope="col">View Students</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($instructors)): ?>
                                            <?php foreach ($instructors as $instructor_id => $instructor): ?>
                                                <?php foreach ($instructor['courses'] as $course => $years): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($instructor['name']); ?></td>
                                                        <td>
                                                            <?php
                                                            // Remove duplicate years and sort them
                                                            $unique_years = array_unique($years);
                                                            sort($unique_years);
                                                            echo htmlspecialchars($course) . ' - ' . implode(',', $unique_years);
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <a href="../admin/class-assigned.php?user_id=<?php echo htmlspecialchars($instructor_id); ?>" class="btn btn-success btn-sm">
                                                                <i class="ri-arrow-right-circle-fill"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3">No records found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "../templates/footer.php"; ?>