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


    <div class="container mt-4">
        <!-- Add Course Button and Modal -->
        <h2>Manage Courses</h2>
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#courseModal">Add Course</button>

        <!-- Courses Table -->
        <table class="table table-striped" id="coursesTable">
            <thead>
                <tr>
                    <th>Course Description</th>
                    <th>Course Year</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courses as $course): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($course['course_description']); ?></td>
                        <td><?php echo htmlspecialchars($course['course_year']); ?></td>
                        <td><button class="btn btn-primary edit-course" data-id="<?php echo $course['course_id']; ?>" data-description="<?php echo htmlspecialchars($course['course_description']); ?>" data-year="<?php echo htmlspecialchars($course['course_year']); ?>">Edit</button></td>
                        <td><button class="btn btn-danger delete-course" data-id="<?php echo $course['course_id']; ?>">Delete</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Course Modal -->
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
                                <input type="number" class="form-control" id="course_year" name="course_year" min="1" max="10" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
                        loadCourses(); // Refresh the courses table
                        alert(data.message);
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