<?php include_once "../templates/header.php"; ?>
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

<main id="main" class="main">
    <div class="pagetitle">
        <h1>Course Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#courseModal">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Accounts</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Courses <span>| Available </span></h5>

                            <!-- Custom alert for new student creation -->
                            <?php
                            if (isset($_SESSION['student_created']) && $_SESSION['student_created']) {
                                echo "
                  <div class='alert'>
                      <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
                      New student successfully created!
                  </div>
                  <script>
                      // Automatically close the alert after 5 seconds
                      setTimeout(function() {
                          document.querySelector('.alert').style.opacity = '0';
                          setTimeout(function() {
                              document.querySelector('.alert').style.display = 'none';
                          }, 600);
                      }, 5000);
                  </script>";
                                unset($_SESSION['student_created']); // Unset session variable to prevent repeated alerts
                            }
                            ?>
                            <table class="table table-borderless datatable">
                                <thead>
                                    <tr>
                                        <th scope="col">Course Description</th>
                                        <th scope="col">Course Year</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($course['course_description']); ?></td>
                                            <td><?php echo htmlspecialchars($course['course_year']); ?></td>
                                            <td>
                                                <button class="btn btn-sm btn-warning ri-edit-2-fill edit-course" data-id="<?php echo $course['course_id']; ?>" data-description="<?php echo htmlspecialchars($course['course_description']); ?>" data-year="<?php echo htmlspecialchars($course['course_year']); ?>"></button>

                                                <button class="btn btn-sm btn-danger ri-delete-bin-6-line delete-course" data-id="<?php echo $course['course_id']; ?>"></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="courseModalLabel">Add Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="courseForm">
                            <input type="hidden" name="course_id" id="course_id">
                            <div class="mb-3">
                                <label for="course_description" class="form-label">Course Description</label>
                                <input type="text" class="form-control" id="course_description" name="course_description" required>
                            </div>
                            <div class="mb-3">
                                <label for="course_year" class="form-label">Course Year</label>
                                <input type="number" class="form-control" id="course_year" name="course_year" min="2" max="12" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main>

<!-- JavaScript for Handling Form Submissions and Data Display -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle course form submission
        $('#courseForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'includes/course.inc.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#courseModal').modal('hide');
                        loadCourses();
                        alert(data.message);
                        window.location.href = '../admin/course.php';
                    } else {
                        alert(data.message);
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
            if (confirm('Are you sure you want to delete this course?')) {
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
                            alert(data.message);
                        } else {
                            alert(data.message);
                        }
                    }
                });
            }
        });

        // Initial load of data
        loadCourses();
    });
</script>
<?php include_once "../templates/footer.php"; ?>