<?php include_once "../templates/header2.php"; ?>
<?php include_once "includes/connect.php"; ?>

<main id="main" class="main">
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Student Grade Records</h1>
    </div>
    <!-- End Page Title -->

    <div class="container">
        <!-- Start Search bar -->
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Search Grades <span>| Enrolled</span></h5>
                <!-- Search Form for Course and Year -->
                <form method="POST" action="" class="row g-3 align-items-end">
                    <!-- Course Selection -->
                    <div class="col-md-4 form-group">
                        <select class="form-select" id="course" name="course" required onchange="toggleFields()">
                            <option value="" <?= !isset($_POST['course']) ? 'selected' : '' ?>>Select Course</option>
                            <?php
                            // Open database connection
                            $database = new Connection();
                            $db = $database->open();

                            try {
                                $sql = "SELECT DISTINCT course_description FROM tbl_course";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();

                                foreach ($stmt as $course) {
                                    $selected = (isset($_POST['course']) && $_POST['course'] == $course['course_description']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($course['course_description']) . '" ' . $selected . '>' . htmlspecialchars($course['course_description']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "<option value='' disabled>Error fetching courses</option>";
                            }

                            // Close database connection
                            $database->close();
                            ?>
                        </select>
                    </div>

                    <!-- Year Selection -->
                    <div class="col-md-4 form-group">
                        <select class="form-select" name="year" id="year" <?= empty($_POST['course']) ? 'disabled' : '' ?> required>
                            <option value="" <?= !isset($_POST['year']) ? 'selected' : '' ?>>Select Year</option>
                            <?php
                            $years = [1, 2, 3, 4, 11, 12];
                            foreach ($years as $yr) {
                                $selected = (isset($_POST['year']) && $_POST['year'] == $yr) ? 'selected' : '';
                                echo '<option value="' . $yr . '" ' . $selected . '>' . $yr . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Search and Clear Buttons -->
                    <div class="col-md-4 d-flex">
                        <button type="submit" name="search" class="btn btn-primary">
                            <i class="bx bx-search-alt"></i> Search
                        </button>
                        <button type="button" onclick="clearSearchForm()" class="btn btn-secondary ms-2">
                            <i class="bx bx-eraser"></i> Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <!-- End Search bar -->

        <!-- Start Display Result -->
        <?php if (isset($_POST['search'])): ?>
            <div class="gradeResult">
                <div class="card mt-4">
                    <div class="card-body">
                        <p class="card-title">
                            <strong>Course:</strong> <?= htmlspecialchars($_POST['course']); ?><br>
                            <strong>Year Level:</strong> <?= htmlspecialchars($_POST['year']); ?>
                        </p>

                        <!-- Displaying the Table of Grades Based on Search -->
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Student Name</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Prelim</th>
                                    <th scope="col">Midterm</th>
                                    <th scope="col">Pre-final</th>
                                    <th scope="col">Final</th>
                                    <th scope="col">Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if (isset($_POST['search'])) {
                                    // Get course and year from the form
                                    $course_id = $_POST['course'];
                                    $year = $_POST['year'];
                                    $userid = $_SESSION['login']; // Assuming this is the instructor's user ID

                                    try {
                                        // Query to fetch grades for the instructor, filtered by course and year
                                        $sql = "
                                            SELECT 
                                            CONCAT(s.lname, ', ', s.fname) AS student_name,
                                            sub.code AS subject_code,
                                            sub.description AS description,
                                            g.term,
                                            g.grade
                                            FROM tbl_grades g
                                            INNER JOIN tbl_students s ON g.user_id = s.user_id
                                            INNER JOIN tbl_users u ON g.instructor_id = u.user_id
                                            INNER JOIN tbl_subjects sub ON g.id = sub.id
                                            WHERE g.instructor_id = :instructor_id
                                            AND s.course = :course_id
                                            AND s.year = :year
                                            ORDER BY student_name, subject_code, term
                                        ";

                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam(':instructor_id', $userid, PDO::PARAM_INT);
                                        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);
                                        $stmt->bindParam(':year', $year, PDO::PARAM_INT);
                                        $stmt->execute();

                                        if ($stmt->rowCount() === 0) {
                                            echo "<tr><td colspan='8' class='text-danger'>No grades found.</td></tr>";
                                        } else {
                                            $grades_by_student = [];

                                            // Organize grades by student and subject
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                $student_name = $row['student_name'];
                                                $subject_code = $row['subject_code'];

                                                if (!isset($grades_by_student[$student_name][$subject_code])) {
                                                    $grades_by_student[$student_name][$subject_code] = [
                                                        'description' => $row['description'],
                                                        'grades' => ['Prelim' => null, 'Midterm' => null, 'Pre-final' => null, 'Final' => null],
                                                    ];
                                                }

                                                if (isset($row['term']) && isset($row['grade'])) {
                                                    $grades_by_student[$student_name][$subject_code]['grades'][$row['term']] = $row['grade'];
                                                }
                                            }

                                            // Display the organized grades
                                            foreach ($grades_by_student as $student_name => $subjects) {
                                                foreach ($subjects as $subject_code => $subject_info) {
                                                    echo "<tr>
                                                        <td>" . htmlspecialchars($student_name) . "</td>
                                                        <td>" . htmlspecialchars($subject_code) . "</td>
                                                        <td>" . htmlspecialchars($subject_info['description']) . "</td>
                                                        <td>" . (isset($subject_info['grades']['Prelim']) ? htmlspecialchars($subject_info['grades']['Prelim']) : '-') . "</td>
                                                        <td>" . (isset($subject_info['grades']['Midterm']) ? htmlspecialchars($subject_info['grades']['Midterm']) : '-') . "</td>
                                                        <td>" . (isset($subject_info['grades']['Pre-final']) ? htmlspecialchars($subject_info['grades']['Pre-final']) : '-') . "</td>
                                                        <td>" . (isset($subject_info['grades']['Final']) ? htmlspecialchars($subject_info['grades']['Final']) : '-') . "</td>
                                                        <td>";
                                                    $total_grade = 0;
                                                    $grade_count = 0;

                                                    foreach (['Prelim', 'Midterm', 'Pre-final', 'Final'] as $term) {
                                                        if (isset($subject_info['grades'][$term]) && $subject_info['grades'][$term] !== null) {
                                                            $total_grade += $subject_info['grades'][$term];
                                                            $grade_count++;
                                                        }
                                                    }

                                                    if ($grade_count > 0) {
                                                        $final_grade = $total_grade / $grade_count;
                                                        if ($final_grade <= 3.0) {
                                                            echo '<span class="badge badge-success">PASSED</span>';
                                                        } else {
                                                            echo '<span class="badge badge-danger">FAILED</span>';
                                                        }
                                                    } else {
                                                        echo '<span class="badge badge-secondary">No Grade</span>';
                                                    }
                                                    echo "</td></tr>";
                                                }
                                            }
                                        }
                                    } catch (PDOException $e) {
                                        echo "Database error: " . $e->getMessage();
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <!-- End Display Result -->
    </div>
</main>

<script>
    // JavaScript to Manage Input Fields and Clear Functionality
    function toggleFields() {
        const courseField = document.getElementById('course');
        const yearField = document.getElementById('year');

        yearField.disabled = !courseField.value;
    }

    function clearSearchForm() {
        document.getElementById('course').value = '';
        document.getElementById('year').value = '';

        // Reset field states
        document.getElementById('course').disabled = false;
        document.getElementById('year').disabled = true;

        // Hide the table by setting its display style to 'none'
        const resultTable = document.querySelector(".gradeResult");
        if (resultTable) {
            resultTable.style.display = 'none';
        }
    }
</script>
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
  
    .card-title {
        font-size: 16px;
        line-height: 1.6;
        color: #333;
    }

    .info-row {
        display: flex;
        justify-content: space-between;  /* Spaces the items between left and right */
        margin-bottom: 8px; /* Space between rows */
    }

    .info-item {
        display: flex;
        align-items: center;
        flex-basis: 45%; /* Make sure each item takes up equal space */
    }

    .info-item strong {
        margin-right: 10px; /* Space between label and value */
    }

    /* Optional: Responsive design for smaller screens */
    @media (max-width: 768px) {
        .info-row {
            flex-direction: column; /* Stack the rows vertically */
            align-items: flex-start;
        }

        .info-item {
            flex-basis: 100%;  /* Make each item take the full width */
        }
    }
    .text-danger {
        font-style: italic;
        text-align: center;
    }

</style>

<?php include_once "../templates/footer.php"; ?>
