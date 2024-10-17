<?php include_once "../templates/header2.php";?>
<?php include_once "../PHP/index2-php-con.php"; ?>
<?php include_once "../PHP/studentRecords-con.php"; ?>

<main id="main" class="main">
    <section class="section dashboard">
        <div class="row">

            <!-- Student Count Card -->
            <div class="col-xxl-6 col-md-6">
                <div class="card info-card sales-card">
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
                        <h5 class="card-title">Student <span>| Count</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6> <?php echo htmlspecialchars($studentCount); ?></p>
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- End Student Count Card -->

            <!-- Start Event -->
            <div class="col-xxl-6 col-md-6">
                <div class="card info-card sales-card">
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
                        <h5 class="card-title">Today's Event</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-day"></i>
                            </div>
                            <div class="ps-3">
                                <?php if ($todaysEvent) : ?>
                                    <h6 style="font-size:12px"><?php echo htmlspecialchars($todaysEvent['start_date']); ?></h6>
                                    <li class="list-group-item d-flex justify-content-between align-items-start">
                                        <div style="flex-grow: 1;">
                                            <h6 class="card-title"><?php echo htmlspecialchars($todaysEvent['title']); ?></h6>
                                            <!--<p>Description: <?php echo htmlspecialchars($todaysEvent['description']); ?></p>-->
                                        </div>
                                    </li>
                                <?php else : ?>
                                    <p>No events scheduled for today.</p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Event -->

        </div>
        <div class="row">

             <!-- Student Table -->
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

        </div>

    </section>

    </section>

</main><!-- End #main -->

<?php include_once "../templates/footer.php"; ?>