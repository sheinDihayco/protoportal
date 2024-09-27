<?php include_once "../templates/header2.php"; ?>
<?php include_once "../PHP/studentRecords-con.php"; ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Student Records</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Enrolled</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="col-12">
      <div class="card recent-sales overflow-auto">
        <div class="filter">
          <!-- Filter options -->
        </div>
        <div class="card-body">
          <h5 class="card-title">Students <span>| Enrolled</span></h5>
          <table class="table table-borderless datatable">
            <thead>
              <tr>
                <th scope="col">Student ID</th>
                <th scope="col">Course & Year</th>
                <th scope="col">Full Name</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($assignedStudents)): ?>
                <?php foreach ($assignedStudents as $student): ?>
                  <tr>
                    <th scope="row"><?php echo htmlspecialchars($student['user_name']); ?></th>
                    <td><?php echo htmlspecialchars($student['course']) . ' ' . htmlspecialchars($student['year']); ?></td>
                    <td><?php echo htmlspecialchars($student['lname']) . ', ' . htmlspecialchars($student['fname']); ?></td>
                    <td><?php echo htmlspecialchars($student['status']); ?></td>
                    <td>
                      <!-- Button to trigger the modal for grade insertion -->
                      <button type="button" class="btn btn-sm btn-warning ri-add-box-fill" data-bs-toggle="modal" data-bs-target="#insertGrade<?php echo htmlspecialchars($student['user_id']); ?>"></button>

                      <!-- Form to delete the user -->
                      <form method="POST" action="../admin/upload/delete-students.php" onsubmit="return confirmDelete(this);" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($student['user_id']); ?>">
                        <button type="submit" class="btn btn-sm btn-danger ri-delete-bin-6-line"></button>
                      </form>
                    </td>
                    <?php include('modals/insert-grade.php'); ?>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5">No students assigned to this instructor.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>
</main>

<?php include_once "../templates/footer.php"; ?>
