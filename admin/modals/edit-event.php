
<!-- Edit Event Modal (Dynamically Generated) -->
<?php foreach ($filteredEvents as $title => $event) : ?>
    <div class="modal fade" id="editEventModal<?php echo htmlspecialchars($event['id']); ?>" tabindex="-1" aria-labelledby="editEventModalLabel<?php echo htmlspecialchars($event['id']); ?>" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editEventModalLabel<?php echo htmlspecialchars($event['id']); ?>">Edit Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="background-color:#e6ffe6;">
                    <!-- Edit Event Form -->
                    <form action="../admin/includes/update-event.php" method="POST">
                        <input type="hidden" name="eventId" value="<?php echo htmlspecialchars($event['id']); ?>">

                        <div class="mb-3">
                            <label for="editEventTitle<?php echo htmlspecialchars($event['id']); ?>" class="form-label">Event Title</label>
                            <input type="text" class="form-control" id="editEventTitle<?php echo htmlspecialchars($event['id']); ?>" name="eventTitle" value="<?php echo htmlspecialchars($title); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="editEventStartDate<?php echo htmlspecialchars($event['id']); ?>" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="editEventStartDate<?php echo htmlspecialchars($event['id']); ?>" name="eventStartDate" value="<?php echo htmlspecialchars($event['start_date']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="editEventEndDate<?php echo htmlspecialchars($event['id']); ?>" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="editEventEndDate<?php echo htmlspecialchars($event['id']); ?>" name="eventEndDate" value="<?php echo htmlspecialchars($event['end_date']); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="editEventDescription<?php echo htmlspecialchars($event['id']); ?>" class="form-label">Event Description</label>
                            <textarea class="form-control" id="editEventDescription<?php echo htmlspecialchars($event['id']); ?>" name="eventDescription" rows="3"><?php echo htmlspecialchars($event['description']); ?></textarea>
                        </div>

                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Update Event</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<?php endforeach; ?>