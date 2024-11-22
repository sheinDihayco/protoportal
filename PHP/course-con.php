<?php
include_once 'includes/connection.php';

// Initialize database connection
$connection = new Connection();
$conn = $connection->open();

// Fetch initial data for courses
$courses = [];

try {
    $stmt = $conn->prepare("SELECT * FROM tbl_course ORDER BY course_description");
    $stmt->execute();
    $courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection->close();
?>

<!-- JavaScript for Handling Form Submissions and Data Display -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $(document).ready(function() {

        // Function to show the Add Course Modal
        function showAddCourseModal() {
            $('#addCourseForm')[0].reset(); // Reset the form fields
            $('#courseModal').modal('show'); // Show the Add Course modal
        }

        // Function to show the Edit Course Modal
        function showEditCourseModal(courseData) {
            // Populate the form fields with the course data
            $('#edit_course_id').val(courseData.course_id);
            $('#edit_course_description').val(courseData.course_description);
            $('#edit_course_year').val(courseData.course_year);

            $('#editCourseModal').modal('show'); // Show the Edit Course modal
        }

        // Event handlers for the forms
        $('#addCourseForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'includes/course.inc.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#courseModal').modal('hide');
                            loadCourses();
                            window.location.href = '../admin/set-slots.php'; // Redirect after success
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });

        $('#editCourseForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'includes/edit-course.inc.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#editCourseModal').modal('hide');
                            loadCourses();
                            window.location.href = '../admin/set-slots.php'; // Redirect after success
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });

        // Load and display courses
        function loadCourses() {
            $.ajax({
                url: 'includes/get-courses.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        let tableContent = '';
                        data.data.forEach(function(item) {
                            tableContent += `<tr>
                            <td>${item.course_description}</td>
                            <td>${item.course_year}</td>
                            <td><button class="btn btn-primary edit-course" data-id="${item.course_id}" data-description="${item.course_description}" data-year="${item.course_year}">Edit</button></td>
                            <td><button class="btn btn-danger delete-course" data-id="${item.course_id}">Delete</button></td>
                        </tr>`;
                        });
                        $('#coursesTable tbody').html(tableContent);
                    } else {
                        alert(data.message);
                    }
                }
            });
        }

        // Edit and delete functionality for courses
        $(document).on('click', '.edit-course', function() {
            const id = $(this).data('id');
            const description = $(this).data('description');
            const year = $(this).data('year');
            $('#course_id').val(id);
            $('#course_description').val(description);
            $('#course_year').val(year);
            $('#courseModal').modal('show');
        });


        $(document).on('click', '.delete-course', function() {
            const id = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'includes/delete-course.php',
                        type: 'POST',
                        data: {
                            course_id: id
                        },
                        success: function(response) {
                            const data = JSON.parse(response);
                            if (data.status === 'success') {
                                loadCourses(); // Refresh the courses table
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                ).then(() => {
                                    window.location.href = '../admin/set-slots.php'; // Redirect after confirmation
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    data.message,
                                    'error'
                                );
                            }
                        },
                        error: function() {
                            Swal.fire(
                                'Error!',
                                'Failed to delete course.',
                                'error'
                            );
                        }
                    });
                }
            });
        });


        // Initial load of data
        loadCourses();
    });
</script>