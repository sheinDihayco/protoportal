<main id="main" class="main">
    <div class="modal fade" id="viewModal<?php echo $row["studentID"] ?>" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="card-title" style="text-align: center; margin-left: 20%">
                        <p>Microsystems International Institute of technology Inc.</p>
                        <p style="margin-top: -20px;">Inayagan, City of Naga, Cebu</p>
                        <p style="margin-top: -20px;">OFFICE OF THE REGISTRAR</p>
                        <p style="margin-top: -10px;">STUDENT PERSONAL DATA</p>
                        <span>ENROLLMENT</span>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row g-3 needs-validation" novalidate style="padding: 20px;">

                        <div class="col-md-6">
                            <label for="fname" class="form-label">First name</label>
                            <p id="fname" class="form-control-plaintext"><?php echo $fname ?></p>
                        </div>
                        <div class="col-md-5">
                            <label for="lname" class="form-label">Last name</label>
                            <p id="lname" class="form-control-plaintext"><?php echo $lname ?></p>
                        </div>
                        <div class="col-md-1">
                            <label for="middleInitial" class="form-label">M.I</label>
                            <p id="middleInitial" class="form-control-plaintext"><?php echo $middleInitial ?></p>
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender</label>
                            <p id="gender" class="form-control-plaintext"><?php echo $gender ?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="bdate" class="form-label">Date of Birth</label>
                            <p id="bdate" class="form-control-plaintext"><?php echo $bdate ?></p>
                        </div>

                        <div class="col-md-12">
                            <label for="pob" class="form-label">Place of Birth</label>
                            <p id="pob" class="form-control-plaintext"><?php echo $pob ?></p>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <p id="email" class="form-control-plaintext"><?php echo $email ?></p>
                        </div>
                        <div class="col-md-4">
                            <label for="studentID" class="form-label">Student ID</label>
                            <p id="studentID" class="form-control-plaintext"><?php echo $studentID ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="course" class="form-label">Course</label>
                            <p id="course" class="form-control-plaintext"><?php echo $course ?></p>
                        </div>
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year</label>
                            <p id="year" class="form-control-plaintext"><?php echo $year ?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="major" class="form-label">Major</label>
                            <p id="major" class="form-control-plaintext"><?php echo $major ?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="nationality" class="form-label">Nationality</label>
                            <p id="nationality" class="form-control-plaintext"><?php echo $nationality ?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="civilStatus" class="form-label">Civil Status</label>
                            <p id="civilStatus" class="form-control-plaintext"><?php echo $civilStatus ?></p>
                        </div>
                        <div class="col-md-4">
                            <label for="religion" class="form-label">Religion</label>
                            <p id="religion" class="form-control-plaintext"><?php echo $religion ?></p>
                        </div>
                        <div class="col-md-4">
                            <label for="modality" class="form-label">Modality</label>
                            <p id="modality" class="form-control-plaintext"><?php echo $modality ?></p>
                        </div>
                        <div class="col-md-4">
                            <label for="fb" class="form-label">Facebook Account</label>
                            <p id="fb" class="form-control-plaintext"><?php echo $fb ?></p>
                        </div>
                        <div class="col-md-12">
                            <label for="curAddress" class="form-label">Current Address</label>
                            <p id="curAddress" class="form-control-plaintext"><?php echo $curAddress ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="cityAdd" class="form-label">City Address</label>
                            <p id="cityAdd" class="form-control-plaintext"><?php echo $cityAdd ?></p>
                        </div>
                        <div class="col-md-3">
                            <label for="zipcode" class="form-label">Zip Code</label>
                            <p id="zipcode" class="form-control-plaintext"><?php echo $zipcode ?></p>
                        </div>
                        <div class="col-md-3">
                            <label for="contact" class="form-label">Contact</label>
                            <p id="contact" class="form-control-plaintext"><?php echo $contact ?></p>
                        </div>
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-8">
                            <label for="fatherName" class="form-label">Father's Name</label>
                            <p id="fatherName" class="form-control-plaintext"><?php echo $fatherName ?></p>
                        </div>
                        <div class="col-md-4">
                            <label for="fwork" class="form-label">Occupation</label>
                            <p id="fwork" class="form-control-plaintext"><?php echo $fwork ?></p>
                        </div>

                        <div class="col-md-8">
                            <label for="motherName" class="form-label">Mother's Name</label>
                            <p id="motherName" class="form-control-plaintext"><?php echo $motherName ?></p>
                        </div>

                        <div class="col-md-4">
                            <label for="mwork" class="form-label">Occupation</label>
                            <p id="mwork" class="form-control-plaintext"><?php echo $mwork ?></p>
                        </div>

                        <div class="card-title" style="text-align: center;">
                            <p>Educational Background</p>
                        </div>

                        <!--Primary-->
                        <p class="card-title" style="margin-top: -3%;">Primary (Grade 1 -4)</p>
                        <div class="col-md-4">
                            <label for="primarySchool" class="form-label">Name of School</label>
                            <p id="primarySchool" class="form-control-plaintext"><?php echo $primarySchool ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="primaryAddress" class="form-label">School Address</label>
                            <p id="primaryAddress" class="form-control-plaintext"><?php echo $primaryAddress ?></p>
                        </div>
                        <div class="col-md-2">
                            <label for="primaryCompleted" class="form-label">Completed</label>
                            <p id="primaryCompleted" class="form-control-plaintext"><?php echo $primaryCompleted ?></p>
                        </div> <!--End of Primary-->

                        <!--Intermediate-->
                        <p class="card-title" style="margin-top: 2%;">Intermediate (Grade 5 - 6)</p>
                        <div class="col-md-4">
                            <label for="intermediateSchool" class="form-label">Name of School</label>
                            <p id="intermediateSchool" class="form-control-plaintext"><?php echo $intermediateSchool ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="intermediateAddress" class="form-label">School Address</label>
                            <p id="intermediateAddress" class="form-control-plaintext"><?php echo $intermediateAddress ?></p>
                        </div>
                        <div class="col-md-2">
                            <label for="intermediateCompleted" class="form-label">Completed</label>
                            <p id="intermediateCompleted" class="form-control-plaintext"><?php echo $intermediateCompleted ?></p>
                        </div> <!--End of Intermediate-->

                        <!--High School-->
                        <p class="card-title" style="margin-top: 2%;">High School</p>
                        <div class="col-md-4">
                            <label for="hsSchool" class="form-label">Name of School</label>
                            <p id="hsSchool" class="form-control-plaintext"><?php echo $hsSchool ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="hsAddress" class="form-label">School Address</label>
                            <p id="hsAddress" class="form-control-plaintext"><?php echo $hsAddress ?></p>
                        </div>
                        <div class="col-md-2">
                            <label for="hsCompleted" class="form-label">Completed</label>
                            <p id="hsCompleted" class="form-control-plaintext"><?php echo $hsCompleted ?></p>
                        </div> <!--End of High School-->

                        <!--K12-->
                        <p class="card-title" style="margin-top: 2%;">K12</p>
                        <div class="col-md-4">
                            <label for="shSchool" class="form-label">Name of School</label>
                            <p id="shSchool" class="form-control-plaintext"><?php echo $shSchool ?></p>
                        </div>
                        <div class="col-md-6">
                            <label for="shAddress" class="form-label">School Address</label>
                            <p id="shAddress" class="form-control-plaintext"><?php echo $shAddress ?></p>
                        </div>
                        <div class="col-md-2">
                            <label for="shCompleted" class="form-label">Completed</label>
                            <p id="shCompleted" class="form-control-plaintext"><?php echo $shCompleted ?></p>
                        </div> <!--End of K12-->
                    </form>

                </div>
            </div>
        </div>

</main><!-- End #main -->