<!-- Edit Modal -->
    <div class="modal fade" id="editModal<?php echo htmlspecialchars($row['user_id']); ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo htmlspecialchars($row['user_id']); ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg">
    <div class="modal-header text-dark">
    <h5 class="modal-title" id="editModalLabel">
    Edit Employee Details
    </h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>

    <div class="modal-body" style="background-color:#e6ffe6;">
    <div class="card-body p-4">
    <form action="functions/update-employee.php" method="post" class="needs-validation" novalidate>
    <!-- Hidden field to pass user_id -->
    <input type="hidden" name="user_id" value="<?= htmlspecialchars($row['user_id']); ?>">

    <!-- Date of Birth -->
    <div class="row mb-3">
    <div class="col-md-6">
    <label for="bdate" class="form-label">Date of Birth</label>
    <input type="date" class="form-control" id="bdate" name="bdate" value="<?= htmlspecialchars($row['date_of_birth']); ?>" required>
    <div class="invalid-feedback">Please provide a valid date of birth.</div>
    </div>
    <!-- Gender -->
    <div class="col-md-6">
    <label for="gend" class="form-label">Gender</label>
    <select class="form-select" id="gend" name="gend" required>
    <option value="" disabled>Select Gender</option>
    <option value="Male" <?= ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
    <option value="Female" <?= ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
    </select>
    <div class="invalid-feedback">Please select a valid gender.</div>
    </div>
    </div>

    <!-- Date Hired & Job Title -->
    <div class="row mb-3">
    <div class="col-md-6">
    <label for="dhire" class="form-label">Date Hired</label>
    <input type="date" class="form-control" id="dhire" name="dhire" value="<?= htmlspecialchars($row['hire_date']); ?>" required>
    <div class="invalid-feedback">Please provide a valid hire date.</div>
    </div>

    <div class="col-md-6">
    <label for="user_role" class="form-label">Job Title</label>
    <input type="text" class="form-control" id="user_role" name="user_role" value="<?= htmlspecialchars($row['user_role']); ?>" required>
    <div class="invalid-feedback">Please provide a valid job title.</div>
    </div>
    </div>

    <!-- Department & Contact Number -->
    <div class="row mb-3">
    <div class="col-md-6">
    <label for="dept" class="form-label">Department</label>
    <input type="text" class="form-control" id="dept" name="dept" value="<?= htmlspecialchars($row['department']); ?>" required>
    <div class="invalid-feedback">Please provide a valid department.</div>
    </div>

    <div class="col-md-6">
    <label for="cnum" class="form-label">Contact Number</label>
    <input type="text" class="form-control" id="cnum" name="cnum" value="<?= htmlspecialchars($row['phone_number']); ?>" required>
    <div class="invalid-feedback">Please provide a valid contact number.</div>
    </div>
    </div>

    <!-- Address -->
    <div class="mb-3">
    <label for="add" class="form-label">Address</label>
    <input type="text" class="form-control" id="add" name="add" value="<?= htmlspecialchars($row['address']); ?>" required>
    <div class="invalid-feedback">Please provide a valid address.</div>
    </div>

    <!-- Submit Button -->
    <div class="d-flex justify-content-end mt-3">
    <button type="submit" class="btn btn-primary btn-sm me-2" name="submit">Save Changes</button>
    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>

