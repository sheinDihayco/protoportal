<div class="modal fade" id="updatePaymentStatus<?php echo $row["studentID"] ?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Horizontal Form</h5>

          <!-- Horizontal Form -->
          <form action="functions/payment-status.php" method="POST" novalidate>

            <div class=" col-md-6">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $row["studentID"] ?>" required>
            </div>

            <div class="col-md-6">
              <label for="semester" class="form-label">Semester</label>
              <select class="form-select" id="semester" name="semester" required>
                <option value="">Choose...</option>
                <option value="1st" <?php if ($row["semester"] == "1st") echo "selected"; ?>>1st</option>
                <option value="2nd" <?php if ($row["semester"] == "2nd") echo "selected"; ?>>2nd</option>
              </select>
              <div class="invalid-feedback">
                Please select a valid semester.
              </div>
            </div>

            <div class="col-md-6">
              <label for="paymentPeriod" class="form-label">Payment Period</label>
              <select class="form-select" id="paymentPeriod" name="paymentPeriod" required>
                <option value="">Choose...</option>
                <option value="Prelim" <?php if ($row["paymentPeriod"] == "Prelim") echo "selected"; ?>>Prelim</option>
                <option value="Midterm" <?php if ($row["paymentPeriod"] == "Midterm") echo "selected"; ?>>Midterm</option>
                <option value="Pre-final" <?php if ($row["paymentPeriod"] == "Pre-final") echo "selected"; ?>>Pre-final</option>
                <option value="Final" <?php if ($row["paymentPeriod"] == "Final") echo "selected"; ?>>Final</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="payment_status" class="form-label">Status</label>
              <select class="form-select" id="payment_status" name="payment_status" required>
                <option value="">Choose...</option>
                <option value="Paid" <?php if ($row["payment_status"] == "Paid") echo "selected"; ?>>Paid</option>
                <option value="Pending" <?php if ($row["payment_status"] == "Pending") echo "selected"; ?>>Pending</option>
                <option value="Overdue" <?php if ($row["payment_status"] == "Overdue") echo "selected"; ?>>Overdue</option>
              </select>
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