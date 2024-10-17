<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/assign-student-instructors-con.php"; ?>

<main id="main" class="main">

    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Assigned Class to Instructor</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Students</li>
            </ol>
        </nav>
    </div>
    <!-- End Page Title -->

    <!-- Start Search Bar -->
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form id="instructorForm" action="" method="GET" class="row g-3">
                    <div class="col-md-3 form-group">
                        <label for="instructor_id" class="form-label">Instructor</label>
                        <select class="form-select" id="instructor_id" name="instructor_id"  required>
                            <option value="" selected>Select Instructor</option>
                            <?php
                            $database = new Connection();
                            $db = $database->open();

                            try {
                                $sql = "SELECT * FROM tbl_users WHERE user_role = 'teacher'";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();

                                foreach ($stmt as $user) {
                                    echo '<option value="' . htmlspecialchars($user['user_id']) . '"' . ($instructor_id == $user['user_id'] ? ' selected' : '') . '>' . htmlspecialchars($user['user_lname']) . ', ' . htmlspecialchars($user['user_fname']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "<option value='' disabled>Error fetching instructors</option>";
                            }

                            $database->close();
                            ?>
                        </select>
                    </div>

                    <!--<div class="col-md-3 form-group">
                        <label for="subject_id" class="form-label">Subject</label>
                        <select class="form-select" id="subject_id" name="subject_id" required>
                            <option value="" selected>Select Subject</option>
                            <?php
                            $database = new Connection();
                            $db = $database->open();

                            try {
                                $sql = "SELECT DISTINCT description FROM tbl_subjects ORDER BY description ASC";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();

                                foreach ($stmt as $subject) {
                                    echo '<option value="' . htmlspecialchars($subject['description']) . '">' . htmlspecialchars($subject['description']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "<option value='' disabled>Error fetching subjects</option>";
                            }

                            $database->close();
                            ?>
                        </select>
                    </div>-->

                    <div class="col-md-3 form-group">
                        <label for="course" class="form-label">Course</label>
                        <select class="form-select" id="course" name="course"  required>
                            <option value="" selected>Select</option>
                            <?php
                            $database = new Connection();
                            $db = $database->open();

                            try {
                                // Select distinct course descriptions
                                $sql = "SELECT DISTINCT course_description FROM tbl_course";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();

                                // Loop through unique course descriptions
                                foreach ($stmt as $course) {
                                    echo '<option value="' . htmlspecialchars($course['course_description']) . '">' . htmlspecialchars($course['course_description']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "<option value='' disabled>Error fetching courses</option>";
                            }

                            $database->close();
                            ?>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="year" class="form-label">Year</label>
                        <select class="form-select" id="year" name="year"  required>
                            <option value="" selected>Select</option>
                            <option value="all">All</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester"  required>
                            <option value="all" selected>All</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>
                    </div>

                    <div class="col-md-2 form-group align-self-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-search-alt"></i>
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSearchForm()">
                            <i class="bx bx-eraser"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- End Search Bar -->


    <!-- Start Student Table -->
    <?php if (!empty($instructor_id)): ?>
        <div class="studentResult">
            <form id="assignStudentsForm" action="" method="POST">
                <input type="hidden" name="instructor_id" value="<?php echo htmlspecialchars($instructor_id); ?>">
                <input type="hidden" name="subject_id" value="<?php echo htmlspecialchars($subject_id); ?>">
                <section class="section dashboard">
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">
                                        <input type="checkbox" id="selectAll" onclick="toggleSelectAll(this)">
                                    </th>
                                    <th scope="col">Student ID</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Course</th>
                                    <th scope="col">Year</th>
                                    <th scope="col">Semester</th>
                                    <th scope="col">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $database = new Connection();
                                $db = $database->open();

                                try {
                                    // Ensure $course is a string, not an array
                                    $course = isset($_GET['course']) ? $_GET['course'] : '';

                                    if (is_array($course)) {
                                        // If it's an array, handle it or convert it appropriately
                                        $course = $course[0]; // Assuming you want the first value, adjust as needed
                                    }

                                    if ($year == 'all' && $semester == 'all') {
                                        foreach ($years as $yearNumber => $yearTitle) {
                                            foreach ($semesters as $semesterNumber => $semesterTitle) {
                                                echo "<tr><td colspan='7' class='table-info text-center'><strong>$yearTitle - $semesterTitle</strong></td></tr>";

                                                $sql = "SELECT * FROM tbl_students WHERE course = :course AND year = :year AND semester = :semester";
                                                $stmt = $db->prepare($sql);
                                                $stmt->bindParam(':course', $course);
                                                $stmt->bindParam(':year', $yearNumber);
                                                $stmt->bindParam(':semester', $semesterNumber);
                                                $stmt->execute();

                                                if ($stmt->rowCount() > 0) {
                                                    foreach ($stmt as $student) {
                                                        echo "<tr>";
                                                        echo '<td><input type="checkbox" class="form-check-input student-select" name="student_ids[]" value="' . htmlspecialchars($student['user_id']) . '"></td>';
                                                        echo "<td>" . htmlspecialchars($student['user_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($student['lname']) . " " . htmlspecialchars($student['fname']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($student['course']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($student['year']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($student['semester']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($student['status']) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                    echo '<tr><td colspan="7"><hr></td></tr>'; // Horizontal line separator for semester
                                                }
                                            }
                                        }
                                    } else {
                                        $sql = "SELECT * FROM tbl_students WHERE course = :course AND year = :year AND semester = :semester";
                                        $stmt = $db->prepare($sql);
                                        $stmt->bindParam(':course', $course);
                                        $stmt->bindParam(':year', $year);
                                        $stmt->bindParam(':semester', $semester);
                                        $stmt->execute();

                                        if ($stmt->rowCount() > 0) {
                                            $currentYear = '';
                                            $currentSemester = '';
                                            foreach ($stmt as $student) {
                                                if ($student['year'] != $currentYear || $student['semester'] != $currentSemester) {
                                                    if ($currentYear !== '') {
                                                        echo '<tr><td colspan="7"><hr></td></tr>'; // Horizontal line separator for semester
                                                    }
                                                    echo "<tr><td colspan='7' class='table-info text-center'><strong>" . $years[$student['year']] . " - " . $semesters[$student['semester']] . "</strong></td></tr>";
                                                    $currentYear = $student['year'];
                                                    $currentSemester = $student['semester'];
                                                }

                                                echo "<tr>";
                                                echo '<td><input type="checkbox" class="form-check-input student-select" name="student_ids[]" value="' . htmlspecialchars($student['user_id']) . '"></td>';
                                                echo "<td>" . htmlspecialchars($student['user_name']) . "</td>";
                                                echo "<td>" . htmlspecialchars($student['lname']) . " " . htmlspecialchars($student['fname']) . "</td>";
                                                echo "<td>" . htmlspecialchars($student['course']) . "</td>";
                                                echo "<td>" . htmlspecialchars($student['year']) . "</td>";
                                                echo "<td>" . htmlspecialchars($student['semester']) . "</td>";
                                                echo "<td>" . htmlspecialchars($student['status']) . "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='7'>No students found for the selected course and year.</td></tr>";
                                        }
                                    }
                                } catch (PDOException $e) {
                                    echo "<tr><td colspan='7'>There was an error: " . $e->getMessage() . "</td></tr>";
                                }

                                $database->close();
                                ?>

                            </tbody>
                        </table>
                    </div>
                </section>

                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" name="assignStudents" class="btn btn-success">Assign</button>
                </div>
            </form>
        </div>

    <?php endif; ?>
    <!-- End Student Table -->

</main>

<?php include_once "../templates/footer.php"; ?>