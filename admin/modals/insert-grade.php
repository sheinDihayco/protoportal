<?php
$database = new Connection();
$db = $database->open();

$subjects = []; // Initialize as an empty array

try {
    $sql = "SELECT * FROM tbl_subjects ORDER BY code ASC";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "There was an error fetching subjects: " . $e->getMessage();
}

$database->close();
?>

<div class="modal fade" id="insertGrade<?php echo htmlspecialchars($student['user_id']); ?>" tabindex="-1" aria-labelledby="insertGradeLabel<?php echo htmlspecialchars($student['user_id']); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-lg">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="insertGradeLabel<?php echo htmlspecialchars($student['user_id']); ?>">Insert Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../admin/functions/insert-grades.php" method="post" class="row g-3 needs-validation" novalidate>

                    <div class="col-12">
                        <label for="user_id<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Student ID</label>
                        <input type="text" class="form-control" id="user_id<?php echo htmlspecialchars($student['user_id']); ?>" value="<?php echo htmlspecialchars($student['user_id']); ?>" name="user_id" required readonly>
                    </div>

                    <div class="col-12">
                        <label for="user_name<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Student Name</label>
                        <input type="text" class="form-control" id="user_name<?php echo htmlspecialchars($student['user_id']); ?>" value="<?php echo htmlspecialchars($student['user_name']); ?>" name="user_name" required readonly>
                    </div>

                    <div class="col-12">
                        <label for="subject<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Subject</label>
                        <select name="subject" class="form-select" id="subject<?php echo htmlspecialchars($student['user_id']); ?>" required>
                            <option value="" disabled selected>Select a subject</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?php echo htmlspecialchars($subject['id']); ?>"><?php echo htmlspecialchars($subject['code']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a subject.</div>
                    </div>

                    <div class="col-12">
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

                    <div class="col-12">
                        <label for="grade<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Grade</label>
                        <input type="text" name="grade" class="form-control" id="grade<?php echo htmlspecialchars($student['user_id']); ?>" required>
                        <div class="invalid-feedback">Please insert a grade.</div>
                    </div>

                    <div class="col-12 mt-3">
                        <button class="btn btn-primary w-100" type="submit" name="register">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>