<?php include_once "../templates/header2.php"; ?>
<?php include_once "../PHP/class-assigned-con.php" ?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Student Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../admin/studentRecords.php">Classes</a></li>
                <li class="breadcrumb-item active">Enrolled</li>
            </ol>
        </nav>
    </div>
    <section class="section dashboard">
        <div class="col-12">
            <div class="card recent-sales overflow-auto">
                <!-- Filter Section -->
                <div class="filter">
                    <form method="GET" action="">
                        <input type="hidden" name="instructor_id" value="<?php echo htmlspecialchars($instructor_id); ?>">
                        <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($subject_id); ?>">
                        <select name="paymentPeriod" onchange="this.form.submit()" class="form-select">
                            <option value="">Select Payment Period</option>
                            <option value="Prelim" <?php echo $paymentPeriod == 'Prelim' ? 'selected' : ''; ?>>Prelim</option>
                            <option value="Midterm" <?php echo $paymentPeriod == 'Midterm' ? 'selected' : ''; ?>>Midterm</option>
                            <option value="Pre-final" <?php echo $paymentPeriod == 'Pre-final' ? 'selected' : ''; ?>>Pre-final</option>
                            <option value="Final" <?php echo $paymentPeriod == 'Final' ? 'selected' : ''; ?>>Final</option>
                        </select>
                    </form>
                </div>

                <div class="card-body">
                   <h5 class="card-title">Class Records <span>| Academic Year: <?php echo htmlspecialchars($student['sy']); ?></span> <span>| Semester: <?php echo htmlspecialchars($student['semester']); ?></span></h5>
                    <!-- Students Table -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Student ID</th>
                                <th scope="col">Student Name</th>
                                <th scope="col">Course & Year</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($grouped_students)): ?>
                                <?php foreach ($grouped_students as $subject_id => $students_by_course_year): ?>
                                    <?php foreach ($students_by_course_year as $course_year => $students_list): ?>
                                        <?php foreach ($students_list as $student): ?>
                                            <tr>
                                                <td>
                                                    <a href="student_profile.php?user_id=<?php echo htmlspecialchars($student['user_id']); ?>">
                                                        <?php echo htmlspecialchars($student['user_name']); ?>
                                                    </a>
                                                </td>
                                                <td><?php echo htmlspecialchars($student['lname']); ?>, <?php echo htmlspecialchars($student['fname']); ?></td>
                                                <td><?php echo htmlspecialchars($student['course']); ?> - <?php echo htmlspecialchars($student['year']); ?></td>
                                                <td>
                                                    <?php if (!empty($paymentPeriod)): ?>
                                                        <?php if ($student['payment_status'] === 'PAID'): ?>
                                                            <span class="badge badge-success">Paid</span>
                                                        <?php elseif ($student['payment_status'] === 'PENDING'): ?>
                                                            <span class="badge badge-warning">Pending</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-danger">Overdue</span>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>

                                                <td>
                                                    <!-- Button to trigger the modal for grade insertion -->
                                                    <button type="button" class="btn btn-sm btn-warning ri-add-box-fill" data-bs-toggle="modal" data-bs-target="#insertGrade<?php echo htmlspecialchars($student['user_id']); ?>"></button>

                                                    <!-- Form to delete the user -->
                                                    <form method="POST" action="../admin/upload/delete-students.php" style="display:inline;">
                                                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($student['user_id']); ?>">
                                                        <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($subject_id); ?>">
                                                        <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            <?php include('modals/insert-grade.php'); ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-danger">No students matching the selected payment period.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
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
      .badge-warning {
      background-color: orange;
      color: white;
      padding: 5px 10px;
      border-radius: 20px;
      display: inline-block;
    }
    .text-danger{
        text-align: center;
        font-style: italic;
    }
</style>
<?php include_once "../templates/footer.php"; ?>
