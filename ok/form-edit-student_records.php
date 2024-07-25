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
          <form action="upload/insert-student-rec.php" method="post" novalidate>
            <div class=" col-md-8">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $row["studentID"] ?>" requiredrequired>
            </div>

            <div class="col-md-4">
              <label for="gender" class="form-label">Gender</label>
              <select class="form-control" id="gender" name="gender" required>
                <option value="" disabled selected>Select</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid gender.
              </div>
            </div>
            <div class="col-md-4">
              <label for="bdate" class="form-label">Date of Birth</label>
              <input type="date" class="form-control" id="bdate" name="bdate" required>
              <div class="invalid-feedback">
                Please provide a valid birth date.
              </div>
            </div>
            <div class="col-md-10">
              <label for="pob" class="form-label">Place of Birth</label>
              <input type="text" class="form-control" id="pob" name="pob" required>
              <div class="invalid-feedback">
                Please provide a valid place of birth.
              </div>
            </div>
            <div class="col-md-4">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" required>
              <div class="invalid-feedback">
                Please provide a valid email address.
              </div>
            </div>
            <div class="col-md-4">
              <label for="major" class="form-label">Major</label>
              <input type="text" class="form-control" id="major" name="major" required>
              <div class="invalid-feedback">
                Please provide a valid major.
              </div>
            </div>
            <div class="col-md-4">
              <label for="nationality" class="form-label">Nationality</label>
              <input type="text" class="form-control" id="nationality" name="nationality" required>
              <div class="invalid-feedback">
                Please provide a valid nationality.
              </div>
            </div>
            <div class="col-md-4">
              <label for="civilStatus" class="form-label">Civil Status</label>
              <input type="text" class="form-control" id="civilStatus" name="civilStatus" required>
              <div class="invalid-feedback">
                Please provide a valid civil status.
              </div>
            </div>
            <div class="col-md-4">
              <label for="religion" class="form-label">Religion</label>
              <input type="text" class="form-control" id="religion" name="religion" required>
              <div class="invalid-feedback">
                Please provide a valid religion.
              </div>
            </div>
            <div class="col-md-4">
              <label for="modality" class="form-label">Modality</label>
              <input type="text" class="form-control" id="modality" name="modality" required>
              <div class="invalid-feedback">
                Please provide a valid modality.
              </div>
            </div>
            <div class="col-md-8">
              <label for="fb" class="form-label">Facebook Account</label>
              <input type="text" class="form-control" id="fb" name="fb" required>
              <div class="invalid-feedback">
                Please provide a valid Facebook account.
              </div>
            </div>
            <div class="col-md-10">
              <label for="curAddress" class="form-label">Current Address</label>
              <input type="text" class="form-control" id="curAddress" name="curAddress" placeholder="(House No., Street Name / Purok)" required>
              <div class="invalid-feedback">
                Please provide a valid address.
              </div>
            </div>
            <div class="col-md-8">
              <label for="cityAdd" class="form-label">City Address</label>
              <input type="text" class="form-control" id="cityAdd" name="cityAdd" placeholder="(Barangay, Town or City, Province, Country)" required>
              <div class="invalid-feedback">
                Please provide a valid city address.
              </div>
            </div>
            <div class="col-md-4">
              <label for="zipcode" class="form-label">Zip Code</label>
              <input type="text" class="form-control" id="zipcode" name="zipcode" required>
              <div class="invalid-feedback">
                Please provide a valid zip code.
              </div>
            </div>
            <div class="col-md-4">
              <label for="contact" class="form-label">Contact</label>
              <input type="text" class="form-control" id="contact" name="contact" required>
              <div class="invalid-feedback">
                Please provide a valid contact number.
              </div>
            </div>
            <div class="col-md-8">
              <label for="fatherName" class="form-label">Father's Name</label>
              <input type="text" class="form-control" id="fatherName" name="fatherName" required>
              <div class="invalid-feedback">
                Please provide a valid father's name.
              </div>
            </div>
            <div class="col-md-6">
              <label for="fwork" class="form-label">Occupation</label>
              <input type="text" class="form-control" id="fwork" name="fwork" required>
              <div class="invalid-feedback">
                Please provide a valid occupation.
              </div>
            </div>
            <div class="col-md-8">
              <label for="motherName" class="form-label">Mother's Name</label>
              <input type="text" class="form-control" id="motherName" name="motherName" required>
              <div class="invalid-feedback">
                Please provide a valid mother's name.
              </div>
            </div>
            <div class="col-md-6">
              <label for="mwork" class="form-label">Occupation</label>
              <input type="text" class="form-control" id="mwork" name="mwork" required>
              <div class="invalid-feedback">
                Please provide a valid occupation.
              </div>
            </div>
            <div class="card-title" style="text-align: center;">
              <p>Educational Background</p>
            </div>
            <p class="card-title" style="margin-top: 20px; font-size: 18px;">Elementary</p>
            <div class="col-md-6">
              <label for="primarySchool" class="form-label">School Name</label>
              <input type="text" class="form-control" id="primarySchool" name="primarySchool" required>
              <div class="invalid-feedback">
                Please provide a valid school name.
              </div>
            </div>
            <div class="col-md-4">
              <label for="primaryAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="primaryAddress" name="primaryAddress" required>
              <div class="invalid-feedback">
                Please provide a valid year attended.
              </div>
            </div>
            <div class="col-md-2">
              <label for="primaryCompleted" class="form-label">Honors/Award/Year</label>
              <input type="text" class="form-control" id="primaryCompleted" name="primaryCompleted" required>
              <div class="invalid-feedback">
                Please provide valid honors or awards.
              </div>
            </div>
            <p class="card-title" style="margin-top: 20px; font-size: 18px;">Junior High School</p>
            <div class="col-md-6">
              <label for="entermediateSchool" class="form-label">School Name (gr.5&6) </label>
              <input type="text" class="form-control" id="entermediateSchool" name="entermediateSchool" required>
              <div class="invalid-feedback">
                Please provide a valid school name.
              </div>
            </div>
            <div class="col-md-4">
              <label for="entermediateAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="entermediateAddress" name="entermediateAddress" required>
              <div class="invalid-feedback">
                Please provide a valid year attended.
              </div>
            </div>
            <div class="col-md-4">
              <label for="entermediateCompleted" class="form-label">Honors/Award/Year</label>
              <input type="text" class="form-control" id="entermediateCompleted" name="entermediateCompleted" required>
              <div class="invalid-feedback">
                Please provide valid honors or awards.
              </div>
            </div>
            <p class="card-title" style="margin-top: 20px; font-size: 18px;">High School</p>
            <div class="col-md-6">
              <label for="hsSchool" class="form-label">School Name</label>
              <input type="text" class="form-control" id="hsSchool" name="hsSchool" required>
              <div class="invalid-feedback">
                Please provide a valid school name.
              </div>
            </div>
            <div class="col-md-4">
              <label for="hsAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="hsAddress" name="hsAddress" required>
              <div class="invalid-feedback">
                Please provide a valid year attended.
              </div>
            </div>
            <div class="col-md-4">
              <label for="hsCompleted" class="form-label">Honors/Award/Year</label>
              <input type="text" class="form-control" id="hsCompleted" name="hsCompleted" required>
              <div class="invalid-feedback">
                Please provide valid honors or awards.
              </div>
            </div>
            <p class="card-title" style="margin-top: 20px; font-size: 18px;">Senior High School</p>
            <div class="col-md-6">
              <label for="shSchool" class="form-label">School Name</label>
              <input type="text" class="form-control" id="shSchool" name="shSchool" required>
              <div class="invalid-feedback">
                Please provide a valid school name.
              </div>
            </div>
            <div class="col-md-4">
              <label for="shAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="shAddress" name="shAddress" required>
              <div class="invalid-feedback">
                Please provide a valid year attended.
              </div>
            </div>
            <div class="col-md-4">
              <label for="shCompleted" class="form-label">Honors/Award?Year</label>
              <input type="text" class="form-control" id="shCompleted" name="shCompleted" required>
              <div class="invalid-feedback">
                Please provide valid honors or awards.
              </div>
            </div>
            <p class="card-title" style="margin-top: 20px; font-size: 18px;">College</p>
            <div class="col-md-6">
              <label for="collegeSchool" class="form-label">School Name</label>
              <input type="text" class="form-control" id="collegeSchool" name="collegeSchool" required>
              <div class="invalid-feedback">
                Please provide a valid school name.
              </div>
            </div>
            <div class="col-md-4">
              <label for="collegeAddress" class="form-label">School Address</label>
              <input type="text" class="form-control" id="collegeAddress" name="collegeAddress" required>
              <div class="invalid-feedback">
                Please provide a valid year attended.
              </div>
            </div>
            <div class="col-md-4">
              <label for="collegeCompleted" class="form-label">Honors/Award?Year</label>
              <input type="text" class="form-control" id="collegeCompleted" name="collegeCompleted" required>
              <div class="invalid-feedback">
                Please provide valid honors or awards.
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