<?php
ob_start(); // Start output buffering

include_once "../templates/header.php";
include_once "includes/connect.php";
include_once "includes/connection.php";

$instructor_id = $_GET['instructor_id'] ?? '';
$course = $_GET['course'] ?? '';
$year = $_GET['year'] ?? 'all';
$semester = $_GET['semester'] ?? 'all';
$subject_id = $_GET['subject_id'] ?? ''; // Get subject_id from the request

$years = ['1' => 'First Year', '2' => 'Second Year', '3' => 'Third Year', '4' => 'Fourth Year', '11' => 'Grade 11', '12' => "Grade 12"]; // Initialize $years array
$semesters = ['1' => '1st Semester', '2' => '2nd Semester']; // Initialize $semesters array

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['assignStudents'])) {
    $instructor_id = $_POST['instructor_id']; // The user_id of the instructor
    $subject_id = $_POST['subject_id']; // Get subject_id from the form
    $student_ids = isset($_POST['student_ids']) ? $_POST['student_ids'] : []; // Array of student_ids

    $already_assigned_students = []; // Array to track students already assigned
    $newly_assigned_students = []; // Array to track newly assigned students

    $database = new Connection();
    $db = $database->open();

    try {
        // Begin transaction
        $db->beginTransaction();

        // Prepare SQL statements for checking and inserting student assignments
        $sql_check = "SELECT COUNT(*) FROM tbl_student_instructors WHERE student_id = :student_id AND instructor_id = :instructor_id AND subject_id = :subject_id";
        $sql_insert = "INSERT INTO tbl_student_instructors (student_id, instructor_id, subject_id) VALUES (:student_id, :instructor_id, :subject_id)";
        $stmt_check = $db->prepare($sql_check);
        $stmt_insert = $db->prepare($sql_insert);

        foreach ($student_ids as $student_id) {
            // Check if student is already assigned
            $stmt_check->execute([':student_id' => $student_id, ':instructor_id' => $instructor_id, ':subject_id' => $subject_id]);
            $already_assigned = $stmt_check->fetchColumn();

            if ($already_assigned) {
                // Add to the list of already assigned students
                $already_assigned_students[] = $student_id;
            } else {
                // Insert new assignment for students not already assigned
                $stmt_insert->execute([':student_id' => $student_id, ':instructor_id' => $instructor_id, ':subject_id' => $subject_id]);
                $newly_assigned_students[] = $student_id;
            }
        }

        // Commit transaction
        $db->commit();

        // Flush output buffer to ensure it's sent to the browser
        ob_end_flush();

        // Show SweetAlert messages
        if (count($newly_assigned_students) > 0) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
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
        }

        // If there are already assigned students, show a different SweetAlert
        if (count($already_assigned_students) > 0) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    title: 'Warning!',
                    text: 'Some students are already enrolled in this class.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '../admin/assign-student-instructors.php';
                    }
                });
            </script>";
        }
    } catch (PDOException $e) {
        // Rollback transaction on error
        $db->rollBack();
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'There was an error assigning the students: " . $e->getMessage() . "',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
    }

    $database->close();
}
?>



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
