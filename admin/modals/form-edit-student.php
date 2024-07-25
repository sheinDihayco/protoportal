<div class="modal fade" id="editStudent<?php echo $row["user_id"] ?>" tabindex="-1">
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
          <form action="upload/insert-student-rec.php" method="post" novalidate>

            <div class=" col-md-8">
              <label for="user_id" class="form-label">User ID</label>
              <input type="text" class="form-control" id="user_id" name="user_id" value="<?php echo $row["user_id"] ?>" required>
            </div>

            <div class=" col-md-8">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="studentID" name="studentID" required>
            </div>


            <div class="col-md-8">
              <label for="lname" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="lname" name="lname" required>
            </div>

            <div class="col-md-8">
              <label for="fname" class="form-label">First Name</label>
              <input type="text" class="form-control" id="fname" name="fname" required>
            </div>

            <div class="col-md-8">
              <label for="middleInitial" class="form-label">Middle Initial</label>
              <input type="text" class="form-control" id="middleInitial" name="middleInitial" required>
            </div>

            <div class="col-md-8">
              <label for="Suffix" class="form-label">Suffix</label>
              <input type="text" class="form-control" id="Suffix" name="Suffix">
            </div>

            <div class="col-md-8">
              <label for="course" class="form-label">Course</label>
              <input type="text" class="form-control" id="course" name="course" required>
            </div>

            <div class="col-md-8">
              <label for="year" class="form-label">Year</label>
              <input type="text" class="form-control" id="year" name="year" required>
            </div>

            <div class="col-md-8">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-control" id="gender" name="gender" required>
                <option>Select Gender</option>
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div class="col-md-8">
              <label for="bdate" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="bdate" name="bdate" required>
            </div>
            <div class="col-md-8">
              <label for="pob" class="form-label">Place of Birth</label>
              <input type="text" class="form-control" id="pob" name="pob" required>
            </div>
            <div class=" col-md-8">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-8">
              <label for="major" class="form-label">Major</label>
              <input type="text" class="form-control" id="major" name="major" required>
            </div>
            <div class=" col-md-8">
              <label for="nationality" class="form-label">Nationality</label>
              <input type="text" class="form-control" id="nationality" name="nationality" required>
            </div>
            <div class="col-md-8">
              <label for="civilStatus" class="form-label">Civil Status</label>
              <input type="text" class="form-control" id="civilStatus" name="civilStatus" required>
            </div>
            <div class="col-md-8">
              <label for="religion" class="form-label">Religion</label>
              <input type="text" class="form-control" id="religion" name="religion" required>
            </div>
            <div class="col-md-8">
              <label for="modality" class="form-label">Modality</label>
              <input type="text" class="form-control" id="modality" name="modality" required>
            </div>
            <div class="col-md-8">
              <label for="fb" class="form-label">Facebook Account</label>
              <input type="text" class="form-control" id="fb" name="fb" required>
            </div>
            <div class="col-md-8">
              <label for="curAddress" class="form-label">Current Address</label>
              <input type="text" class="form-control" id="curAddress" name="curAddress">
            </div>
            <div class="col-md-8">
              <label for="cityAdd" class="form-label">City Address</label>
              <input type="text" class="form-control" id="cityAdd" name="cityAdd" placeholder="(Barangay, Town or City, Province, Country)" required>
            </div>
            <div class="col-md-8">
              <label for="zipcode" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zipcode" name="zipcode" required>
            </div>
            <div class="col-md-8">
              <label for="contact" class="form-label">Contact</label>
              <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="col-md-8">
              <label for="fatherName" class="form-label">Father's Name</label>
              <input type="text" class="form-control" id="fatherName" name="fatherName" required>
            </div>
            <div class="col-md-8">
              <label for="fwork" class="form-label">Father's Occupation</label>
              <input type="text" class="form-control" id="fwork" name="fwork" required>
            </div>
            <div class="col-md-8">
              <label for="motherName" class="form-label">Mother's Name</label>
              <input type="text" class="form-control" id="motherName" name="motherName" required>
            </div>
            <div class="col-md-8">
              <label for="mwork" class="form-label">Mother's Occupation</label>
              <input type="text" class="form-control" id="mwork" name="mwork" required>
            </div>

            <!-- Educational Background Sections -->

            <div class="col-md-8">
              <h5 class="card-title" style="margin:5%; text-align:center">Educational Background</h5>
            </div>
            <p class="card-title" style="margin-top: -3%;">Primary (Grade 1 - 4)</p>
            <div class="col-md-8">
              <label for="primarySchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="primarySchool" name="primarySchool" required>
            </div>
            <div class="col-md-8">
              <label for="primaryAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="primaryAddress" name="primaryAddress" required>
            </div>
            <div class="col-md-8">
              <label for="primaryCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="primaryCompleted" name="primaryCompleted" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">Intermediate (Grade 5 - 6)</p>
            <div class="col-md-8">
              <label for="entermediateSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="entermediateSchool" name="entermediateSchool" required>
            </div>
            <div class="col-md-6">
              <label for="entermediateAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="entermediateAddress" name="entermediateAddress" required>
            </div>
            <div class="col-md-2">
              <label for="entermediateCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="entermediateCompleted" name="entermediateCompleted" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">High School</p>
            <div class="col-md-8">
              <label for="hsSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="hsSchool" name="hsSchool" required>
            </div>
            <div class="col-md-6">
              <label for="hsAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="hsAddress" name="hsAddress" required>
            </div>
            <div class="col-md-2">
              <label for="hsCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="hsCompleted" name="hsCompleted" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">K12</p>
            <div class="col-md-8">
              <label for="shSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="shSchool" name="shSchool" required>
            </div>
            <div class="col-md-6">
              <label for="shAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="shAddress" name="shAddress" required>
            </div>
            <div class="col-md-2">
              <label for="shCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="shCompleted" name="shCompleted" required>
            </div>

            <p class="card-title" style="margin-top: 2%;">College</p>
            <div class="col-md-8">
              <label for="collegeSchool" class="form-label">Name of School</label>
              <input type="text" class="form-control" id="collegeSchool" name="collegeSchool" required>
            </div>
            <div class="col-md-6">
              <label for="collegeAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="collegeAddress" name="collegeAddress" required>
            </div>
            <div class="col-md-2">
              <label for="collegeCompleted" class="form-label">Completed</label>
              <input type="text" class="form-control" id="collegeCompleted" name="collegeCompleted" required>
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