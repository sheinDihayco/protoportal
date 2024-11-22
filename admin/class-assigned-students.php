<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/class-assigned-con.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Student Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../admin/student-classes.php">Classes</a></li>
                <li class="breadcrumb-item active">Enrolled</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="col-12">
            <div class="card mt-4">
                <div class="filter">
                    <!-- Filter options -->
                </div>
                <div class="card-body">
                    <h5 class="card-title">Class Records <span>| Currently Enrolled</span></h5>
                        <table class="table table-striped">
                    <thead>
                        <tr> 
                            <th scope="col">Student ID</th>
                            <th scope="col">Student Name</th>
                            <th scope="col">Course & Year</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grouped_students)): ?>
                            <?php foreach ($grouped_students as $subject_id => $students_by_course_year): ?>
                                <?php foreach ($students_by_course_year as $course_year => $students_list): ?>
                                    <?php foreach ($students_list as $student): ?>
                                        <tr>
                                            <td>
                                               <?php echo htmlspecialchars($student['user_name']); ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($student['lname']); ?>, <?php echo htmlspecialchars($student['fname']); ?></td>
                                            <td><?php echo htmlspecialchars($student['course']); ?> - <?php echo htmlspecialchars($student['year']); ?></td>
                                            <td>
                                                <?php if (htmlspecialchars($student['status']) == 'Enrolled'): ?>
                                                    <span class="badge badge-success">Enrolled</span>
                                                <?php elseif (htmlspecialchars($student['status']) == 'Unenrolled'): ?>
                                                    <span class="badge badge-danger">Unenrolled</span>
                                                <?php else: ?>
                                                    <span class="badge badge-secondary">Not Available</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>  
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No students assigned to this subject.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                </div> <!-- Closing card-body -->
            </div> <!-- Closing card -->
        </div> <!-- Closing col-12 -->
    </section>
</main>
<style>
    .badge-success {
        background-color: green;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-danger {
        background-color: red;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }

    .badge-secondary {
        background-color: gray;
        color: white;
        padding: 5px 10px;
        border-radius: 20px;
        display: inline-block;
    }

</style>
<?php include_once "../templates/footer.php"; ?>
