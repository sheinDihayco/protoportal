<div class="modal fade" id="insertPayment" tabindex="-1" aria-labelledby="insertPaymentLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="insertPaymentLabel">Insert Payment</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background-color: #f9f9f9; padding: 30px;">
        <!-- Ensure form action points to the correct PHP script -->
        <form action="../admin/upload/insert-payment-status.php" method="POST" novalidate>
          <div class="row mb-3">
            <div class="col-md-4">
              <label for="user_name" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="user_name" name="user_name" placeholder="Enter Student ID" value="<?php echo htmlspecialchars($studs["user_name"]); ?>" readonly>
              <div class="invalid-feedback">Please provide a valid Student ID.</div>
            </div>
            <div class="col-md-4">
              <label for="semester" class="form-label">Semester</label>
              <select class="form-select" id="semester" name="semester" required>
                <option value="" disabled selected>Select a semester</option>
                <option value="1st">1st</option>
                <option value="2nd">2nd</option>
              </select>
              <div class="invalid-feedback">Please select a semester.</div>
            </div>
            <div class="col-md-4">
              <label for="paymentPeriod" class="form-label">Payment Period</label>
              <select class="form-select" id="paymentPeriod" name="paymentPeriod" required>
                <option value="" disabled selected>Select a payment period</option>
                <option value="Prelim">Prelim</option>
                <option value="Midterm">Midterm</option>
                <option value="Pre-final">Pre-final</option>
                <option value="Final">Final</option>
              </select>
              <div class="invalid-feedback">Please select a payment period.</div>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="payment_status" class="form-label">Status</label>
              <select class="form-select" id="payment_status" name="payment_status" required>
                <option value="" disabled selected>Select status</option>
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Overdue">Overdue</option>
              </select>
              <div class="invalid-feedback">Please select a status.</div>
            </div>
          </div>
          <div class="d-flex justify-content-end">
            <!-- Ensure submit button has name="submit" -->
            <button type="submit" name="submit" class="btn btn-success btn-lg px-5">Insert Payment</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<style>
  /* Custom Modal Styles for Insert Payment */
    #insertPayment .modal-content {
        border-radius: 12px;
    }

    #insertPayment .modal-header {
        background-color: #004d00; /* Dark green header */
        color: white;
        font-weight: bold;
    }

    #insertPayment .modal-body input, 
    #insertPayment .modal-body select,
    #insertPayment .modal-body button {
        font-size: 1.1rem;
    }

    #insertPayment .modal-body {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 40px; /* Increased padding for more space inside */
    }

    /* Optional: Adjust the size of the modal for even larger view */
    .modal-lg .modal-content {
        width: 85%; /* You can adjust the width as needed */
    }
</style>
