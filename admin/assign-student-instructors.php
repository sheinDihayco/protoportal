<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/assign-student-instructors-con.php"; ?>

<main id="main" class="main">

<section class="section dashboard">

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
                        <select class="form-select" id="instructor_id" name="instructor_id" required>
                            <option value="" <?= !isset($_GET['instructor_id']) ? 'selected' : '' ?>>Select Instructor</option>
                            <?php
                            // Fetch instructors from database
                            $database = new Connection();
                            $db = $database->open();
                            try {
                                $sql = "SELECT * FROM tbl_users WHERE user_role = 'teacher'";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();
                                foreach ($stmt as $user) {
                                    $selected = (isset($_GET['instructor_id']) && $_GET['instructor_id'] == $user['user_id']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($user['user_id']) . '" ' . $selected . '>' . htmlspecialchars($user['user_lname']) . ', ' . htmlspecialchars($user['user_fname']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "<option value='' disabled>Error fetching instructors</option>";
                            }
                            $database->close();
                            ?>
                        </select>
                    </div>

                    <!-- Course Selection -->
                    <div class="col-md-3 form-group">
                        <label for="course" class="form-label">Course</label>
                        <select class="form-select" id="course" name="course" required>
                            <option value="" <?= !isset($_GET['course']) ? 'selected' : '' ?>>Select</option>
                            <?php
                            $database = new Connection();
                            $db = $database->open();
                            try {
                                $sql = "SELECT DISTINCT course_description FROM tbl_course";
                                $stmt = $db->prepare($sql);
                                $stmt->execute();
                                foreach ($stmt as $course) {
                                    $selected = (isset($_GET['course']) && $_GET['course'] == $course['course_description']) ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($course['course_description']) . '" ' . $selected . '>' . htmlspecialchars($course['course_description']) . '</option>';
                                }
                            } catch (PDOException $e) {
                                echo "<option value='' disabled>Error fetching courses</option>";
                            }
                            $database->close();
                            ?>
                        </select>
                    </div>

                    <!-- Year Selection -->
                    <div class="col-md-2 form-group">
                        <label for="year" class="form-label">Year</label>
                        <select class="form-select" id="year" name="year" required>
                            <option value="" <?= !isset($_GET['year']) ? 'selected' : '' ?>>Select</option>
                            <?php
                            $years = [1, 2, 3, 4, 11, 12];
                            foreach ($years as $yr) {
                                $selected = (isset($_GET['year']) && $_GET['year'] == $yr) ? 'selected' : '';
                                echo '<option value="' . $yr . '" ' . $selected . '>' . $yr . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Semester Selection -->
                    <div class="col-md-2 form-group">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester" required>
                            <option value="" <?= !isset($_GET['semester']) ? 'selected' : '' ?>>Select</option>
                            <?php
                            $semesters = [1, 2];
                            foreach ($semesters as $sem) {
                                $selected = (isset($_GET['semester']) && $_GET['semester'] == $sem) ? 'selected' : '';
                                echo '<option value="' . $sem . '" ' . $selected . '>' . $sem . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="col-md-2 form-group align-self-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-search-alt"></i> </button>
                        <button type="button" class="btn btn-secondary" onclick="clearSearchForm()">
                            <i class="bx bx-eraser"></i> </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Search Bar -->

    <?php if (isset($_GET['instructor_id'], $_GET['course'], $_GET['year'], $_GET['semester']) && !empty($_GET['instructor_id']) && !empty($_GET['course']) && !empty($_GET['year']) && !empty($_GET['semester'])): ?>
        
    <!-- Start Table for Student Records -->
    <div class="container mt-4 studentSelection">
        <div class="card">
            <div class="card-body"> 
            <h5 class="card-title">Student Records</h5>
            <form id="assignStudentsForm" action="../admin/includes/assign-student.inc.php" method="POST">
            <!-- Hidden fields for instructor and subject -->
            <input type="hidden" name="instructor_id" value="<?php echo htmlspecialchars($instructor_id); ?>">
            
            <!-- Subject selection dropdown -->
            <div class="col-md-2 form-group">
                <label for="subject_id" class="form-label">Subject</label>
                <select class="form-select" id="subject_id" name="subject_id" required>
                    <option value="" selected>Select Subject</option>
                    <?php
                    $database = new Connection();
                    $db = $database->open();

                    try {
                        // Define year and semester (make sure they are set before running this query)
                        $year = $_GET['year'] ?? '';      // Adjust according to where year is defined
                        $semester = $_GET['semester'] ?? ''; // Adjust according to where semester is defined
                        $course = $_GET['course'] ?? '';

                        // SQL query to filter subjects by year and semester
                        $sql = "SELECT id, description 
                                FROM tbl_subjects 
                                WHERE year = :year AND semester = :semester AND course = :course
                                ORDER BY description ASC";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':year', $year);
                        $stmt->bindParam(':semester', $semester);
                        $stmt->bindParam(':course', $course);
                        $stmt->execute();

                        // Loop through and display subjects
                        foreach ($stmt as $subject) {
                            echo '<option value="' . htmlspecialchars($subject['id']) . '">' . htmlspecialchars($subject['description']) . '</option>';
                        }
                    } catch (PDOException $e) {
                        echo "<option value='' disabled>Error fetching subjects</option>";
                    }

                    $database->close();
                    ?>
                </select>
            </div>
                    
            <!-- Student selection table -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">
                            <input type="checkbox" id="select-all">
                        </th>
                        <th scope="col">Student Name</th>
                        <th scope="col">Course & Year</th>
                    <!-- <th scope="col">Semester</th> -->
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['course'], $_GET['year'], $_GET['semester'])) {
                            $course = $_GET['course'];
                            $year = $_GET['year'];
                            $semester = $_GET['semester'];

                            $database = new Connection();
                            $db = $database->open();

                            try {
                                // Prepare the SQL query to fetch students based on course, year, and semester
                                $sql = "SELECT * FROM tbl_students WHERE course = :course";
                                if ($year != 'all') {
                                    $sql .= " AND year = :year";
                                }
                                if ($semester != 'all') {
                                    $sql .= " AND semester = :semester";
                                }

                                $stmt = $db->prepare($sql);
                                $stmt->bindParam(':course', $course, PDO::PARAM_STR);
                                if ($year != 'all') {
                                    $stmt->bindParam(':year', $year, PDO::PARAM_INT);
                                }
                                if ($semester != 'all') {
                                    $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
                                }

                                // Execute the query and fetch results
                                $stmt->execute();
                                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                if ($results) {
                                    foreach ($results as $row) {
                                        echo "<tr>
                                                <td>
                                                    <input type='checkbox' class='student-checkbox' name='student_ids[]' value='" . htmlspecialchars($row['user_id']) . "'>
                                                </td>
                                                <td>" . htmlspecialchars($row['lname']) . ", " . htmlspecialchars($row['fname']) . "</td>
                                                <td>" . htmlspecialchars($row['course']) . " - " . htmlspecialchars($row['year']) . "</td>
                                                <td>";
                                        
                                        // Status with badges
                                        if (htmlspecialchars($row['status']) == 'Enrolled') {
                                            echo "<span class='badge badge-success'>Enrolled</span>";
                                        } elseif (htmlspecialchars($row['status']) == 'Unenrolled') {
                                            echo "<span class='badge badge-danger'>Unenrolled</span>";
                                        } else {
                                            echo "<span class='badge badge-secondary'>Not Available</span>";
                                        }

                                        echo "</td>
                                            </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='6' class='text-danger'>No records found.</td></tr>";
                                }

                            } catch (PDOException $e) {
                                echo "<tr><td colspan='6' class='text-danger'>Error: " . $e->getMessage() . "</td></tr>";
                            }

                            $database->close();
                        }
                            ?>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" name="assignStudents" class="btn btn-success">Assign</button>
                    </div>
                </form>
            </tbody>
            </div> 
        </div>
    </div>
    <!-- End Table for Student Records -->
    <?php endif; ?>

    <!-- JavaScript for Select All functionality -->
    <script>
        document.getElementById('select-all').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('.student-checkbox');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }
        });
    </script>

</section>

</main>

<style>
/* Button styling */
form .btn {
    font-weight: bold;
    padding: 0.5rem 1rem;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

form .btn-primary {
    background-color: #007bff;
    border-color: #007bff;
}

form .btn-primary:hover {
    background-color: #0056b3;
    border-color: #004085;
    transform: translateY(-1px);
}

form .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

form .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
    transform: translateY(-1px);
}

form .btn-success {
    background-color: #30962f;
    border-color: #6c757d;
}

form .btn-success:hover {
    background-color:green;
    border-color: #545b62;
    transform: translateY(-1px);
}
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
.text-danger{
    font-style: italic;
}
</style>
<?php include_once "../templates/footer.php"; ?>

        