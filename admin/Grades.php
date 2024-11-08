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
        <div class="card mt-4">
            <div class="card-body">
               <h5 class="card-title">Search grades <span>| Recorded</span></h5>
                <!-- Improved Search Form -->
                <form method="POST" action="" class="row g-3 align-items-end">
                    <!-- Student ID Input -->
                    <div class="col-md-4">
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Enter Student ID (e.g., MIIT-0000-000)" required oninput="toggleFields()">
                    </div>

                    <!-- Year Selector -->
                    <div class="col-md-2">
                        <select name="year" id="year" class="form-control" disabled>
                            <option value="">All Years</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>

                    <!-- Semester Selector -->
                    <div class="col-md-2">
                        <select name="semester" id="semester" class="form-control" disabled>
                            <option value="">All Semesters</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>

                    <!-- Search and Clear Buttons -->
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" name="search" class="btn btn-primary" title="Search">
                            <i class="bx bx-search-alt"></i> Search
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSearchForm()" title="Clear Search">
                            <i class="bx bx-eraser"></i> Clear
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

<script>
    // JavaScript to Manage Input Fields and Clear Functionality
    function toggleFields() {
        // Enable Year and Semester fields when Student ID is filled
        const studentId = document.getElementById("user_name").value;
        const yearField = document.getElementById("year");
        const semesterField = document.getElementById("semester");

        if (studentId.trim() !== "") {
            yearField.disabled = false;
            semesterField.disabled = false;
        } else {
            yearField.disabled = true;
            semesterField.disabled = true;
        }
    }

    function clearSearchForm() {
        // Clear all input fields and reset form
        document.getElementById("user_name").value = '';
        document.getElementById("year").selectedIndex = 0;
        document.getElementById("semester").selectedIndex = 0;

        // Disable Year and Semester fields
        document.getElementById("year").disabled = true;
        document.getElementById("semester").disabled = true;

        // Hide the table by setting its display style to 'none'
        const resultTable = document.querySelector(".gradeResult");
        if (resultTable) {
            resultTable.style.display = 'none';
        }
    }

</script>

<?php include_once "../templates/footer.php"; ?>