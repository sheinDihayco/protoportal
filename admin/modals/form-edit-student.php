<div class="modal fade" id="editStudent<?php echo $row["studentID"] ?>" tabindex="-1">
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
          <form action="functions/update-student.php" method="post" novalidate>

            <div class="col-md-8">
              <label for="fname" class="form-label">First name</label>
              <input type="text" class="form-control" id="fname" name="fname" value="<?php echo $row["fname"] ?>" required>
            </div>
            <div class="col-md-8 ">
              <label for="lname" class="form-label">Last name</label>
              <input type="text" class="form-control" id="lname" name="lname" value="<?php echo $row["lname"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="middleInitial" class="form-label">M.I</label>
              <input type="text" class="form-control" id="middleInitial" name="middleInitial" value="<?php echo $row["middleInitial"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-control" id="gender" name="gender" required>
                <option disabled value="">Select Gender</option>
                <option <?php echo ($row["gender"] == "Male") ? 'selected' : ''; ?>>Male</option>
                <option <?php echo ($row["gender"] == "Female") ? 'selected' : ''; ?>>Female</option>
              </select>
            </div>
            <div class="col-md-8">
              <label for="bdate" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="bdate" name="bdate" value="<?php echo $row["bdate"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="pob" class="form-label">Place of Birth</label>
              <input type="text" class="form-control" id="pob" name="pob" value="<?php echo $row["pob"] ?>" requiredrequired>
            </div>
            <div class=" col-md-8">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo $row["email"] ?>" required>
            </div>
            <div class=" col-md-8">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $row["studentID"] ?>" requiredrequired>
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
              <label for="major" class="form-label">Major</label>
              <input type="text" class="form-control" id="major" name="major" value="<?php echo $row["major"] ?>" required>
            </div>
            <div class=" col-md-8">
              <label for="nationality" class="form-label">Nationality</label>
              <input type="text" class="form-control" id="nationality" name="nationality" value="<?php echo $row["nationality"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="civilStatus" class="form-label">Civil Status</label>
              <input type="text" class="form-control" id="civilStatus" name="civilStatus" value="<?php echo $row["civilStatus"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="religion" class="form-label">Religion</label>
              <input type="text" class="form-control" id="religion" name="religion" value="<?php echo $row["religion"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="modality" class="form-label">Modality</label>
              <input type="text" class="form-control" id="modality" name="modality" value="<?php echo $row["modality"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="fb" class="form-label">Facebook Account</label>
              <input type="text" class="form-control" id="fb" name="fb" value="<?php echo $row["fb"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="curAddress" class="form-label">Current Address</label>
              <input type="text" class="form-control" id="curAddress" name="curAddress" value="<?php echo $row["curAddress"] ?>">
            </div>
            <div class="col-md-8">
              <label for="cityAdd" class="form-label">City Address</label>
              <input type="text" class="form-control" id="cityAdd" name="cityAdd" value="<?php echo $row["cityAdd"] ?>" placeholder="(Barangay, Town or City, Province, Country)" required>
            </div>
            <div class="col-md-8">
              <label for="zipcode" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo $row["zipcode"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="contact" class="form-label">Contact</label>
              <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $row["contact"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="fatherName" class="form-label">Father's Name</label>
              <input type="text" class="form-control" id="fatherName" name="fatherName" value="<?php echo $row["fatherName"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="fwork" class="form-label">Father's Occupation</label>
              <input type="text" class="form-control" id="fwork" name="fwork" value="<?php echo $row["fwork"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="motherName" class="form-label">Mother's Name</label>
              <input type="text" class="form-control" id="motherName" name="motherName" value="<?php echo $row["motherName"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="mwork" class="form-label">Mother's Occupation</label>
              <input type="text" class="form-control" id="mwork" name="mwork" value="<?php echo $row["mwork"] ?>" required>
            </div>

            <!-- Educational Background Sections -->

            <div class="col-md-8">
              <h5 class="card-title" style="margin:5%; text-align:center">Educational Background</h5>
            </div>
            <p class="card-title" style="margin-top: -3%;">Primary (Grade 1 - 4)</p>
            <div class="col-md-8">
              <label for="primarySchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="primarySchool" name="primarySchool" value="<?php echo $row["primarySchool"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="primaryAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="primaryAddress" name="primaryAddress" value="<?php echo $row["primaryAddress"] ?>" required>
            </div>
            <div class="col-md-8">
              <label for="primaryCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="primaryCompleted" name="primaryCompleted" value="<?php echo $row["primaryCompleted"] ?>" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">Intermediate (Grade 5 - 6)</p>
            <div class="col-md-8">
              <label for="entermediateSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="entermediateSchool" name="entermediateSchool" value="<?php echo $row["entermediateSchool"] ?>" required>
            </div>
            <div class="col-md-6">
              <label for="entermediateAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="entermediateAddress" name="entermediateAddress" value="<?php echo $row["entermediateAddress"] ?>" required>
            </div>
            <div class="col-md-2">
              <label for="entermediateCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="entermediateCompleted" name="entermediateCompleted" value="<?php echo $row["entermediateCompleted"] ?>" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">High School</p>
            <div class="col-md-8">
              <label for="hsSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="hsSchool" name="hsSchool" value="<?php echo $row["hsSchool"] ?>" required>
            </div>
            <div class="col-md-6">
              <label for="hsAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="hsAddress" name="hsAddress" value="<?php echo $row["hsAddress"] ?>" required>
            </div>
            <div class="col-md-2">
              <label for="hsCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="hsCompleted" name="hsCompleted" value="<?php echo $row["hsCompleted"] ?>" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">K12</p>
            <div class="col-md-8">
              <label for="shSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="shSchool" name="shSchool" value="<?php echo $row["shSchool"] ?>" required>
            </div>
            <div class="col-md-6">
              <label for="shAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="shAddress" name="shAddress" value="<?php echo $row["shAddress"] ?>" required>
            </div>
            <div class="col-md-2">
              <label for="shCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="shCompleted" name="shCompleted" value="<?php echo $row["shCompleted"] ?>" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">College</p>
            <div class="col-md-8">
              <label for="collegeSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="collegeSchool" name="collegeSchool" value="<?php echo $row["collegeSchool"] ?>" required>
            </div>required
            <div class="col-md-6">
              <label for="collegeAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="collegeAddress" name="collegeAddress" value="<?php echo $row["collegeAddress"] ?>" required>
            </div>
            <div class="col-md-2">
              <label for="collegeCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="collegeCompleted" name="collegeCompleted" value="<?php echo $row["collegeCompleted"] ?>" required>
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