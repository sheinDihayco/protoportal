<?php include_once "../templates/header.php" ?>;


<main id="main" class="main">

    <div class="pagetitle">
        <h1>Student Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Student</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class="modal fade" id="insertStudent" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Insert Stduent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="../admin/upload/insert-student-rec.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">

                        <div class="col-md-6">
                            <label for="fname" class="form-label">First name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                            <div class="invalid-feedback">
                                Please provide a valid first name.
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="lname" class="form-label">Last name</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                            <div class="invalid-feedback">
                                Please provide a valid last name.
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="middleInitial" class="form-label">M.I</label>
                            <input type="text" class="form-control" id="middleInitial" name="middleInitial" required>
                            <div class="invalid-feedback">
                                Please provide a valid last name.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" id="gender" name="gender" required>
                                <option value="" disabled selected>select</option>
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

                        <div class="col-md-12">
                            <label for="pob" class="form-label">Place of Birth</label>
                            <input type="text" class="form-control" id="pob" name="pob" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="emal" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">
                                Please provide a valid birth date.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="studentID" class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="studentID" name="studentID" required>
                            <div class="invalid-feedback">
                                Please provide a valid department.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="course" class="form-label">Course</label>
                            <input type="text" class="form-control" id="course" name="course" required>
                            <div class="invalid-feedback">
                                Please provide a valid date.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="year" class="form-label">Year</label>
                            <input type="text" class="form-control" id="year" name="year" required>
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="major" class="form-label">Major</label>
                            <input type="text" class="form-control" id="major" name="major" required>
                            <div class="invalid-feedback">
                                Please provide a valid number.
                            </div>
                        </div>


                        <div class="col-md-4">
                            <label for="nationality" class="form-label">Nationality</label>
                            <input type="text" class="form-control" id="nationality" name="nationality" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="civilStatus" class="form-label">Civil Status</label>
                            <input type="text" class="form-control" id="civilStatus" name="civilStatus" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="religion" class="form-label">Religion</label>
                            <input type="text" class="form-control" id="religion" name="religion" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="modality" class="form-label">Modality</label>
                            <input type="text" class="form-control" id="modality" name="modality" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fb" class="form-label">Facebook Account</label>
                            <input type="text" class="form-control" id="fb" name="fb" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="curAddress" class="form-label">Current Address</label>
                            <input type="text" class="form-control" id="curAddress" name="curAddress" placeholder="(House No. , Street Name / Purok)" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="cityAdd" class="form-label">City Address</label>
                            <input type="text" class="form-control" id="cityAdd" name="cityAdd" placeholder="(Barangay, Town or City, Province, Country)" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="zipcode" class="form-label">Zip Code</label>
                            <input type="text" class="form-control" id="zipcode" name="zipcode" required>
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="contact" class="form-label">Contact</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>
                            <div class="invalid-feedback">
                                Please provide a valid title.
                            </div>
                        </div>
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-12">
                        </div>
                        <div class="col-md-8">
                            <label for="fatherName" class="form-label">Father's Name</label>
                            <input type="text" class="form-control" id="fatherName" name="fatherName" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="fwork" class="form-label">Occupation</label>
                            <input type="text" class="form-control" id="fwork" name="fwork" required>
                            <div class="invalid-feedback">
                                Please provide a valid birth date.
                            </div>
                        </div>

                        <div class="col-md-8">
                            <label for="motherName" class="form-label">Mother's Name</label>
                            <input type="text" class="form-control" id="motherName" name="motherName" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="mwork" class="form-label">Occupation</label>
                            <input type="text" class="form-control" id="mwork" name="mwork" required>
                            <div class="invalid-feedback">
                                Please provide a valid birth date.
                            </div>
                        </div>

                        <div class="card-title" style="text-align: center;">
                            <p>Educational Background</p>
                        </div>

                        <!--Primary-->
                        <p class="card-title" style="margin-top: -3%;">Primary (Grade 1 -4)</p>
                        <div class="col-md-4">
                            <label for="primarySchool" class="form-label">Name of School</label>
                            <input type="text" class="form-control" id="primarySchool" name="primarySchool" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="primaryAddress" class="form-label">School Address</label>
                            <input type="text" class="form-control" id="primaryAddress" name="primaryAddress" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="primaryCompleted" class="form-label">Completed</label>
                            <input type="text" class="form-control" id="primaryCompleted" name="primaryCompleted" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div> <!--End of Primary-->

                        <!--Entermediate-->
                        <p class="card-title" style="margin-top: 2%;">Entermediate (Grade 5 - 6)</p>
                        <div class="col-md-4">
                            <label for="entermediateSchool" class="form-label">Name of School</label>
                            <input type="text" class="form-control" id="entermediateSchool" name="entermediateSchool" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="entermediateAddress" class="form-label">School Address</label>
                            <input type="text" class="form-control" id="entermediateAddress" name="entermediateAddress" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="entermediateCompleted" class="form-label">Completed</label>
                            <input type="text" class="form-control" id="entermediateCompleted" name="entermediateCompleted" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div> <!--End of Entermediate-->

                        <!--High School-->
                        <p class="card-title" style="margin-top: 2%;">High School</p>
                        <div class="col-md-4">
                            <label for="hsSchool" class="form-label">Name of School</label>
                            <input type="text" class="form-control" id="hsSchool" name="hsSchool" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="hsAddress" class="form-label">School Address</label>
                            <input type="text" class="form-control" id="hsAddress" name="hsAddress" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="hsCompleted" class="form-label">Completed</label>
                            <input type="text" class="form-control" id="hsCompleted" name="hsCompleted" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div> <!--End of Primary-->
                        <!--k12-->
                        <p class="card-title" style="margin-top: 2%;">K12</p>
                        <div class="col-md-4">
                            <label for="shSchool" class="form-label">Name of School</label>
                            <input type="text" class="form-control" id="shSchool" name="shSchool" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="shAddress" class="form-label">School Address</label>
                            <input type="text" class="form-control" id="shAddress" name="shAddress" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="shCompleted" class="form-label">Completed</label>
                            <input type="text" class="form-control" id="shCompleted" name="shCompleted" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div> <!--End of k12-->
                        <!--college-->
                        <p class="card-title" style="margin-top: 2%;">College</p>
                        <div class="col-md-4">
                            <label for="collegeSchool" class="form-label">Name of School</label>
                            <input type="text" class="form-control" id="collegeSchool" name="collegeSchool" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="collegeAddress" class="form-label">School Address</label>
                            <input type="text" class="form-control" id="collegeAddress" name="collegeAddress" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="collegeCompleted" class="form-label">Completed</label>
                            <input type="text" class="form-control" id="collegeCompleted" name="collegeCompleted" required>
                            <div class="invalid-feedback">
                                Please provide a valid address.
                            </div>
                        </div> <!--End of college-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="../admin/bsit.php">BSIT</a></li>
                                    <li><a class="dropdown-item" href="../admin/bsba.php">BSBA</a></li>
                                    <li><a class=" dropdown-item" href="../admin/bsoa.php">BSOA</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Students <span>| Enrolled</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Student ID</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Major</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $database = new Connection();
                                        $db = $database->open();

                                        try {
                                            $query = "SELECT * FROM tbl_students WHERE major = 'Programming' /* Chnage major here!!!!!!! */
                                                      ORDER BY lname ASC";
                                            foreach ($db->query($query) as $row) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><a href="#"><?php echo $row["studentID"] ?></a></th>
                                                    <td><?php echo $row["lname"] ?>, <?php echo $row["fname"] ?></td>
                                                    <td><?php echo $row["course"] ?> - <?php echo $row["year"] ?></td>
                                                    <td><?php echo $row["major"] ?></td>
                                                    <td><button type="button" class="ri-edit-2-fill" data-bs-toggle="modal" data-bs-target="#editStudent<?php echo $row["studentID"] ?>"></button></td>
                                                    <?php include('modals/form-edit-student.php'); ?>
                                                </tr>
                                        <?php
                                            }
                                        } catch (PDOException $e) {
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }
                                        $database->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>


</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>