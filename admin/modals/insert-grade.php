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

<div class="modal fade" id="insertGrade<?php echo htmlspecialchars($row['user_id']); ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-m">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="card-title">Insert Grade</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../admin/functions/insert-grades.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">

                    <div class="col-12">
                        <label for="user_id" class="col-sm-2 col-form-label">User ID</label>
                        <input type="text" class="form-control" id="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>" name="user_id" required>
                    </div>

                    <div class="col-12">
                        <label for="studentID" class="col-sm-2 col-form-label">Student ID</label>
                        <input type="text" class="form-control" id="studentID" value="<?php echo htmlspecialchars($row['studentID']); ?>" name="studentID" required>
                    </div>

                    <div class="col-12 dropdown-container">
                        <label for="subject" class="form-label">Subject</label>
                        <select name="subject" class="form-select" id="subject" required>
                            <option value="" disabled selected>Select a subject</option>
                            <?php foreach ($subjects as $subject): ?>
                                <option value="<?php echo htmlspecialchars($subject['id']); ?>"><?php echo htmlspecialchars($subject['code']); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">Please select a subject.</div>
                    </div>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
                    <script>
                        $(document).ready(function() {
                            $('#subject').select2({
                                placeholder: 'Select a subject',
                                allowClear: true,
                                width: '100%' // Adjust based on your layout
                            });
                        });
                    </script>

                    <div class="col-12">
                        <label for="term" class="form-label">Term</label>
                        <select name="term" class="form-select" id="term" required>
                            <option value="" disabled selected>Select a term</option>
                            <option value="Prelim">Prelim</option>
                            <option value="Midterm">Midterm</option>
                            <option value="Pre-final">Pre-final</option>
                            <option value="Final">Final</option>
                        </select>
                        <div class="invalid-feedback">Please select a term.</div>
                    </div>

                    <div class="col-12">
                        <label for="grade" class="form-label">Grade</label>
                        <input type="text" name="grade" class="form-control" id="grade" required>
                        <div class="invalid-feedback">Please insert grade.</div>
                    </div>

                    <div class="col-12" style="margin-top: 20px;">
                        <button class="btn btn-primary w-100" type="submit" name="register">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>