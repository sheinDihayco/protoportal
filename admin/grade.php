<?php include_once "../templates/header2.php"; ?>
<?php include_once "../PHP/grade-con.php"; ?>

<main id="main" class="main">

    <!-- Start Page Title -->
    <div class="pagetitle">
      <h1>Student Grades Records</h1>
    </div>
    <!-- End Page Title -->

    <!-- Start Search bar -->
    <div class="card">
        <div class="card-body">
            <form method="POST" action="" class="row g-3">
                <!-- Student Selection -->
              <div class="col-md-6 form-group">
        <label for="user_name" class="form-label">Student ID:</label>
        <select name="user_name" id="user_name" class="form-select" required>
            <option value="" selected>Select Student ID</option>
            <?php
            try {
                // Get the logged-in instructor's ID (assuming it's stored in $userid)
                $instructor_id = $userid;

                // Fetch students assigned to the instructor
                $sql = "SELECT s.user_name, s.lname, s.fname 
                        FROM tbl_students s
                        INNER JOIN tbl_student_instructors si ON s.user_id = si.student_id
                        WHERE si.instructor_id = :instructor_id
                        ORDER BY s.lname, s.fname";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
                $stmt->execute();

                // Fetch the students
                $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop through the students and display them in the dropdown
                foreach ($students as $student) {
                    $fullName = htmlspecialchars($student['lname']) . ', ' . htmlspecialchars($student['fname']);
                    $selected = (isset($_POST['user_name']) && $_POST['user_name'] == $student['user_name']) ? 'selected' : '';
                    echo '<option value="' . htmlspecialchars($student['user_name']) . '" ' . $selected . '>' . $fullName . ' (' . htmlspecialchars($student['user_name']) . ')</option>';
                }
            } catch (PDOException $e) {
                echo "<option value='' disabled>Error fetching students</option>";
            }
            ?>
        </select>
    </div>
   <!-- Subject Code Selection based on user_id and year level -->
    <div class="col-md-4 form-group">
        <label for="subject_code" class="form-label">Subject Code:</label>
        <select class="form-select" id="subject_code" name="subject_code">
            <option value="" selected>Select Subject Code</option>
            <?php
                try {
                    // Assuming you have the student's user_id stored in a session or as a form input
                    $user_id = $_SESSION['user_id']; // Or retrieve from a form if needed

                    // Step 1: Fetch the student's year level and course based on the user_id
                    $yearLevelStmt = $pdo->prepare("SELECT year, course FROM tbl_students WHERE user_id = :user_id");
                    $yearLevelStmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $yearLevelStmt->execute();
                    $student = $yearLevelStmt->fetch(PDO::FETCH_ASSOC);

                    if ($student) {
                        $year_level = $student['year'];
                        $course = $student['course'];

                        // Step 2: Fetch the subject codes and descriptions based on the student's year level and course
                        $subjectStmt = $pdo->prepare("SELECT DISTINCT code, description FROM tbl_subjects WHERE year = :year AND course = :course ORDER BY code");
                        $subjectStmt->bindParam(':year', $year_level, PDO::PARAM_INT);
                        $subjectStmt->bindParam(':course', $course, PDO::PARAM_STR); // Assuming 'course' is a string
                        $subjectStmt->execute();

                        // Loop through the subjects and display both code and description in the dropdown
                        foreach ($subjectStmt as $subject) {
                            $selected = (isset($_POST['subject_code']) && $_POST['subject_code'] == $subject['code']) ? 'selected' : '';
                            echo '<option value="' . htmlspecialchars($subject['code']) . '" ' . $selected . '>' 
                                . htmlspecialchars($subject['code']) . ' - ' . htmlspecialchars($subject['description']) 
                                . '</option>';
                        }
                    } else {
                        echo "<option value='' disabled>Student year level not found</option>";
                    }
                } catch (PDOException $e) {
                    echo "<option value='' disabled>Error fetching subjects</option>";
                }
            ?>
        </select>
    </div>


    <!-- Search and Clear Buttons -->
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
                <?php echo htmlspecialchars($studentInfo['course']); ?>
              </strong> <br>
              <strong style="margin-right: 240px;">
                <?php echo htmlspecialchars($studentInfo['user_name']); ?>
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
</main>

<?php include_once "../templates/footer.php"; ?>