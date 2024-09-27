<?php
include_once "includes/connect.php";
include_once 'includes/connection.php';
$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud FROM tbl_students WHERE course = 'BSBA'");
$statements->execute();
$studcount = $statements->fetch(PDO::FETCH_ASSOC);

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud_bsit FROM tbl_students WHERE course = 'BSIT'");
$statements->execute();
$studcountbsit = $statements->fetch(PDO::FETCH_ASSOC);

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud_bsoa FROM tbl_students WHERE course = 'BSOA'");
$statements->execute();
$studcountbsoa = $statements->fetch(PDO::FETCH_ASSOC);

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud_sh11 FROM tbl_students WHERE year = '11'");
$statements->execute();
$studcount11 = $statements->fetch(PDO::FETCH_ASSOC);

$statements = $conn->prepare("SELECT COUNT(user_id) AS count_stud_sh12 FROM tbl_students WHERE year = '12'");
$statements->execute();
$studcount12 = $statements->fetch(PDO::FETCH_ASSOC);

if (isset($_SESSION['delete_success']) && $_SESSION['delete_success']) {
    echo "
    <script>
        Swal.fire({
            title: 'Deleted!',
            text: 'The student has been successfully deleted.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '../admin/user-student.php';
        });
    </script>";
    unset($_SESSION['delete_success']);
}

if (isset($_SESSION['delete_error'])) {
    echo "
    <script>
        Swal.fire({
            title: 'Error!',
            text: '" . addslashes($_SESSION['delete_error']) . "',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(function() {
            window.location.href = '../admin/user-student.php';
        });
    </script>";
    unset($_SESSION['delete_error']);
}

// Success Alert
if (isset($_SESSION['initial_update']) && $_SESSION['initial_update']) {
    echo "
        <script>
            Swal.fire({
                title: 'Success!',
                text: 'Record successfully updated!',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../admin/user-student.php';
                }
            });
        </script>";
    unset($_SESSION['initial_update']);
}

// Error Alert
if (isset($_SESSION['initial_update_error'])) {
    echo "
        <script>
            Swal.fire({
                title: 'Error!',
                text: '" . $_SESSION['initial_update_error'] . "',
                icon: 'error',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../admin/user-student.php';
                }
            });
        </script>";
    unset($_SESSION['initial_update_error']);
}
?>


<!-- Vendor JS Files -->
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function confirmDelete() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('deleteStudentForm').submit();
            }
        });
    }
</script>

<script>
    // Check if the session variable 'user_created' is set
    <?php if (isset($_SESSION['user_created']) && $_SESSION['user_created']): ?>
        // Show SweetAlert success message with OK button
        Swal.fire({
            icon: 'success',
            title: 'Registration Successful',
            text: 'The user has been successfully registered!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {

            }
        });

        // Unset the session variable to prevent repeated alerts
        <?php unset($_SESSION['user_created']); ?>
    <?php endif; ?>
</script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>
<script>
    document.getElementById('role').addEventListener('change', function() {
        var role = this.value;
        if (role === 'student') {
            document.getElementById('usernameDiv').style.display = 'none';
            document.getElementById('schoolidDiv').style.display = 'block';
        } else {
            document.getElementById('usernameDiv').style.display = 'block';
            document.getElementById('schoolidDiv').style.display = 'none';
        }
    });
</script>