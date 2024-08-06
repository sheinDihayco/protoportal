<div class="modal fade" id="editModal<?php echo $row["employee_id"] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-title">Add Employee</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Horizontal Form</h5>
          <form action="functions/update-employee.php" method="post" novalidate>

            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">First Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputText" value="<?php echo $row["first_name"] ?>" name="fname">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Last Name</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="inputText" value="<?php echo $row["last_name"] ?>" name="lname">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Date of Birth</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="inputText" value="<?php echo $row["date_of_birth"] ?>" name="bdate">
              </div>
            </div>
            <div class="row mb-3">
              <label for="validationCustom04" class="col-sm-2 col-form-label">Gender</label>
              <div class="col-sm-8">
                <select class="form-control" id="validationCustom04" name="gend" required>
                  <option disabled value="">Select Gender</option>
                  <option <?php echo ($row["gender"] == "Male") ? 'selected' : ''; ?>>Male</option>
                  <option <?php echo ($row["gender"] == "Female") ? 'selected' : ''; ?>>Female</option>
                </select>
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Date Hired</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="inputText" value="<?php echo $row["hire_date"] ?>" name="dhire">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Job Title</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail" value="<?php echo $row["job_title"] ?>" name="title">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Department</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail" value="<?php echo $row["department"] ?>" name="dept">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Contact</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail" value="<?php echo $row["phone_number"] ?>" name="cnum">
              </div>
            </div>
            <div class="row mb-3">
              <label for="inputEmail3" class="col-sm-2 col-form-label">Address</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="inputEmail" value="<?php echo $row["address"] ?>" name="add">
              </div>
            </div>
            <input type="hidden" class="form-control" id="inputEmail" value="<?php echo $row["employee_id"] ?>" name="empid">

            <div class="col-12 d-flex justify-content-end">
              <button class="btn btn-primary btn-sm" type="submit" name="submit">Save</button>
              <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>