<?php include_once "../templates/header.php"; ?>
<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f5f5f5;
    }

    .form-container {
        width: 70%;
        margin: 20px auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h2,
    h3,
    p {
        text-align: center;
    }

    hr {
        border: 1px solid #000;
    }

    .form-group {
        margin: 15px 0;
    }

    label {
        display: inline-block;
        width: 180px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="date"],
    input[type="email"],
    select {
        width: calc(100% - 200px);
        padding: 8px;
        margin: 5px 0;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ccc;
        text-align: left;
    }

    .signature-section {
        margin-top: 20px;
    }

    .signature-section label {
        display: inline-block;
        width: 100px;
        font-weight: bold;
    }

    button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    button:hover {
        background-color: #0056b3;
    }
</style>

<main id="main" class="main">
    <div class="form-container">
        <h2>MICROSYSTEMS INTERNATIONAL INSTITUTE OF TECHNOLOGY, INC.</h2>
        <p>National Highway, Inayagan, City of Naga, Cebu</p>
        <p>Tel. No. (032) 4273630 (Registrar’s Office)</p>
        <hr>

        <h3>Student Personal Data - Enrollment</h3>

        <form>
            <div class="form-group">
                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last-name">
            </div>
            <div class="form-group">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first-name">
            </div>
            <div class="form-group">
                <label for="middle-name">Middle Name:</label>
                <input type="text" id="middle-name" name="middle-name">
            </div>
            <div class="form-group">
                <label for="id-number">ID Number:</label>
                <input type="text" id="id-number" name="id-number">
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender">
                    <option value="M">M</option>
                    <option value="F">F</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date-of-birth">Date of Birth:</label>
                <input type="date" id="date-of-birth" name="date-of-birth">
            </div>
            <div class="form-group">
                <label for="address">Current Address:</label>
                <input type="text" id="address" name="address">
            </div>
            <div class="form-group">
                <label for="permanent-address">Permanent Address:</label>
                <input type="text" id="permanent-address" name="permanent-address">
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email">
            </div>
            <div class="form-group">
                <label for="father-name">Father's Name:</label>
                <input type="text" id="father-name" name="father-name">
            </div>
            <div class="form-group">
                <label for="father-occupation">Occupation:</label>
                <input type="text" id="father-occupation" name="father-occupation">
            </div>
            <div class="form-group">
                <label for="mother-name">Mother's Name:</label>
                <input type="text" id="mother-name" name="mother-name">
            </div>
            <div class="form-group">
                <label for="mother-occupation">Occupation:</label>
                <input type="text" id="mother-occupation" name="mother-occupation">
            </div>

            <h3>Educational Attainment</h3>
            <table>
                <tr>
                    <th>Level</th>
                    <th>Name of School</th>
                    <th>School Address</th>
                    <th>Year Completed</th>
                </tr>
                <tr>
                    <td>Primary (Grade 1-4)</td>
                    <td><input type="text" name="primary-school"></td>
                    <td><input type="text" name="primary-address"></td>
                    <td><input type="text" name="primary-year"></td>
                </tr>
                <tr>
                    <td>Intermediate (Grade 5-6)</td>
                    <td><input type="text" name="intermediate-school"></td>
                    <td><input type="text" name="intermediate-address"></td>
                    <td><input type="text" name="intermediate-year"></td>
                </tr>
                <tr>
                    <td>High School</td>
                    <td><input type="text" name="highschool"></td>
                    <td><input type="text" name="highschool-address"></td>
                    <td><input type="text" name="highschool-year"></td>
                </tr>
                <tr>
                    <td>K12</td>
                    <td><input type="text" name="k12"></td>
                    <td><input type="text" name="k12-address"></td>
                    <td><input type="text" name="k12-year"></td>
                </tr>
                <tr>
                    <td>College</td>
                    <td><input type="text" name="college"></td>
                    <td><input type="text" name="college-address"></td>
                    <td><input type="text" name="college-year"></td>
                </tr>
            </table>

            <div class="form-group">
                <label for="facebook-account">Facebook Account:</label>
                <input type="text" id="facebook-account" name="facebook-account">
            </div>

            <div class="form-group">
                <label for="modality">Modality:</label>
                <input type="text" id="modality" name="modality">
            </div>

            <div class="signature-section">
                <label>Date:</label>
                <input type="date" name="date">
                <label>Student's Signature:</label>
                <input type="text" name="signature">
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>
</main>