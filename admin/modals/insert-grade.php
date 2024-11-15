<?php
$database = new Connection();
$db = $database->open();

$subjects = [];
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

                    <!-- User Info -->
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

                    <!-- Year, Subject, Semester, Term, Academic Year, Grade -->
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="year<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Year</label>
                            <select class="form-control" id="year<?php echo htmlspecialchars($student['user_id']); ?>" name="year" required onchange="filterSubjectsByYear(<?php echo htmlspecialchars($student['user_id']); ?>)">
                                <option value="">All Years</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="subject<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Subject</label>
                            <select name="subject" class="form-select" id="subject<?php echo htmlspecialchars($student['user_id']); ?>" required disabled>
                                <option value="" disabled selected>Select a subject</option>
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label for="semester<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Semester</label>
                            <select name="semester" class="form-control" id="semester<?php echo htmlspecialchars($student['user_id']); ?>" required disabled onchange="enableNextField('semester<?php echo $student['user_id']; ?>', 'term<?php echo $student['user_id']; ?>')">
                                <option value="">Select Semester</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="term<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Term</label>
                            <select name="term" class="form-select" id="term<?php echo htmlspecialchars($student['user_id']); ?>" required disabled onchange="enableNextField('term<?php echo $student['user_id']; ?>', 'sy<?php echo $student['user_id']; ?>')">
                                <option value="" disabled selected>Select a term</option>
                                <option value="Prelim">Prelim</option>
                                <option value="Midterm">Midterm</option>
                                <option value="Pre-final">Pre-final</option>
                                <option value="Final">Final</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="sy<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Academic Year</label>
                            <select name="sy" class="form-control" id="sy<?php echo htmlspecialchars($student['user_id']); ?>" required disabled onchange="enableNextField('sy<?php echo $student['user_id']; ?>', 'grade<?php echo $student['user_id']; ?>')">
                                <option value="">Select Academic Year</option>
                                <option value="2024-2025">2024-2025</option>
                                <option value="2023-2024">2023-2024</option>
                                <option value="2022-2023">2022-2023</option>
                                <option value="2020-2021">2020-2021</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="grade<?php echo htmlspecialchars($student['user_id']); ?>" class="form-label">Grade</label>
                            <input type="text" name="grade" class="form-control" id="grade<?php echo htmlspecialchars($student['user_id']); ?>" required disabled>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-success btn-lg px-5" type="submit" name="register">Save</button>
                    </div>
                </form>
            </div>
        </div>


<script>
    function filterSubjectsByYear(studentId) {
        const yearSelect = document.getElementById(`year${studentId}`);
        const subjectSelect = document.getElementById(`subject${studentId}`);
        const selectedYear = yearSelect.value;
        const course = document.getElementById(`course${studentId}`).value;

        subjectSelect.innerHTML = '<option value="" disabled selected>Select a subject</option>';

        <?php foreach ($subjects as $subject): ?>
            if (<?php echo $subject['year']; ?> == selectedYear && "<?php echo $subject['course']; ?>" === course) {
                const option = document.createElement('option');
                option.value = "<?php echo htmlspecialchars($subject['id']); ?>";
                option.textContent = "<?php echo htmlspecialchars($subject['code']) . ' - ' . htmlspecialchars($subject['description']); ?>";
                subjectSelect.appendChild(option);
            }
        <?php endforeach; ?>

        // Enable the subject field if there are options available, otherwise disable it
        enableNextField(`year${studentId}`, `subject${studentId}`);
    }

    function enableNextField(currentFieldId, nextFieldId) {
        const currentField = document.getElementById(currentFieldId);
        const nextField = document.getElementById(nextFieldId);

        if (currentField && nextField) {
            if (currentField.value) {
                nextField.disabled = false; // Enable next field
            } else {
                nextField.disabled = true; // Disable next field
                resetSubsequentFields(nextFieldId); // Disable all fields that follow
            }
        }
    }

    function resetSubsequentFields(startFieldId) {
        const fieldOrder = ["subject", "semester", "term", "sy", "grade"];
        let disable = false;

        fieldOrder.forEach(field => {
            const fieldElem = document.getElementById(field + startFieldId.match(/\d+/));
            if (fieldElem) {
                if (disable) {
                    fieldElem.disabled = true;
                    fieldElem.value = ""; // Clear value of disabled fields
                }
                if (fieldElem.id === startFieldId) disable = true;
            }
        });
    }

    // Automatically set semester based on selected subject
    function setSemesterForSubject(studentId) {
        const subjectSelect = document.getElementById(`subject${studentId}`);
        const semesterSelect = document.getElementById(`semester${studentId}`);

        // Get the selected subject
        const selectedSubjectId = subjectSelect.value;

        // If a subject is selected, find the corresponding semester and set it
        <?php foreach ($subjects as $subject): ?>
            if ("<?php echo $subject['id']; ?>" === selectedSubjectId) {
                // Set the semester select based on the subject's semester
                semesterSelect.value = "<?php echo $subject['semester']; ?>";  // assuming the subject has a semester field
                semesterSelect.disabled = false; // Enable semester field after setting value

                // Enable the next field immediately after the semester is set
                enableNextField(`subject${studentId}`, `semester${studentId}`);
                enableNextField(`semester${studentId}`, `term${studentId}`);  // Enable term immediately
            }
        <?php endforeach; ?>
    }

    // Event listeners for each field
    document.addEventListener("DOMContentLoaded", function() {
        const studentId = "<?php echo htmlspecialchars($student['user_id']); ?>";

        document.getElementById(`year${studentId}`).addEventListener("change", function() {
            filterSubjectsByYear(studentId);
        });

        document.getElementById(`subject${studentId}`).addEventListener("change", function() {
            setSemesterForSubject(studentId);  // Automatically set semester based on selected subject
            enableNextField(`subject${studentId}`, `semester${studentId}`);
        });

        document.getElementById(`semester${studentId}`).addEventListener("change", function() {
            enableNextField(`semester${studentId}`, `term${studentId}`);
        });

        document.getElementById(`term${studentId}`).addEventListener("change", function() {
            enableNextField(`term${studentId}`, `sy${studentId}`);
        });

        document.getElementById(`sy${studentId}`).addEventListener("change", function() {
            enableNextField(`sy${studentId}`, `grade${studentId}`);
        });
    });
</script>





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
