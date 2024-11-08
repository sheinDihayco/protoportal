<!-- Add Event Modal -->
<div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="addEventModalLabel">Add New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f9f9f9; padding: 30px;">
                <!-- Event Form -->
                <form action="includes/event.inc.php" method="POST">
                    <div class="mb-3">
                        <label for="eventTitle" class="form-label">Event Title</label>
                        <input type="text" class="form-control" id="eventTitle" name="eventTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventStartDate" class="form-label">Event Start Date</label>
                        <input type="date" class="form-control" id="eventStartDate" name="eventStartDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventEndDate" class="form-label">Event End Date</label>
                        <input type="date" class="form-control" id="eventEndDate" name="eventEndDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="eventDescription" class="form-label">Event Description</label>
                        <textarea class="form-control" id="eventDescription" name="eventDescription" rows="3"></textarea>
                    </div>
                    <!-- Modal Footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-success btn-lg px-5">Add Event</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Modal Styles */
#addEventModal .modal-content {
    border-radius: 12px;
}

#addEventModal .modal-header {
    background-color: #004d00; /* Dark green header */
    color: white;
    font-weight: bold;
}

#addEventModal .modal-body input, 
#addEventModal .modal-body textarea,
#addEventModal .modal-body button {
    font-size: 1.1rem;
}

#addEventModal .modal-body {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

</style>