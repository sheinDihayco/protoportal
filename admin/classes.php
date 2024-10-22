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
                                        <th scope="col">Subject Code</th>
                                        <th scope="col">Subject Description</th>
                                        <th scope="col">View Students</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php if (!empty($instructors)): ?>
                                    <?php
                                    // Initialize an array to keep track of displayed instructor-subject combinations
                                    $displayed = [];
                                    ?>
                                    <?php foreach ($instructors as $instructor_id => $instructor): ?>
                                        <?php foreach ($instructor['courses'] as $course => $course_data): ?>
                                            <?php foreach ($course_data['subjects'] as $subject): ?>
                                                <?php
                                                // Create a unique key for the instructor-subject combination
                                                $unique_key = $instructor['name'] . '|' . $subject['code'];

                                                // Check if this combination has already been displayed
                                                if (!in_array($unique_key, $displayed)) {
                                                    // If not, display it and add it to the displayed array
                                                    $displayed[] = $unique_key; // Mark as displayed
                                                    ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($instructor['name']); ?></td>
                                                        <td><?php echo htmlspecialchars($subject['code']); ?></td>
                                                        <td><?php echo htmlspecialchars($subject['description']); ?></td>
                                                        <td>
                                                            <a href="../admin/class-assigned.php?user_id=<?php echo htmlspecialchars($instructor_id); ?>" class="btn btn-success btn-sm">
                                                                <i class="ri-arrow-right-circle-fill"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No records found.</td>
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