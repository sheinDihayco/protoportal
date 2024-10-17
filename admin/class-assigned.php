<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/class-assigned-con.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Student Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../admin/classes.php">Classes</a></li>
                <li class="breadcrumb-item active">Enrolled</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <div class="filter">
                    <!-- Filter options -->
                </div>
                <div class="card-body">
                    <h5 class="card-title">Class Records <span>| Currently Enrolled</span></h5>
                        <table class="table table-borderless">
                            <thead>
                                <tr> 
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Course & Year</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($grouped_students)): ?>
                                    <?php foreach ($grouped_students as $course_year => $students_list): ?>
                                        <tr>
                                            <td colspan="3" class="table-primary">
                                                <strong><?php echo htmlspecialchars($course_year); ?></strong>
                                            </td>
                                        </tr>
                                        <?php foreach ($students_list as $student): ?>
                                            <tr>
                                                <td>
                                                    <a href="student_profile.php?user_id=<?php echo htmlspecialchars($student['user_id']); ?>">
                                                        <?php echo htmlspecialchars($student['user_name']); ?>
                                                    </a>
                                                </td>
                                                <td><?php echo htmlspecialchars($student['lname']); ?>, <?php echo htmlspecialchars($student['fname']); ?></td>
                                                <td><?php echo htmlspecialchars($student['course']); ?> - <?php echo htmlspecialchars($student['year']); ?></td>
                                            </tr>  
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3">No students assigned to this instructor.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                </div> <!-- Closing card-body -->
            </div> <!-- Closing card -->
        </div> <!-- Closing col-12 -->
    </section>
</main>

<?php include_once "../templates/footer.php"; ?>
