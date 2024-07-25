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

            <div class=" col-md-8">
              <label for="studentID" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="studentID" name="studentID" value="<?php echo $row["studentID"] ?>" required>
            </div>

            <div class="col-md-8">
              <label for="payment_status" class="form-label">Status</label>
              <select class="form-select" id="payment_status" name="payment_status" required>
                <option value="">Choose...</option>
                <option value="Paid" <?php if ($row["payment_status"] == "Paid") echo "selected"; ?>>Paid</option>
                <option value="Pending" <?php if ($row["payment_status"] == "Pending") echo "selected"; ?>>Pending</option>
                <option value="Overdue" <?php if ($row["payment_status"] == "Overdue") echo "selected"; ?>>Overdue</option>
              </select>
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