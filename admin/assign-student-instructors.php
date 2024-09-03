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

        // Insert new student assignments, if not already assigned
        $sql_check = "SELECT COUNT(*) FROM tbl_student_instructors WHERE student_id = :student_id AND instructor_id = :instructor_id";
        $sql_insert = "INSERT INTO tbl_student_instructors (student_id, instructor_id) VALUES (:student_id, :instructor_id)";
        $stmt_check = $db->prepare($sql_check);
        $stmt_insert = $db->prepare($sql_insert);

        foreach ($student_ids as $student_id) {
            // Check if student is already assigned
            $stmt_check->execute([':student_id' => $student_id, ':instructor_id' => $instructor_id]);
            $already_assigned = $stmt_check->fetchColumn();

            if (!$already_assigned) {
                // Insert new record
                $stmt_insert->execute([':student_id' => $student_id, ':instructor_id' => $instructor_id]);
            }
        }

        // Commit transaction
        $db->commit();

        // Show SweetAlert and redirect on success
        echo "<script>
            Swal.fire({
                title: 'Success!',
                text: 'Students have been successfully assigned.',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../admin/assign-student-instructors.php';
                }
            });
        </script>";
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

    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Student Records</h1>
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
                    <div class="col-md-3 form-group">
                        <label for="course" class="form-label">Course</label>
                        <input type="text" class="form-control" id="course" name="course" disabled oninput="enableNextField('year')" placeholder="Enter course" required>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="year" class="form-label">Year</label>
                        <select class="form-select" id="year" name="year" disabled oninput="enableNextField('semester')" required>
                            <option value="" selected>Select Year</option>
                            <option value="all">All Years</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select" id="semester" name="semester" disabled required>
                            <option value="all" selected>All Semesters</option>
                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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


<script>
    function toggleSelectAll(selectAllCheckbox) {
        // Get all checkboxes with class 'student-select'
        var checkboxes = document.querySelectorAll('.student-select');

        // Loop through all checkboxes and set their checked property
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
</script>


<script>
    function clearSearchForm() {
        // Clear all input fields in the form
        document.querySelectorAll('form input, form select').forEach(input => input.value = '');

        // Check if the form is empty, and hide the section if it is
        const isFormEmpty = Array.from(document.querySelectorAll('form input, form select'))
            .every(input => input.value === '');

        if (isFormEmpty) {
            const studentResult = document.querySelector('.studentResult');
            if (studentResult) {
                studentResult.style.display = 'none';
            }
        }
    }
</script>

<style>
    a {
        text-decoration: none !important;
    }

    .breadcrumb-item a {
        text-decoration: none !important;
    }

    .breadcrumb-item.active {
        text-decoration: none;
    }

    .navbar-brand {
        text-decoration: none !important;
    }

    .alert {
        padding: 20px;
        background-color: #4CAF50;
        color: white;
        opacity: 1;
        transition: opacity 0.6s;
        margin-bottom: 15px;
        border-radius: 4px;
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 5000;
        width: 300px;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }


    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-bottom: none;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .modal-title {
        font-size: 1rem;
        font-weight: bold;
    }

    .btn-close {
        filter: invert(1);
    }

    .modal-body {
        color: #333;
        padding: 20px;
        font-size: 1rem;
    }

    #eventModalDate {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 10px;
    }

    #editSubjectModal {
        font-size: 1rem;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .modal-footer {
        background-color: #f1f1f1;
        border-top: none;
        padding: 10px 20px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        text-align: right;
    }

    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .card-body {
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    table {
        margin-top: 20px;
    }

    th,
    td {
        text-align: center;
    }

    .no-results {
        text-align: center;
        color: #6c757d;
        font-style: italic;
    }
</style>

<?php include_once "../templates/footer.php"; ?>