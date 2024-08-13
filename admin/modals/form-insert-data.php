<div class="modal fade" id="insertInitial<?php echo $row["user_id"] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="card-title">Insert Initial Data of Student</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card">
        <div class="card-body">

          <!-- Horizontal Form -->
          <form action="upload/insert-initial-data.php" method="post" novalidate>
            <div class="row mb-3">
              <div class=" col-md-6">
                <label for="user_id" class="col-sm-2 col-form-label">User ID</label>
                <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $row["user_id"] ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class=" col-md-7">
                <label for="studentID" class="col-sm-2 col-form-label">Student ID</label>
                <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $row["user_name"] ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="lname" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row["user_lname"] ?>" readonly>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="fname" class="form-label">First Name</label>
                <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row["user_fname"] ?>" readonly>
              </div>
            </div>

            <!-- <div class="row mb-3">
              <div class="col-md-4">
                <label for="middleInitial" class="form-label">Middle Initial</label>
                <input type="text" class="form-control" id="middleInitial" name="middleInitial" value="" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-4">
                <label for="Suffix" class="form-label">Suffix</label>
                <input type="text" class="form-control" id="Suffix" name="Suffix" name="middleInitial" value="" required>
              </div>
            </div>-->

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="course" class="form-label">Course</label>
                <input type="text" class="form-control" id="course" name="course" value="" required>
              </div>
            </div>

            <div class=" row mb-3">
              <div class="col-md-4">
                <label for="year" class="form-label">Year</label>
                <input type="text" class="form-control" id="year" name="year" value="" required>
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