<div class="modal fade" id="editLeave<?php echo $row["lvs_id"]?>" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Leave Update</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="card">
            <div class="card-body">
              <h5 class="card-title">Leave Update Form</h5>


<!-- Horizontal Form -->
<!-- Update the IDs in your modal form -->
<form action="functions/leave_update.php" method="post">
    <input type="hidden" value='<?php echo $row["lvs_id"]?>' name="leave_id">
    <input type="hidden" value="<?php echo $emps["employee_id"]?>" name="empid">
    <div class="col-12">
        <div class="row mb-4">
            <label for="leaveType" class="col-sm-3 col-form-label">Leave Type</label>
            <div class="col-sm-8">
                <select class="form-select" id="leaveType" name="leaveType" required>
                    <option selected disabled value="">Choose...</option>
                    <?php
                    $leaveTypes = ["Sick Leave", "Vacation Leave"]; // Add more leave types as needed
                    foreach ($leaveTypes as $leaveType) {
                        $selected = ($leaveType == $row["leave_type"]) ? "selected" : "";
                        echo "<option value=\"$leaveType\" $selected>$leaveType</option>";
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="row mb-4">
            <label for="editStartDate" class="col-sm-3 col-form-label">Date Start</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" id="editStartDate" name="startDate" required value="<?php echo $row["leave_start"]; ?>">
            </div>
        </div>

        <div class="row mb-4">
            <label for="editEndDate" class="col-sm-3 col-form-label">Date End</label>
            <div class="col-sm-8">
                <input type="date" class="form-control" id="editEndDate" name="endDate" required value="<?php echo $row["leave_end"]; ?>">
            </div>
        </div>

        <div class="row mb-4">
            <label for="editLeaveDuration" class="col-sm-3 col-form-label">Duration</label>
            <div class="col-sm-8">
                <input type="text" class="form-control" id="editLeaveDuration" name="leaveDuration" value="<?php echo $row["leave_duration"]?>" readonly>
            </div>
        </div>

        <div class="col-12 d-flex justify-content-end">
            <button type="submit" class="btn btn-primary" type="submit" name="submit">Update Record</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
</form>


<script>
    function calculateLeaveDuration() {
        const startDate = new Date(document.getElementById('editStartDate').value);
        const endDate = new Date(document.getElementById('editEndDate').value);

        // Check if both start and end dates are selected
        if (startDate && endDate && startDate <= endDate) {
            // Calculate the difference in days
            const timeDifference = endDate - startDate;
            const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)) + 1;

            // Update the leave duration input
            document.getElementById('editLeaveDuration').value = daysDifference;
            validateLeaveDuration();
        } else {
            // Clear the duration if the dates are not valid
            document.getElementById('editLeaveDuration').value = '';
            validateLeaveDuration();
        }
    }

    function disablePastDates() {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('editStartDate').min = today;
        document.getElementById('editEndDate').min = today;
    }

    function validateLeaveDuration() {
        // Add any validation logic needed for leave duration
    }

    // Attach the function to the change event of Date Start and Date End inputs
    document.getElementById('editStartDate').addEventListener('change', function () {
        // Set the minimum allowed date for Date End to the selected Date Start
        document.getElementById('editEndDate').min = document.getElementById('editStartDate').value;
        calculateLeaveDuration();
    });

    document.getElementById('editEndDate').addEventListener('change', calculateLeaveDuration);

    // Call the function to disable past dates when the page loads
    disablePastDates();
</script>


            </div>
          </div>
    </div>
  </div>
</div>

