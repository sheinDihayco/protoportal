<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/course-con.php"; ?>


<main id="main" class="main">
    <div class="pagetitle">
        <h1>Course Records</h1>
        <!-- Button to trigger modal -->
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
                                                <button class="btn btn-sm btn-warning ri-edit-2-fill edit-course"
                                                    data-id="<?php echo $course['course_id']; ?>"
                                                    data-description="<?php echo htmlspecialchars($course['course_description']); ?>"
                                                    data-year="<?php echo htmlspecialchars($course['course_year']); ?>"></button>

                                                <button class="btn btn-sm btn-danger ri-delete-bin-6-line delete-course"
                                                    data-id="<?php echo htmlspecialchars($course['course_id'], ENT_QUOTES, 'UTF-8'); ?>">

                                                </button>

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
                    <div class="modal-body" style="background-color:#e6ffe6;">
                        <form id="addCourseForm">
                            <input type="hidden" name="course_id" id="course_id">
                            <div class="mb-3">
                                <label for="course_description" class="form-label">Course Description</label>
                                <input type="text" class="form-control" id="course_description" name="course_description" required>
                            </div>
                            <div class="mb-3">
                                <label for="course_year" class="form-label">Course Year</label>
                                <input type="number" class="form-control" id="course_year" name="course_year" min="1" max="12" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color:#e6ffe6;">
                        <form id="editCourseForm">
                            <input type="hidden" name="course_id" id="edit_course_id">
                            <div class="mb-3">
                                <label for="edit_course_description" class="form-label">Course Description</label>
                                <input type="text" class="form-control" id="edit_course_description" name="course_description" required>
                            </div>
                            <div class="mb-3">
                                <label for="edit_course_year" class="form-label">Course Year</label>
                                <input type="number" class="form-control" id="edit_course_year" name="course_year" min="1" max="12" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    </section>

</main>

<?php include_once "../PHP/course-script.php"; ?>
<?php include_once "../templates/footer.php"; ?>