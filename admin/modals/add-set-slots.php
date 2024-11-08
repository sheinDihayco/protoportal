<!-- Modal Section -->
<div class="modal fade" id="timeSlotModal" tabindex="-1" aria-labelledby="timeSlotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-m">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="timeSlotModalLabel">Add Time Slot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 30px;">
                <form id="timeSlotForm">
                    <input type="hidden" name="time_id" id="time_id">
                    <!-- Start Time Input -->
                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <!-- End Time Input -->
                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-lg px-5">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Modal Styles for Time Slot */
    #timeSlotModal .modal-content {
        border-radius: 12px;
    }

    #timeSlotModal .modal-header {
        background-color: #004d00; /* Dark green header */
        color: white;
        font-weight: bold;
    }

    #timeSlotModal .modal-body input, 
    #timeSlotModal .modal-body select,
    #timeSlotModal .modal-body button {
        font-size: 1.1rem;
    }

    #timeSlotModal .modal-body {
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

</style>

