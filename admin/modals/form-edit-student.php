<!-- Edit Student Modal -->
<div class="modal fade" id="editStudent<?php echo htmlspecialchars($row['user_id']); ?>" tabindex="-1" aria-labelledby="editStudentLabel<?php echo htmlspecialchars($row['user_id']); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="editStudentLabel<?php echo htmlspecialchars($row['user_id']); ?>">Update Enrollment Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Horizontal Form -->
        <form action="upload/insert-initial-data.php" method="post" novalidate>
          <!-- Hidden field to pass user_id -->
          <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">

          <div class="mb-3 row">
            <label for="studentID" class="col-sm-3 col-form-label">Student ID</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo htmlspecialchars($row['user_name']); ?>" required>
              <div class="invalid-feedback">Please provide a valid student ID.</div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="lname" class="col-sm-3 col-form-label">Last Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="lname" name="lname" value="<?php echo htmlspecialchars($row['lname']); ?>" readonly>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="fname" class="col-sm-3 col-form-label">First Name</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="fname" name="fname" value="<?php echo htmlspecialchars($row['fname']); ?>" readonly>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="course" class="col-sm-3 col-form-label">Course</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="course" name="course" value="<?php echo htmlspecialchars($row['course']); ?>" required>
              <div class="invalid-feedback">Please provide a valid course.</div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="year" class="col-sm-3 col-form-label">Year</label>
            <div class="col-sm-9">
              <input type="text" class="form-control" id="year" name="year" value="<?php echo htmlspecialchars($row['year']); ?>" required>
              <div class="invalid-feedback">Please provide a valid year.</div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="semester" class="col-sm-3 col-form-label">Semester</label>
            <div class="col-sm-9">
              <select class="form-select" id="semester" name="semester" required>
                <option value="" disabled>Select Semester</option>
                <option value="1" <?php if ($row['semester'] === '1') echo 'selected'; ?>>1</option>
                <option value="2" <?php if ($row['semester'] === '2') echo 'selected'; ?>>2</option>
              </select>
              <div class="invalid-feedback">Please select a valid semester.</div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="status" class="col-sm-3 col-form-label">Status</label>
            <div class="col-sm-9">
              <select class="form-select" id="status" name="status" required>
                <option value="" disabled>Select Status</option>
                <option value="Enrolled" <?php if ($row['status'] === 'Enrolled') echo 'selected'; ?>>Enrolled</option>
                <option value="Unenrolled" <?php if ($row['status'] === 'Unenrolled') echo 'selected'; ?>>Unenrolled</option>
              </select>
              <div class="invalid-feedback">Please select a valid status.</div>
            </div>
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>