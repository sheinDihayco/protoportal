<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/student-classes-con.php"; ?>

<main id="main" class="main">
   
    <div class="pagetitle">
        <h1> Currently Enrolled Classes</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../admin/index3.php">Home</a></li>
                <li class="breadcrumb-item active">Classes</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card mt-4">
                        <div class="card-body">
                            <h5 class="card-title">Classes <span>| Enrolled </span></h5>
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>    
                                        <th scope="col">Instructor</th>
                                        <th scope="col">Subject Code</th>
                                        <th scope="col">Subject Description</th>
                                        <th scope="col">View Class</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($courses)): ?>
                                        <?php
                                        // Initialize an array to keep track of displayed instructor-subject combinations
                                        $displayed = [];
                                        ?>
                                        <?php foreach ($courses as $course => $course_data): ?>
                                            <?php foreach ($course_data['subjects'] as $subject_id => $subject): ?>
                                                <?php
                                                // Fetch the instructor for the subject
                                                $instructor_stmt = $conn->prepare("
                                                    SELECT u.user_id, u.user_fname, u.user_lname 
                                                    FROM tbl_student_instructors si
                                                    JOIN tbl_users u ON si.instructor_id = u.user_id
                                                    WHERE si.subject_id = :subject_id
                                                ");
                                                $instructor_stmt->bindParam(':subject_id', $subject_id, PDO::PARAM_INT);
                                                $instructor_stmt->execute();
                                                $instructor = $instructor_stmt->fetch(PDO::FETCH_ASSOC);

                                                if ($instructor) {
                                                    // Create a unique key for the instructor-subject combination
                                                    $unique_key = $instructor['user_fname'] . ' ' . $instructor['user_lname'] . '|' . $subject['code'];

                                                    // Check if this combination has already been displayed
                                                    if (!in_array($unique_key, $displayed)) {
                                                        // If not, display it and add it to the displayed array
                                                        $displayed[] = $unique_key; // Mark as displayed
                                                        ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($instructor['user_fname'] . ' ' . $instructor['user_lname']); ?></td>
                                                            <td><?php echo htmlspecialchars($subject['code']); ?></td>
                                                            <td><?php echo htmlspecialchars($subject['description']); ?></td>
                                                            <td>
                                                                <a href="class-assigned-students.php?instructor_id=<?php echo htmlspecialchars($instructor['user_id']); ?>&subject_id=<?php echo htmlspecialchars($subject_id); ?>" class="btn btn-success btn-sm"><i class="ri-arrow-right-circle-fill"></i></a>
                                                            </td>
                                    
                                                        </tr>
                                                    <?php }
                                                } ?>
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