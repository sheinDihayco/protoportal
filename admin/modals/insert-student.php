<div class="modal fade" id="assignInstructors<?php echo $row["user_id"] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Instructors to Student <?php echo $row["user_fname"] . ' ' . $row["user_lname"] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #e6ffe6;" >
                <form action="functions/assign-student.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
                    <input type="hidden" name="instructor_id" value="<?php echo $row["user_id"]; ?>">

                    <!-- Student Selection -->
                    <div class="col-12">
                        <label for="students" class="form-label">Select Students</label>
                        <div id="students">
                            <?php
                            $database = new Connection();
                            $db = $database->open();

                            try {
                                $sql = "SELECT user_id, lname, fname FROM tbl_students";
                                foreach ($db->query($sql) as $student) {
                                    echo '<div class="form-check">';
                                    echo '<input class="form-check-input" type="checkbox" name="student_ids[]" value="' . $student["user_id"] . '" id="student' . $student["user_id"] . '">';
                                    echo '<label class="form-check-label" for="student' . $student["user_id"] . '">';
                                    echo $student["lname"] . ', ' . $student["fname"];
                                    echo '</label>';
                                    echo '</div>';
                                }
                            } catch (PDOException $e) {
                                echo "There was an error: " . $e->getMessage();
                            }

                            $database->close();
                            ?>
                        </div>
                        <div class="invalid-feedback">Please select at least one student.</div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit" name="assignStudents">Assign Students</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>