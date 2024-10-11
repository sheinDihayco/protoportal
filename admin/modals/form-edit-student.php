<!-- Edit Student Modal -->
<div class="modal fade" id="editStudent<?php echo htmlspecialchars($row['user_id']); ?>" tabindex="-1" aria-labelledby="editStudentLabel<?php echo htmlspecialchars($row['user_id']); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header text-black">
        <h5 class="modal-title" id="editStudentLabel<?php echo htmlspecialchars($row['user_id']); ?>">Update Enrollment Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body"  style="background-color: #e6ffe6;">
        <div class="card-body p-4">
          <form action="upload/insert-initial-data.php" method="post" class="needs-validation" novalidate>
            <!-- Hidden field to pass user_id -->
            <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']); ?>">

            <!-- Student ID -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="studentID" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="studentID" name="studentID" value="<?= htmlspecialchars($row['user_name']); ?>" required>
                <div class="invalid-feedback">Please provide a valid student ID.</div>
              </div>

              <!-- Last Name -->
              <div class="col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?= htmlspecialchars($row['lname']); ?>" readonly>
              </div>
            </div>

            <!-- First Name & Course -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?= htmlspecialchars($row['fname']); ?>" readonly>
              </div>

              <div class="col-md-6">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" name="course" value="<?= htmlspecialchars($row['course']); ?>" required>
                <div class="invalid-feedback">Please provide a valid course.</div>
              </div>
            </div>

            <!-- Year & Semester -->
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="year" class="form-label">Year</label>
                <input type="text" class="form-control" id="year" name="year" value="<?= htmlspecialchars($row['year']); ?>" required>
                <div class="invalid-feedback">Please provide a valid year.</div>
              </div>

              <div class="col-md-6">
                <label for="semester" class="form-label">Semester</label>
                <select class="form-select" id="semester" name="semester" required>
                  <option value="" disabled>Select Gender</option>
                  <option value="1" <?= ($row['semester'] == '1') ? 'selected' : ''; ?>>1</option>
                  <option value="2" <?= ($row['semester'] == '2') ? 'selected' : ''; ?>>2</option>
                </select>
                <div class="invalid-feedback">Please select a valid semester.</div>
            </div>
                
            </div>

            <!-- Status -->
            <div class="mb-3">
              <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                  <option value="" disabled>Select Semester</option>
                  <option value="Enrolled" <?= ($row['status'] == 'Enrolled') ? 'Enrolled' : ''; ?>>Enrolled</option>
                  <option value="Unenrolled" <?= ($row['status'] == 'Unenrolled') ? 'Unenrolled' : ''; ?>>Unenrolled</option>
                </select>
              <div class="invalid-feedback">Please select a valid status.</div>
            </div>

            <!-- Save and Close buttons -->
            <div class="d-flex justify-content-end mt-3">
              <button type="submit" class="btn btn-primary btn-sm me-2" name="submit">Save Changes</button>
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>