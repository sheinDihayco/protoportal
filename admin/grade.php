<?php include_once "../templates/header2.php"; ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Student Grade Records</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index2.php">Home</a></li>
        <li class="breadcrumb-item active">Grades</li>
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
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Student Name</th>
                                        <th scope="col">Subject Code</th>
                                        <th scope="col">Subject Description</th>
                                        <th scope="col">Prelim</th>
                                        <th scope="col">Midterm</th>
                                        <th scope="col">Pre-final</th>
                                        <th scope="col">Final</th>
                                        <th scope="col">Final Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Database connection
                                    try {
                                        $pdo = new PDO('mysql:host=localhost;dbname=schooldb', 'root', '');
                                        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                        $userid = $_SESSION['login']; // Assuming this is the instructor's user ID
                                        
                                        // Query to fetch grades for the logged-in instructor
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
                                            ORDER BY student_name, subject_code, term"; 

                                        $stmt = $pdo->prepare($sql);
                                        $stmt->bindParam(':instructor_id', $userid, PDO::PARAM_INT);
                                        $stmt->execute();

                                        // Debugging: Check if any rows are returned
                                        if ($stmt->rowCount() === 0) {
                                            echo "<tr><td colspan='8'>No grades found for this instructor.</td></tr>";
                                        } else {
                                            $grades_by_student = []; // Initialize an array to hold organized grades

                                            // Fetch data and organize it by student, subject, and term
                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                                // Debugging: Output fetched row data
                                                echo "<!-- Fetched Row: " . json_encode($row) . " -->"; // This will output the fetched row for debugging

                                                $student_name = $row['student_name'];
                                                $subject_code = $row['subject_code'];

                                                // Organize grades by student and subject
                                                if (!isset($grades_by_student[$student_name][$subject_code])) {
                                                    $grades_by_student[$student_name][$subject_code] = [
                                                        'description' => $row['description'],
                                                        'grades' => ['Prelim' => null, 'Midterm' => null, 'Pre-final' => null, 'Final' => null], // Initialize all grades to null
                                                    ];
                                                }
                                                // Assign grade to the correct term if it exists
                                                if (isset($row['term']) && isset($row['grade'])) {
                                                    $grades_by_student[$student_name][$subject_code]['grades'][$row['term']] = $row['grade'];
                                                }
                                            }

                                            // Display the organized grades
                                            foreach ($grades_by_student as $student_name => $subjects): 
                                                foreach ($subjects as $subject_code => $subject_info): ?>
                                                    <tr>
                                                        <td><?php echo htmlspecialchars($student_name); ?></td>
                                                        <td><?php echo htmlspecialchars($subject_code); ?></td>
                                                        <td><?php echo htmlspecialchars($subject_info['description']); ?></td>
                                                        <td><?php echo isset($subject_info['grades']['Prelim']) ? htmlspecialchars($subject_info['grades']['Prelim']) : '-'; ?></td>
                                                        <td><?php echo isset($subject_info['grades']['Midterm']) ? htmlspecialchars($subject_info['grades']['Midterm']) : '-'; ?></td>
                                                        <td><?php echo isset($subject_info['grades']['Pre-final']) ? htmlspecialchars($subject_info['grades']['Pre-final']) : '-'; ?></td>
                                                        <td><?php echo isset($subject_info['grades']['Final']) ? htmlspecialchars($subject_info['grades']['Final']) : '-'; ?></td>
                                                        <td>
                                                            <?php
                                                            $total_grade = 0;
                                                            $grade_count = 0;

                                                            // Calculate final grade and determine status
                                                            foreach (['Prelim', 'Midterm', 'Pre-final', 'Final'] as $term) {
                                                                if (isset($subject_info['grades'][$term]) && $subject_info['grades'][$term] !== null) {
                                                                    $total_grade += $subject_info['grades'][$term];
                                                                    $grade_count++;
                                                                }
                                                            }

                                                            // Calculate and display final status
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
                                            endforeach; 
                                        }
                                    } catch (PDOException $e) {
                                        echo "Database error: " . $e->getMessage();
                                    }
                                    ?>
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