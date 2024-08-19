<?php
ob_start(); // Start output buffering

include_once "../templates/header.php";
include_once "includes/connect.php";
include_once "includes/connection.php";

$instructor_id = $_GET['instructor_id'] ?? '';
$course = $_GET['course'] ?? '';
$year = $_GET['year'] ?? 'all';
$semester = $_GET['semester'] ?? 'all';

$years = ['1' => 'First Year', '2' => 'Second Year', '3' => 'Third Year', '4' => 'Fourth Year']; // Initialize $years array
$semesters = ['1' => '1st Semester', '2' => '2nd Semester']; // Initialize $semesters array

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignStudents'])) {
    $instructor_id = $_POST['instructor_id']; // The user_id of the instructor
    $student_ids = isset($_POST['student_ids']) ? $_POST['student_ids'] : []; // Array of student_ids

    $database = new Connection();
    $db = $database->open();

    try {
        // Begin transaction
        $db->beginTransaction();

        // Delete existing student assignments for this instructor
        $sql = "DELETE FROM tbl_student_instructors WHERE instructor_id = :instructor_id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':instructor_id', $instructor_id, PDO::PARAM_INT);
        $stmt->execute();

        // Insert new student assignments
        $sql = "INSERT INTO tbl_student_instructors (student_id, instructor_id) VALUES (:student_id, :instructor_id)";
        $stmt = $db->prepare($sql);
        foreach ($student_ids as $student_id) {
            $stmt->execute([
                ':student_id' => $student_id,
                ':instructor_id' => $instructor_id
            ]);
        }

        // Commit transaction
        $db->commit();

        // Redirect or notify success
        header("Location:user.php?error=success");
        exit();
    } catch (PDOException $e) {
        // Rollback transaction on error
        $db->rollBack();
        echo "There was an error: " . $e->getMessage();
    }

    $database->close();
}
?>

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Student Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Students</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Instructor Selection -->
    <div class="col-12 mt-3">
        <form id="instructorForm" action="" method="GET">
            <div class="row g-3">
                <div class="col-md-3">
                    <label for="instructor_id" class="form-label">Instructor</label>
                    <select class="form-select" id="instructor_id" name="instructor_id" onchange="enableNextField('course')" required>
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
                <div class="col-md-3">
                    <label for="course" class="form-label">Course</label>
                    <input type="text" class="form-control" id="course" name="course" disabled onchange="enableNextField('year')" required>
                </div>
                <div class="col-md-2">
                    <label for="year" class="form-label">Year</label>
                    <select class="form-select" id="year" name="year" disabled onchange="enableNextField('semester')" required>
                        <option value="" selected>Select Year</option>
                        <option value="all">All Years</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-select" id="semester" name="semester" disabled required>
                        <option value="all" selected>All Semesters</option>
                        <option value="1">1st Semester</option>
                        <option value="2">2nd Semester</option>
                    </select>
                </div>
                <div class="col-md-2 align-self-end">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </div>
        </form>
    </div>



    <!-- Student Table -->
    <?php if (!empty($instructor_id)): ?>
        <form id="assignStudentsForm" action="" method="POST">
            <input type="hidden" name="instructor_id" value="<?php echo htmlspecialchars($instructor_id); ?>">
            <section class="section dashboard">
                <div class="table-responsive mt-4">
                    <table class="table table-bordered table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th scope="col">Select</th>
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
                                                    echo "<td>" . htmlspecialchars($student['user_id']) . "</td>";
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
                                            echo "<td>" . htmlspecialchars($student['user_id']) . "</td>";
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
                <button type="submit" name="assignStudents" class="btn btn-success">Assign Selected Students</button>
            </div>
        </form>
    <?php endif; ?>
</main>

<script>
    function enableNextField(nextFieldId) {
        var currentField = event.target;

        if (currentField.value !== "") {
            document.getElementById(nextFieldId).disabled = false;
        } else {
            document.getElementById(nextFieldId).disabled = true;
        }
    }
</script>

<?php include_once "../templates/footer.php"; ?>