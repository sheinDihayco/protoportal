
<div class="modal fade" id="editCourseModal" tabindex="-1" aria-labelledby="editCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color:#e6ffe6;">
                <form id="editCourseForm">
                    <input type="hidden" name="course_id" id="edit_course_id">
                    <div class="mb-3">
                        <label for="edit_course_description" class="form-label">Course Description</label>
                        <input type="text" class="form-control" id="edit_course_description" name="course_description" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_course_year" class="form-label">Course Year</label>
                        <input type="number" class="form-control" id="edit_course_year" name="course_year" min="1" max="12" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>