<?php include_once "../templates/header.php"; ?>

<?php
// Database connection
$pdo = new PDO('mysql:host=localhost;dbname=schooldb', 'root', '');

// Initialize variables
$grades = [];
$studentInfo = null;

// Check if the search form was submitted
if (isset($_POST['search']) && isset($_POST['user_name'])) {
    $searchTerm = '%' . $_POST['user_name'] . '%';

    // Prepare the SQL statement to get student info
    $studentStmt = $pdo->prepare("
        SELECT 
            s.user_name,
            s.lname,
            s.fname,
            s.middleInitial,
            s.user_id,
            s.year,
            s.semester,
            s.course
        FROM 
            tbl_students s
        WHERE 
            s.user_name LIKE :searchTerm
    ");
    $studentStmt->bindParam(':searchTerm', $searchTerm, PDO::PARAM_STR);
    $studentStmt->execute();

    // Fetch the student information
    $studentInfo = $studentStmt->fetch(PDO::FETCH_ASSOC);

    if ($studentInfo) {
        // Prepare the SQL statement to get grades for all terms
        $gradesStmt = $pdo->prepare("
            SELECT 
                sub.code,
                sub.description,
                sub.unit,
                g.term,
                g.grade
            FROM 
                tbl_grades g
            JOIN 
                tbl_subjects sub ON g.id = sub.id
            WHERE 
                g.user_id = :user_id
        ");
        $gradesStmt->bindParam(':user_id', $studentInfo['user_id'], PDO::PARAM_INT);
        $gradesStmt->execute();

        // Fetch the grades
        $grades = $gradesStmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

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
                    <div class="col-md-10 form-group">
                        <label for="user_name" class="form-label">Student ID:</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" placeholder="Format: MIIT-0000-000" required
                            value="<?php echo isset($_POST['user_name']) ? htmlspecialchars($_POST['user_name']) : ''; ?>">
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

<script>
    function clearSearchForm() {
        // Clear all input fields in the form
        document.querySelectorAll('form input, form select').forEach(input => input.value = '');

        // Check if the form is empty, and hide the section if it is
        const isFormEmpty = Array.from(document.querySelectorAll('form input, form select'))
            .every(input => input.value === '');

        if (isFormEmpty) {
            const gradeResult = document.querySelector('.gradeResult');
            if (gradeResult) {
                gradeResult.style.display = 'none';
            }
        }
    }
</script>

<!-- Add custom CSS to remove underlines -->
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

<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<?php include_once "../templates/footer.php"; ?>