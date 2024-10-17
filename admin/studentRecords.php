<?php include_once "../templates/header2.php"; ?>
<?php include_once "../PHP/studentRecords-con.php"; ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Student Records</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
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
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($grouped_students)): ?>
                            <?php foreach ($grouped_students as $course_year => $students_list): ?>
                                <tr>
                                    <td colspan="4" class="table-primary">
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
                                        <td>
                                            <!-- Button to trigger the modal for grade insertion -->
                                            <button type="button" class="btn btn-sm btn-warning ri-add-box-fill" data-bs-toggle="modal" data-bs-target="#insertGrade<?php echo htmlspecialchars($student['user_id']); ?>"></button>

                                            <!-- Form to delete the user -->
                                            <form method="POST" action="../admin/upload/delete-students.php" onsubmit="return confirmDelete(this);" style="display:inline;">
                                                <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($student['user_id']); ?>">
                                                <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php include('modals/insert-grade.php'); ?>
                                <?php endforeach; ?>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No students assigned to this instructor.</td>
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
