<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/course-con.php"; ?>
<?php include('modals/add-course.php'); ?>
<?php include('modals/edit-course.php'); ?>


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

                            <table class="table table-striped datatable">
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

    </section>

</main>

<?php include_once "../PHP/course-script.php"; ?>
<?php include_once "../templates/footer.php"; ?>