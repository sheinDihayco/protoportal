<div class="modal fade"id="updatePaymentStatus<?php echo $row['payment_id']; ?>" tabindex="-1" aria-labelledby="updatePaymentStatusLabel<?php echo $row['payment_id']; ?>" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="updatePaymentStatusLabel<?php echo $row['payment_id']; ?>">Update Payment Status</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background-color: #e6ffe6;" >
        <div class="card-body p-4">
          <form action="functions/payment-status.php" method="POST" novalidate>
            <input type="hidden" name="payment_id" value="<?php echo $row['payment_id']; ?>">
            <div class="row mb-3">
              <div class="col-md-4">
                <label for="user_id<?php echo $row['payment_id']; ?>" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="user_id<?php echo $row['payment_id']; ?>" name="user_id" value="<?php echo $row['user_id']; ?>" readonly>
              </div>
              <div class="col-md-4">
                <label for="semester<?php echo $row['payment_id']; ?>" class="form-label">Semester</label>
                <select class="form-select" id="semester<?php echo $row['payment_id']; ?>" name="semester" required>
                  <option value="" disabled>Select a semester</option>
                  <option value="1st" <?php if ($row['semester'] == "1st") echo "selected"; ?>>1st</option>
                  <option value="2nd" <?php if ($row['semester'] == "2nd") echo "selected"; ?>>2nd</option>
                </select>
                <div class="invalid-feedback">Please select a semester.</div>
              </div>
              <div class="col-md-4">
                <label for="paymentPeriod<?php echo $row['payment_id']; ?>" class="form-label">Payment Period</label>
                <select class="form-select" id="paymentPeriod<?php echo $row['payment_id']; ?>" name="paymentPeriod" required>
                  <option value="" disabled>Select a payment period</option>
                  <option value="Prelim" <?php if ($row['paymentPeriod'] == "Prelim") echo "selected"; ?>>Prelim</option>
                  <option value="Midterm" <?php if ($row['paymentPeriod'] == "Midterm") echo "selected"; ?>>Midterm</option>
                  <option value="Pre-final" <?php if ($row['paymentPeriod'] == "Pre-final") echo "selected"; ?>>Pre-final</option>
                  <option value="Final" <?php if ($row['paymentPeriod'] == "Final") echo "selected"; ?>>Final</option>
                </select>
                <div class="invalid-feedback">Please select a payment period.</div>
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-md-6">
                <label for="payment_status<?php echo $row['payment_id']; ?>" class="form-label">Status</label>
                <select class="form-select" id="payment_status<?php echo $row['payment_id']; ?>" name="payment_status" required>
                  <option value="" disabled>Select status</option>
                  <option value="Paid" <?php if ($row['payment_status'] == "Paid") echo "selected"; ?>>Paid</option>
                  <option value="Pending" <?php if ($row['payment_status'] == "Pending") echo "selected"; ?>>Pending</option>
                  <option value="Overdue" <?php if ($row['payment_status'] == "Overdue") echo "selected"; ?>>Overdue</option>
                </select>
                <div class="invalid-feedback">Please select a status.</div>
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>