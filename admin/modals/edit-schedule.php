
<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Schedule</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color:#e6ffe6;">
                <div class="card-body p-4">
                    <form id="editScheduleForm" method="POST" action="./includes/update-schedule.php">
                        <input type="hidden" id="editScheduleId" name="schedule_id">

                        <!-- Instructor Selection -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editInstructor" class="form-label">Instructor</label>
                                <select id="editInstructor" name="instructor" class="form-select" required>
                                    <option value="" disabled selected>Select an Instructor</option>
                                    <!-- Instructor options populated dynamically -->
                                </select>
                                <div class="invalid-feedback">Please select an instructor.</div>
                            </div>
                            <!-- Course Selection -->
                            <div class="col-md-6">
                                <label for="editCourse" class="form-label">Course</label>
                                <select id="editCourse" name="course" class="form-select" required>
                                    <option value="" disabled selected>Select a Course</option>
                                    <!-- Course options populated dynamically -->
                                </select>
                                <div class="invalid-feedback">Please select a course.</div>
                            </div>
                        </div>

                        <!-- Subject Selection -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editSubject" class="form-label">Subject</label>
                                <select id="editSubject" name="subject" class="form-select" required>
                                    <option value="" disabled selected>Select a Subject</option>
                                    <!-- Subject options populated dynamically -->
                                </select>
                                <div class="invalid-feedback">Please select a subject.</div>
                            </div>
                            <!-- Room Selection -->
                            <div class="col-md-6">
                                <label for="editRoom" class="form-label">Room</label>
                                <select id="editRoom" name="room" class="form-select" required>
                                    <option value="" disabled selected>Select a Room</option>
                                    <!-- Room options populated dynamically -->
                                </select>
                                <div class="invalid-feedback">Please select a room.</div>
                            </div>
                        </div>

                        <!-- Time Slot & Day Selection -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="editTime" class="form-label">Time Slot</label>
                                <select id="editTime" name="time" class="form-select" required>
                                    <option value="" disabled selected>Select a Time Slot</option>
                                    <!-- Time slot options populated dynamically -->
                                </select>
                                <div class="invalid-feedback">Please select a time slot.</div>
                            </div>

                            <div class="col-md-6">
                                <label for="editDay" class="form-label">Day</label>
                                <select id="editDay" name="day" class="form-select" required>
                                    <option value="" disabled selected>Select a Day</option>
                                    <!-- Day options populated dynamically -->
                                </select>
                                <div class="invalid-feedback">Please select a day.</div>
                            </div>
                        </div>

                        <!-- Update Button -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
