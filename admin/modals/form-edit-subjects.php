<div class="modal fade" id="editSubject<?php echo $subject["id"] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-title">Update Student Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Horizontal Form</h5>

          <!-- Horizontal Form -->
          <form action="functions/update-subjects.php" method="post" novalidate>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="course" class="col-sm-2 col-form-label">Course</label>
                <input type="text" class="form-control" id="course" name="course" value="<?php echo $subject["course"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="year" class="col-sm-2 col-form-label">Year</label>
                <input type="number" class="form-control" id="year" name="year" value="<?php echo $subject["year"] ?>" required>
              </div>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="semester" class="col-sm-5 col-form-label">Semester</label>
                <input type="text" class="form-control" id="semester" name="semester" value="<?php echo $subject["semester"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="code" class="col-sm-5 col-form-label">Code</label>
                <input type="text" class="form-control" id="code" name="code" value="<?php echo $subject["code"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="description" class="col-sm-5 col-form-label">Description</label>
                <input type="text" class="form-control" id="description" name="description" value="<?php echo $subject["description"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="lec" class="col-sm-2 col-form-label">Lecture</label>
                <input type="number" class="form-control" id="lec" name="lec" value="<?php echo $subject["lec"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="lab" class="col-sm-5 col-form-label">Laboratory</label>
                <input type="number" class="form-control" id="lab" name="lab" value="<?php echo $subject["lab"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="unit" class="col-sm-2 col-form-label">Units</label>
                <input type="number" class="form-control" id="unit" name="unit" value="<?php echo $subject["unit"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="pre_req" class="col-sm-5 col-form-label">Pre-Requisite</label>
                <input type="text" class="form-control" id="pre_req" name="pre_req" value="<?php echo $subject["pre_req"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="total" class="col-sm-5 col-form-label">Total Hours</label>
                <input type="text" class="form-control" id="total" name="total" value="<?php echo $subject["total"] ?>" required>
              </div>
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