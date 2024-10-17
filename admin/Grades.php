<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/Grades-con.php"; ?>

<main id="main" class="main">

    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Student Grades Records</h1>
    </div>
    <!-- End Page Title -->


    <div class="container">
        <!-- Start Search bar -->
        <div class="card">
            <div class="card-body">
                <form method="POST" action="" class="row g-3">
                    <div class="col-md-6 form-group">
                        <label for="user_name" class="form-label">Student ID:</label>
                        <select name="user_name" id="user_name" class="form-control" required>
                            <option value="">Select Student ID</option>
                           <?php
                                // Database connection
                                $conn = new PDO('mysql:host=localhost;dbname=schooldb', 'root', '');

                                // Fetch user_name, fname, lname from tbl_students
                                $stmt = $conn->prepare("SELECT user_name, fname, lname FROM tbl_students");
                                $stmt->execute();
                                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                // Loop through the student names and populate the dropdown
                                foreach ($students as $student) {
                                    $selected = (isset($_POST['user_name']) && $_POST['user_name'] == $student['user_name']) ? 'selected' : '';
                                    // Display user_name with fname and lname
                                    echo "<option value='" . htmlspecialchars($student['user_name']) . "' $selected>" 
                                            . htmlspecialchars($student['user_name']) . " --- " 
                                            . htmlspecialchars($student['lname']) . ", " 
                                            . htmlspecialchars($student['fname']) 
                                        . "</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="year" class="form-label">Year:</label>
                        <select name="year" id="year" class="form-control" disabled>
                            <option value="">All Years</option>
                            <?php foreach ($years as $year): ?>
                                <option value="<?php echo htmlspecialchars($year); ?>" <?php echo isset($_POST['year']) && $_POST['year'] == $year ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($year); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="semester" class="form-label">Semester:</label>
                        <select name="semester" id="semester" class="form-control" disabled>
                            <option value="">All Semesters</option>
                            <?php foreach ($semesters as $semester): ?>
                                <option value="<?php echo htmlspecialchars($semester); ?>" <?php echo isset($_POST['semester']) && $_POST['semester'] == $semester ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($semester); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group align-self-end">
                        <button type="submit" name="search" class="btn btn-primary">
                            <i class="bx bx-search-alt"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSearchForm()">
                            <i class="bx bx-eraser"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Search bar -->

        <!-- Start display result -->
        <?php if ($studentInfo): ?>
            <div class="gradeResult">
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-title" style="font-size: 16px; line-height: 1.6; color: #333;">
                            <strong style="margin-right: 200px;">
                                <?php echo htmlspecialchars($studentInfo['lname']); ?>,
                                <?php echo htmlspecialchars($studentInfo['fname']); ?>
                            </strong>
                            <strong style="margin-right: 200px;">
                                <?php echo htmlspecialchars($studentInfo['course']); ?> - <?php echo htmlspecialchars($studentInfo['year']); ?>
                            </strong> <br>
                            <strong style="margin-right: 240px;">
                                <?php echo htmlspecialchars($studentInfo['user_name']); ?>
                            </strong>
                            <strong>
                                Semester: <span><?php echo htmlspecialchars($studentInfo['semester']); ?></span>
                            </strong>
                        </p>

                        <?php if (!empty($grades)): ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Subject Code</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Units</th>
                                        <th scope="col">Prelim</th>
                                        <th scope="col">Midterm</th>
                                        <th scope="col">Pre-Final</th>
                                        <th scope="col">Final</th>
                                        <th scope="col">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (is_array($grades) && count($grades) > 0):
                                        $grades_by_subject = [];

                                        // Organize grades by subject and term
                                        foreach ($grades as $row) {
                                            if (isset($row['term']) && isset($row['grade'])) {
                                                $grades_by_subject[$row['code']]['description'] = $row['description'];
                                                $grades_by_subject[$row['code']]['unit'] = $row['unit'];
                                                $grades_by_subject[$row['code']][$row['term']] = $row['grade'];
                                            }
                                        }

                                        // Display the organized grades
                                        foreach ($grades_by_subject as $subject_code => $subject_grades): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($subject_code); ?></td>
                                                <td><?php echo htmlspecialchars($subject_grades['description']); ?></td>
                                                <td><?php echo htmlspecialchars($subject_grades['unit']); ?></td>
                                                <td><?php echo isset($subject_grades['Prelim']) ? htmlspecialchars($subject_grades['Prelim']) : '-'; ?></td>
                                                <td><?php echo isset($subject_grades['Midterm']) ? htmlspecialchars($subject_grades['Midterm']) : '-'; ?></td>
                                                <td><?php echo isset($subject_grades['Pre-Final']) ? htmlspecialchars($subject_grades['Pre-Final']) : '-'; ?></td>
                                                <td><?php echo isset($subject_grades['Final']) ? htmlspecialchars($subject_grades['Final']) : '-'; ?></td>
                                                <td>
                                                    <?php
                                                    $total_grade = 0;
                                                    $grade_count = 0;

                                                    foreach (['Prelim', 'Midterm', 'Pre-Final', 'Final'] as $term) {
                                                        if (isset($subject_grades[$term])) {
                                                            $total_grade += $subject_grades[$term];
                                                            $grade_count++;
                                                        }
                                                    }

                                                    if ($grade_count > 0) {
                                                        $final_grade = $total_grade / $grade_count;
                                                        echo $final_grade <= 3.0 ? 'PASSED' : 'FAILED';
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach;
                                    else: ?>
                                        <tr>
                                            <td colspan="8" class="no-results">No grades found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="no-results">No grades found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php elseif (isset($_POST['search'])): ?>
            <p class="no-results">No student found.</p>
        <?php endif; ?>
        <!-- End display result -->
    </div>


</main>

<?php include_once "../templates/footer.php"; ?>