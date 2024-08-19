<div class="modal fade" id="editStudent<?php echo $row["user_id"] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-title">Update Enrollement Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card">
        <div class="card-body">

          <!-- Horizontal Form -->
          <form action="upload/insert-initial-data.php" method="post" novalidate>
            <div class="row mb-3">
              <div class=" col-md-12">
                <label for="user_id" class="col-sm-2 col-form-label">User ID</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $row["user_id"] ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-12">
                <label for="studentID" class="col-sm-2 col-form-label">Student ID</label>
                <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $row["user_name"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row["lname"] ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row["fname"] ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-12">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($row["course"]) ?>" required>
              </div>
            </div>

            <div class=" row mb-3">
              <div class="col-md-12">
                <label for="year" class="form-label">Year</label>
                <input type="text" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($row["year"]); ?>" required>
              </div>
            </div>

            <div class=" row mb-3">
              <select class="form-select" name="semester">
                <option value="">Select Semester</option>
                <option value="1" <?php if ($row['semester'] === '1') echo 'selected'; ?>>1</option>
                <option value="2" <?php if ($row['semester'] === '2') echo 'selected'; ?>>2</option>
              </select>
            </div>

            <div class=" row mb-3">
              <select class="form-select" name="status">
                <option value="">Select Status</option>
                <option value="Enrolled" <?php if ($row['status'] === 'Enrolled') echo 'selected'; ?>>Enrolled</option>
                <option value="Unenrolled" <?php if ($row['status'] === 'Unenrolled') echo 'selected'; ?>>Unenrolled</option>
              </select>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>