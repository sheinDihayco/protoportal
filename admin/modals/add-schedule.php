<!-- Modal Section -->
<div class="modal fade" id="scheduleModal" tabindex="-1" aria-labelledby="scheduleModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="scheduleModalLabel">Create New Schedule</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color:#e6ffe6;">
            <div class="card-body p-4">
                <form id="scheduleForm" action="./includes/submit-schedule.php" method="POST">
                    <!-- Instructor Selection -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="instructor" class="form-label">Instructor</label>
                            <select id="instructor" name="instructor" class="form-select" required>
                                <option value="" disabled selected>Select an Instructor</option>
                                <?php foreach ($instructors as $instructor): ?>
                                    <option value="<?= htmlspecialchars($instructor['user_id']) ?>">
                                        <?= htmlspecialchars($instructor['name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select an instructor.</div>
                        </div>
                        <!-- Course Selection -->
                        <div class="col-md-6">
                            <label for="course" class="form-label">Course</label>
                            <select id="course" name="course" class="form-select" required>
                                <option value="" disabled selected>Select a Course</option>
                                <?php foreach ($courses as $course): ?>
                                    <option value="<?= htmlspecialchars($course['course_id']) ?>">
                                        <?= htmlspecialchars($course['description']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a course.</div>
                        </div>
                    </div>

                    <!-- Subject Selection -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="subject" class="form-label">Subject</label>
                            <select id="subject" name="subject" class="form-select" required>
                                <option value="" disabled selected>Select a Subject</option>
                                <?php foreach ($subjects as $subject): ?>
                                    <option value="<?= htmlspecialchars($subject['id']) ?>">
                                        <?= htmlspecialchars($subject['description']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a subject.</div>
                        </div>

                        <!-- Room Selection -->
                        <div class="col-md-6">
                            <label for="room" class="form-label">Room</label>
                            <select id="room" name="room" class="form-select" required>
                                <option value="" disabled selected>Select a Room</option>
                                <?php foreach ($rooms as $room): ?>
                                    <option value="<?= htmlspecialchars($room['room_id']) ?>">
                                        <?= htmlspecialchars($room['room_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a room.</div>
                        </div>
                    </div>

                    <!-- Time Slot & Day Selection -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="time" class="form-label">Time Slot</label>
                            <select id="time" name="time" class="form-select" required>
                                <option value="" disabled selected>Select a Time Slot</option>
                                <?php foreach ($times as $time): ?>
                                    <option value="<?= htmlspecialchars($time['time_id']) ?>">
                                        <?= htmlspecialchars($time['slot']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a time slot.</div>
                        </div>

                        <div class="col-md-6">
                            <label for="day" class="form-label">Day</label>
                            <select id="day" name="day" class="form-select" required>
                                <option value="" disabled selected>Select a Day</option>
                                <?php foreach ($days as $day): ?>
                                    <option value="<?= htmlspecialchars($day['day_id']) ?>">
                                        <?= htmlspecialchars($day['day_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Please select a day.</div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>