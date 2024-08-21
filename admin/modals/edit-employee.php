<!-- Edit Modal -->
<div class="modal fade" id="editModal<?php echo htmlspecialchars($row['employee_id']); ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Employee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form action="functions/update-employee.php" method="post" novalidate>
          <!-- Hidden field to pass employee_id -->
          <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($row['employee_id']); ?>">

          <div class="mb-3 row">
            <label for="bdate" class="col-sm-2 col-form-label">Date of Birth</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="bdate" name="bdate" value="<?php echo htmlspecialchars($row['date_of_birth']); ?>" required>
              <div class="invalid-feedback">
                Please provide a valid date of birth.
              </div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="gend" class="col-sm-2 col-form-label">Gender</label>
            <div class="col-sm-10">
              <select class="form-select" id="gend" name="gend" required>
                <option disabled value="">Select Gender</option>
                <option value="Male" <?php echo ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                <option value="Female" <?php echo ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid gender.
              </div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="dhire" class="col-sm-2 col-form-label">Date Hired</label>
            <div class="col-sm-10">
              <input type="date" class="form-control" id="dhire" name="dhire" value="<?php echo htmlspecialchars($row['hire_date']); ?>" required>
              <div class="invalid-feedback">
                Please provide a valid date hired.
              </div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="title" class="col-sm-2 col-form-label">Job Title</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($row['job_title']); ?>" required>
              <div class="invalid-feedback">
                Please provide a valid job title.
              </div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="dept" class="col-sm-2 col-form-label">Department</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="dept" name="dept" value="<?php echo htmlspecialchars($row['department']); ?>" required>
              <div class="invalid-feedback">
                Please provide a valid department.
              </div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="cnum" class="col-sm-2 col-form-label">Contact Number</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="cnum" name="cnum" value="<?php echo htmlspecialchars($row['phone_number']); ?>" required>
              <div class="invalid-feedback">
                Please provide a valid contact number.
              </div>
            </div>
          </div>

          <div class="mb-3 row">
            <label for="add" class="col-sm-2 col-form-label">Address</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="add" name="add" value="<?php echo htmlspecialchars($row['address']); ?>" required>
              <div class="invalid-feedback">
                Please provide a valid address.
              </div>
            </div>
          </div>

          <div class="col-12 d-flex justify-content-end">
            <button class="btn btn-primary btn-sm" type="submit" name="submit">Save Changes</button>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>