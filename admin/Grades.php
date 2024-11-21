<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/Grades-con.php"; ?>

<main id="main" class="main">

    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Student Grades Records</h1>
    </div>
    <!-- End Page Title -->

    <div class="container">
        <!-- Start Search Bar -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Search Grades <span>| Recorded</span></h5>
                <form id="searchGradesForm" action="" method="POST" class="row g-3">
                    <!-- Student ID Input -->
                    <div class="col-md-4 form-group">
                        <input 
                            type="text" 
                            name="user_name" 
                            id="user_name" 
                            class="form-control" 
                            placeholder="Enter Student ID (e.g., MIIT-0000-000)" 
                            required 
                            value="<?= isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : '' ?>" 
                            oninput="toggleFields()">
                    </div>

                    <!-- Year Selector -->
                    <div class="col-md-2 form-group">
                        <select 
                            class="form-select" 
                            id="year" 
                            name="year" 
                            disabled 
                            onchange="toggleFields()">
                            <option value="" selected>Select Year</option>
                            <?php
                            $years = [1, 2, 3, 4, 11, 12];
                            foreach ($years as $yr) {
                                $selected = isset($_POST['year']) && $_POST['year'] == $yr ? 'selected' : '';
                                echo "<option value=\"$yr\" $selected>$yr</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Semester Selector -->
                    <div class="col-md-2 form-group">
                        <select 
                            class="form-select" 
                            id="semester" 
                            name="semester" 
                            disabled>
                            <option value="" selected>Select Semester</option>
                            <?php
                            $semesters = [1, 2];
                            foreach ($semesters as $sem) {
                                $selected = isset($_POST['semester']) && $_POST['semester'] == $sem ? 'selected' : '';
                                echo "<option value=\"$sem\" $selected>$sem</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-3 form-group align-self-end">
                        <button 
                            type="submit" 
                            name="search" 
                            class="btn btn-primary" 
                            title="Search">
                            <i class="bx bx-search-alt"></i> Search
                        </button>
                        <button 
                            type="button" 
                            class="btn btn-secondary" 
                            onclick="clearSearchForm()" 
                            title="Clear Search">
                            <i class="bx bx-eraser"></i> Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Search Bar -->

        <!-- Start display result -->
        <?php if ($studentInfo): ?>
            <div class="gradeResult">
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-title">
                            <div class="info-row">
                                <div class="info-item">
                                    <strong>Name:</strong> 
                                    <?php echo htmlspecialchars($studentInfo['lname']); ?>, 
                                    <?php echo htmlspecialchars($studentInfo['fname']); ?>
                                </div>
                                <div class="info-item">
                                    <strong>Course & Year:</strong> 
                                  <?php echo htmlspecialchars($studentInfo['course']); ?> - <?php echo htmlspecialchars($yearText[$selectedYear] ?? ''); ?>
                                </div>
                            </div>  
                            <div class="info-row">
                                <div class="info-item">
                                    <strong>School ID:</strong> 
                                    <?php echo htmlspecialchars($studentInfo['user_name']); ?>
                                </div>
                                <div class="info-item">
                                    <strong>Semester:</strong> 
                                    <?php echo htmlspecialchars($semesterText[$selectedSemester] ?? ''); ?>
                                </div>
                            </div>
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
                                            <td colspan="8" class="text-danger">No grades found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <p class="text-danger">No grades found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php elseif (isset($_POST['search'])): ?>
            <p class="no-student">No student found.</p>
        <?php endif; ?>
        <!-- End display result -->
    </div>
</main>
<script>
    // JavaScript to Manage Input Fields and Clear Functionality
    function toggleFields() {
        const studentIdField = document.getElementById('user_name');
        const yearField = document.getElementById('year');
        const semesterField = document.getElementById('semester');

        // Enable Year if Student ID is filled
        yearField.disabled = !studentIdField.value;

        // Enable Semester if Year is selected
        semesterField.disabled = !yearField.value;
    }

    function clearSearchForm() {
        document.getElementById('user_name').value = '';
        document.getElementById('year').value = '';
        document.getElementById('semester').value = '';

        // Reset field states
        document.getElementById('year').disabled = true;
        document.getElementById('semester').disabled = true;

        // Hide the table by setting its display style to 'none'
        const resultTable = document.querySelector(".gradeResult");
        if (resultTable) {
            resultTable.style.display = 'none';
        }
    }
</script>
<style>
    .text-danger {
        text-align: center;
        font-style: italic;
    }

</style>
<?php include_once "../templates/footer.php"; ?>
