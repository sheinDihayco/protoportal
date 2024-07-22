<div class="modal fade" id="editStudentRecords<?php echo $row["studentID"] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Student Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Horizontal Form</h5>

          <!-- Horizontal Form -->
          <form action="functions/update_student_records.php" method="post" novalidate>

            <div class="col-md-8">
              <label for="fname" class="form-label">First name</label>
              <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row["fname"] ?>" required>
            </div>
            <div class="col-md-8 ">
              <label for="lname" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row["lname"] ?>" required>
            </div>
            <div class=" col-md-8">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $row["studentID"] ?>" readonly>
            </div>
            <div class="col-md-8">
              <label for="course" class="form-label">Course</label>
              <input type="text" class="form-control" id="course" name="course" value="<?php echo $row["course"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="year" class="form-label">Year</label>
              <input type="text" class="form-control" id="year" name="year" value="<?php echo $row["year"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="contact" class="form-label">Contact</label>
              <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $row["contact"] ?>" required>
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