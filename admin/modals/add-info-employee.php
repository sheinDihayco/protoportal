<div class="modal fade" id="insertModal<?php echo htmlspecialchars($row["employee_id"]); ?>" tabindex="-1" aria-labelledby="insertModalLabel<?php echo htmlspecialchars($row["employee_id"]); ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="insertModalLabel<?php echo htmlspecialchars($row["employee_id"]); ?>">Insert Employee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body" style="background-color: #f9f9f9; padding: 30px;">
        <form action="functions/add-employee.php" method="post" class="row g-3 needs-validation" novalidate>
          <!-- Hidden field to pass employee_id -->
          <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($row['employee_id']); ?>">

          <div class="col-md-4">
            <label for="bdate<?php echo htmlspecialchars($row['employee_id']); ?>" class="form-label">Birth Date</label>
            <input type="date" class="form-control" id="bdate<?php echo htmlspecialchars($row['employee_id']); ?>" name="bdate" required>
            <div class="invalid-feedback">Please provide a valid birth date.</div>
          </div>

          <div class="col-md-4">
            <label for="gend<?php echo htmlspecialchars($row['employee_id']); ?>" class="form-label">Gender</label>
            <select class="form-select" id="gend<?php echo htmlspecialchars($row['employee_id']); ?>" name="gend" required>
              <option selected disabled value="">Choose...</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
            <div class="invalid-feedback">Please select a valid gender.</div>
          </div>

          <div class="col-md-4">
            <label for="dhire<?php echo htmlspecialchars($row['employee_id']); ?>" class="form-label">Date Hired</label>
            <input type="date" class="form-control" id="dhire<?php echo htmlspecialchars($row['employee_id']); ?>" name="dhire" required>
            <div class="invalid-feedback">Please provide a valid date.</div>
          </div>

          <div class="col-md-6">
            <label for="title<?php echo htmlspecialchars($row['employee_id']); ?>" class="form-label">Job Title</label>
            <input type="text" class="form-control" id="title<?php echo htmlspecialchars($row['employee_id']); ?>" name="title" required>
            <div class="invalid-feedback">Please provide a valid title.</div>
          </div>

          <div class="col-md-6">
            <label for="dept<?php echo htmlspecialchars($row['employee_id']); ?>" class="form-label">Department</label>
            <input type="text" class="form-control" id="dept<?php echo htmlspecialchars($row['employee_id']); ?>" name="dept" required>
            <div class="invalid-feedback">Please provide a valid department.</div>
          </div>

          <div class="col-md-6">
            <label for="cnum<?php echo htmlspecialchars($row['employee_id']); ?>" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="cnum<?php echo htmlspecialchars($row['employee_id']); ?>" name="cnum" required>
            <div class="invalid-feedback">Please provide a valid number.</div>
          </div>

          <div class="col-md-12">
            <label for="add<?php echo htmlspecialchars($row['employee_id']); ?>" class="form-label">Address</label>
            <input type="text" class="form-control" id="add<?php echo htmlspecialchars($row['employee_id']); ?>" name="add" required>
            <div class="invalid-feedback">Please provide a valid address.</div>
          </div>

          <div class="col-md-12 mt-3">
            <button type="submit" class="btn btn-success btn-lg w-100" name="submit">Save Changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
