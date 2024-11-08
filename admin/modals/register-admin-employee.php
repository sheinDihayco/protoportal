<!-- Start Insert Employee -->
<div class="modal fade" id="insertEmployeeAdmin" tabindex="-1" aria-labelledby="insertEmployeeAdminLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0" style="background-color: #004d00; color: white; font-weight: bold;">
                <h5 class="modal-title" id="insertEmployeeAdminLabel">Register Account</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f9f9f9; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);">
                <form action="includes/register.inc.php" method="post" class="row g-3 needs-validation" novalidate style="padding: 20px;">
                    <div class="col-12">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-select" required>
                            <option value="" disabled selected>Select your role</option>
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                        </select>
                        <div class="invalid-feedback">Please select a role.</div>
                    </div>

                    <div class="col-12">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" name="firstName" class="form-control" id="firstName" required>
                        <div class="invalid-feedback">Please enter your first name.</div>
                    </div>

                    <div class="col-12">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" name="lastName" class="form-control" id="lastName" required>
                        <div class="invalid-feedback">Please enter your last name.</div>
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email" required>
                        <div class="invalid-feedback">Please enter a valid email address.</div>
                    </div>

                    <div class="col-12" id="usernameDiv">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" class="form-control" id="username">
                        <div class="invalid-feedback">Please enter a valid username.</div>
                    </div>

                    <div class="col-12" id="schoolidDiv" style="display: none;">
                        <label for="schoolid" class="form-label">School ID</label>
                        <input type="text" name="schoolid" class="form-control" id="schoolid" pattern="[A-Za-z0-9\-]+" title="School ID can only contain letters, numbers, and dashes.">
                        <div class="invalid-feedback">Please enter a valid school ID (letters, numbers, and dashes only).</div>
                    </div>

                    <div class="col-12">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                        <div class="invalid-feedback">Please enter a password.</div>
                    </div>

                    <div class="col-12">
                        <label for="repeatPassword" class="form-label">Repeat Password</label>
                        <input type="password" name="repeatPassword" class="form-control" id="repeatPassword" required>
                        <div class="invalid-feedback">Please repeat your password.</div>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-primary w-100" type="submit" name="register">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Insert Employee -->

<style>
  /* Custom Modal Styles */
#insertEmployeeAdmin .modal-content {
    border-radius: 12px;
}

#insertEmployeeAdmin .modal-header {
    background-color: #004d00;
    color: white;
    font-weight: bold;
}

#insertEmployeeAdmin .modal-body input,
#insertEmployeeAdmin .modal-body select {
    font-size: 1.1rem;
    border-radius: 8px;
    padding: 10px;
}

#insertEmployeeAdmin .modal-footer {
    border-top: 1px solid #ddd;
    background-color: #f1f1f1;
}

#insertEmployeeAdmin .form-label {
    font-weight: bold;
}

#insertEmployeeAdmin .btn-primary {
    background-color: #28a745;
    border-color: #28a745;
}

#insertEmployeeAdmin .btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
}
</style>
