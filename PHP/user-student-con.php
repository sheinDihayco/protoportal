<!-- Vendor JS Files -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>


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

<script>
    // Check if the session variable 'user_created' is set
    <?php if (isset($_SESSION['user_created']) && $_SESSION['user_created']): ?>
        // Show SweetAlert success message with OK button
        Swal.fire({
            icon: 'success',
            title: 'Registration Successful',
            text: 'The student has been successfully registered!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {

            }
        });

        // Unset the session variable to prevent repeated alerts
        <?php unset($_SESSION['user_created']); ?>
    <?php endif; ?>
</script>

<?php

// Check for success or error after deletion
if (isset($_SESSION['delete_success']) && $_SESSION['delete_success'] === true) {
    echo '<script>
    Swal.fire({
        title: "Deleted!",
        text: "User has been successfully deleted.",
        icon: "success",
        confirmButtonText: "OK"
    });
    </script>';
    unset($_SESSION['delete_success']); // Clear the session variable
}

if (isset($_SESSION['delete_error'])) {
    echo '<script>
    Swal.fire({
        title: "Error!",
        text: "' . $_SESSION['delete_error'] . '",
        icon: "error",
        confirmButtonText: "OK"
    });
    </script>';
    unset($_SESSION['delete_error']); // Clear the session variable
}
?>


<!-- JavaScript to Clear the Search Input Field -->
<script>
function clearInputField() {
    document.querySelector('input[name="search_user"]').value = '';

    // Hide the table by setting its display style to 'none'
    const resultTable = document.querySelector(".tblStudents");
    if (resultTable) {
        resultTable.style.display = 'none';
    }
}
</script>

<!-- Template Main JS File -->
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

