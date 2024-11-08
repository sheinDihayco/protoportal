<?php
$database = new Connection();
$db = $database->open();

$subjects = []; // Initialize as an empty array
$instructor_id = $_SESSION['user_id'];

try {
    $sql = "SELECT * FROM tbl_subjects ORDER BY year ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "There was an error fetching subjects: " . $e->getMessage();
}

$database->close();
?>

<div class="modal fade" id="insertGrade<?php echo htmlspecialchars($student['user_id']); ?>" tabindex="-1" aria-labelledby="insertGradeLabel<?php echo htmlspecialchars($student['user_id']); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0" style="background-color: #004d00; color: white; font-weight: bold;">
                <h5 class="modal-title" id="insertGradeLabel<?php echo htmlspecialchars($student['user_id']); ?>">Insert Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f9f9f9; padding: 30px;">
                <form action="../admin/functions/insert-grades.php" method="post" novalidate>
                    <input type="hidden" name="instructor_id" value="<?php echo $instructor_id; ?>">

                    <div class="row g-3">
                        <div class="col-md-2">
                            <label for="user_id<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">No.</label>
                            <input type="text" class="form-control" id="user_id<?php echo htmlspecialchars($student['user_id']); ?>" value="<?php echo htmlspecialchars($student['user_id']); ?>" name="user_id" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="user_name<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="user_name<?php echo htmlspecialchars($student['user_id']); ?>" value="<?php echo htmlspecialchars($student['user_name']); ?>" name="user_name" readonly>
                        </div>
                        <div class="col-md-4">
                            <label for="course<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Course</label>
                            <input type="text" class="form-control" id="course<?php echo htmlspecialchars($student['user_id']); ?>" value="<?php echo htmlspecialchars($student['course']); ?>" name="course" readonly>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="subject<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Subject</label>
                            <select name="subject" class="form-select" id="subject<?php echo htmlspecialchars($student['user_id']); ?>" required>
                                <option value="" disabled selected>Select a subject</option>
                                <?php
                                foreach ($subjects as $subject):
                                    if ($subject['course'] === $student['course'] && $subject['year'] === $student['year']): ?>
                                        <option value="<?php echo htmlspecialchars($subject['id']); ?>">
                                            <?php echo htmlspecialchars($subject['code']); ?> - <?php echo htmlspecialchars($subject['description']); ?>
                                        </option>
                                    <?php endif;
                                endforeach;
                                ?>
                            </select>
                            <div class="invalid-feedback">Please select a subject.</div>
                        </div>

                        <div class="col-md-3">
                            <label for="year<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Year</label>
                            <input type="text" class="form-control" id="year<?php echo htmlspecialchars($student['user_id']); ?>" value="<?php echo htmlspecialchars($student['year']); ?>" name="year" readonly>
                        </div>

                        <div class="col-md-3">
                            <label for="semester<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Semester</label>
                            <input type="text" name="semester" class="form-control" id="semester<?php echo htmlspecialchars($student['user_id']); ?>" required>
                            <div class="invalid-feedback">Please insert a semester.</div>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="term<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Term</label>
                            <select name="term" class="form-select" id="term<?php echo htmlspecialchars($student['user_id']); ?>" required>
                                <option value="" disabled selected>Select a term</option>
                                <option value="Prelim">Prelim</option>
                                <option value="Midterm">Midterm</option>
                                <option value="Pre-final">Pre-final</option>
                                <option value="Final">Final</option>
                            </select>
                            <div class="invalid-feedback">Please select a term.</div>
                        </div>
                        <div class="col-md-6">
                            <label for="grade<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Grade</label>
                            <input type="text" name="grade" class="form-control" id="grade<?php echo htmlspecialchars($student['user_id']); ?>" required>
                            <div class="invalid-feedback">Please insert a grade.</div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success btn-lg px-5" type="submit" name="register">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Modal Styles */
#insertGrade<?php echo htmlspecialchars($student['user_id']); ?> .modal-content {
    border-radius: 12px;
}

#insertGrade<?php echo htmlspecialchars($student['user_id']); ?> .modal-body {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    padding: 30px;
    background-color: #f9f9f9;
}

/* Styling for form labels and inputs */
#insertGrade<?php echo htmlspecialchars($student['user_id']); ?> .form-label {
    font-weight: bold;
}

#insertGrade<?php echo htmlspecialchars($student['user_id']); ?> .form-control,
#insertGrade<?php echo htmlspecialchars($student['user_id']); ?> .form-select {
    border-radius: 8px;
    padding: 10px;
    font-size: 1rem;
}

/* Adjusting button style */
#insertGrade<?php echo htmlspecialchars($student['user_id']); ?> .btn-success {
    background-color: #28a745;
    border-color: #28a745;
}

#insertGrade<?php echo htmlspecialchars($student['user_id']); ?> .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>
