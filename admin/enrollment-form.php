<?php include_once "../templates/header.php"; ?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">

<main id="main" class="main">
    <div class="container my-5">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h2 class="text-center mb-3">MICROSYSTEMS INTERNATIONAL INSTITUTE OF TECHNOLOGY, INC.</h2>
                <p class="text-center">National Highway, Inayagan, City of Naga, Cebu</p>
                <p class="text-center">Tel. No. (032) 4273630 (Registrar’s Office)</p>
                <hr class="mb-4">

                <h3 class="text-center mb-4">Student Personal Data - Enrollment</h3>

                <form>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="last-name" class="form-label">Last Name:</label>
                            <input type="text" id="last-name" name="last-name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="first-name" class="form-label">First Name:</label>
                            <input type="text" id="first-name" name="first-name" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="middleInitial" class="form-label">Middle Name:</label>
                            <input type="text" id="middleInitial" name="middleInitial" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="id-number" class="form-label">ID Number:</label>
                            <input type="text" id="id-number" name="id-number" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label for="gender" class="form-label">Gender:</label>
                            <select id="gender" name="gender" class="form-select">
                                <option value="M">M</option>
                                <option value="F">F</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="date-of-birth" class="form-label">Date of Birth:</label>
                            <input type="date" id="date-of-birth" name="date-of-birth" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="address" class="form-label">Current Address:</label>
                            <input type="text" id="address" name="address" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="permanent-address" class="form-label">Permanent Address:</label>
                            <input type="text" id="permanent-address" name="permanent-address" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address:</label>
                            <input type="email" id="email" name="email" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="facebook-account" class="form-label">Facebook Account:</label>
                            <input type="text" id="facebook-account" name="facebook-account" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="father-name" class="form-label">Father's Name:</label>
                            <input type="text" id="father-name" name="father-name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="father-occupation" class="form-label">Occupation:</label>
                            <input type="text" id="father-occupation" name="father-occupation" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="mother-name" class="form-label">Mother's Name:</label>
                            <input type="text" id="mother-name" name="mother-name" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="mother-occupation" class="form-label">Occupation:</label>
                            <input type="text" id="mother-occupation" name="mother-occupation" class="form-control">
                        </div>
                    </div>

                    <h3 class="text-center mb-4">Educational Attainment</h3>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="table-secondary">
                                <th>Level</th>
                                <th>Name of School</th>
                                <th>School Address</th>
                                <th>Year Completed</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Primary (Grade 1-4)</td>
                                <td><input type="text" name="primary-school" class="form-control"></td>
                                <td><input type="text" name="primary-address" class="form-control"></td>
                                <td><input type="text" name="primary-year" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>Intermediate (Grade 5-6)</td>
                                <td><input type="text" name="intermediate-school" class="form-control"></td>
                                <td><input type="text" name="intermediate-address" class="form-control"></td>
                                <td><input type="text" name="intermediate-year" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>High School</td>
                                <td><input type="text" name="highschool" class="form-control"></td>
                                <td><input type="text" name="highschool-address" class="form-control"></td>
                                <td><input type="text" name="highschool-year" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>K12</td>
                                <td><input type="text" name="k12" class="form-control"></td>
                                <td><input type="text" name="k12-address" class="form-control"></td>
                                <td><input type="text" name="k12-year" class="form-control"></td>
                            </tr>
                            <tr>
                                <td>College</td>
                                <td><input type="text" name="college" class="form-control"></td>
                                <td><input type="text" name="college-address" class="form-control"></td>
                                <td><input type="text" name="college-year" class="form-control"></td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="modality" class="form-label">Modality:</label>
                            <input type="text" id="modality" name="modality" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label for="date" class="form-label">Date:</label>
                            <input type="date" id="date" name="date" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="signature" class="form-label">Student's Signature:</label>
                            <input type="text" id="signature" name="signature" class="form-control">
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</main>
<!-- Add custom CSS to remove underlines -->
<style>
    a {
        text-decoration: none !important;
    }

    .breadcrumb-item a {
        text-decoration: none !important;
    }

    .breadcrumb-item.active {
        text-decoration: none;
    }

    .navbar-brand {
        text-decoration: none !important;
    }

    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 20px;
    }

    .form-group label {
        font-weight: bold;
    }

    .card-body {
        background-color: #ffffff;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    table {
        margin-top: 20px;
    }

    th,
    td {
        text-align: center;
    }

    .no-results {
        text-align: center;
        color: #6c757d;
        font-style: italic;
    }
</style>

<?php include_once "../templates/footer.php"; ?>