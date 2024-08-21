<div class="modal fade" id="insertModal<?php echo $row["employee_id"] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Insert Employee Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <h5 class="card-title">Horizontal Form</h5>
        <form action="functions/add-employee.php" method="post" class="row g-3 needs-validation" novalidate>
          <!-- Hidden field to pass user_id -->
          <input type="hidden" name="employee_id" value="<?php echo htmlspecialchars($row['employee_id']); ?>">

          <div class="col-md-4">
            <label for="validationCustom03" class="form-label">Birth Date</label>
            <input type="date" class="form-control" id="validationCustom03" name="bdate" required>
            <div class="invalid-feedback">
              Please provide a valid birth date.
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationCustom04" class="form-label">Gender</label>
            <select class="form-select" id="validationCustom04" name="gend" required>
              <option selected disabled value="">Choose...</option>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
            <div class="invalid-feedback">
              Please select a valid gender.
            </div>
          </div>
          <div class="col-md-4">
            <label for="validationCustom05" class="form-label">Date Hired</label>
            <input type="date" class="form-control" id="validationCustom05" name="dhire" required>
            <div class="invalid-feedback">
              Please provide a valid date.
            </div>
          </div>
          <div class="col-md-6">
            <label for="validationCustom06" class="form-label">Job Title</label>
            <input type="text" class="form-control" id="validationCustom06" name="title" required>
            <div class="invalid-feedback">
              Please provide a valid title.
            </div>
          </div>
          <div class="col-md-6">
            <label for="validationCustom07" class="form-label">Department</label>
            <input type="text" class="form-control" id="validationCustom07" name="dept" required>
            <div class="invalid-feedback">
              Please provide a valid department.
            </div>
          </div>

          <div class="col-md-6">
            <label for="validationCustom09" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="validationCustom09" name="cnum" required>
            <div class="invalid-feedback">
              Please provide a valid number.
            </div>
          </div>

          <div class="col-md-12">
            <label for="validationCustom10" class="form-label">Address</label>
            <input type="text" class="form-control" id="validationCustom10" name="add" required>
            <div class="invalid-feedback">
              Please provide a valid address.
            </div>
          </div>

          <div class="col-md-12">
            <button type="submit" class="btn btn-primary btn-sm" name="submit">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>