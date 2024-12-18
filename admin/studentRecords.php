<?php include_once "../templates/header2.php"; ?>
<?php include_once "../PHP/studentRecords-con.php"; ?>

<main id="main" class="main">

    <div class="pagetitle">
    <h1>Class Records</h1>
    <nav>
    <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="index2.php">Home</a></li>
    <li class="breadcrumb-item active">Enrolled</li>
    </ol>
    </nav>
    </div>

    <section class="section dashboard">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Classes <span>| Enrolled </span></h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Subject Code</th>
                                        <th scope="col">Subject Description</th>
                                        <th scope="col">View Class</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($instructors)): ?>
                                        <?php
                                        // Initialize an array to keep track of displayed instructor-subject combinations
                                        $displayed = [];
                                        ?>
                                        <?php foreach ($instructors as $instructor_id => $instructor): ?>
                                            <?php if ($instructor_id == $userid): // Only show classes of the logged-in instructor ?>
                                                <?php foreach ($instructor['courses'] as $course => $course_data): ?>
                                                    <?php foreach ($course_data['subjects'] as $subject_id => $subject): ?>
                                                        <?php
                                                        // Create a unique key for the instructor-subject combination
                                                        $unique_key = $instructor['name'] . '|' . $subject['code'];

                                                        // Check if this combination has already been displayed
                                                        if (!in_array($unique_key, $displayed)) {
                                                            // If not, display it and add it to the displayed array
                                                            $displayed[] = $unique_key; // Mark as displayed
                                                            ?>
                                                            <tr>
                                                                <td><?php echo htmlspecialchars($subject['code']); ?></td>
                                                                <td><?php echo htmlspecialchars($subject['description']); ?></td>
                                                                <td>
                                                                    <a href="class-assigned-instructor.php?instructor_id=<?php echo htmlspecialchars($instructor_id); ?>&subject_id=<?php echo htmlspecialchars($subject_id); ?>" class="btn btn-success btn-sm">
                                                                        <i class="ri-arrow-right-circle-fill"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
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
