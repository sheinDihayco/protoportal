
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="courseModalLabel">Add Course</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #f9f9f9; padding: 30px;">
                <form id="addCourseForm">
                    <input type="hidden" name="course_id" id="course_id">
                    <div class="mb-3">
                        <label for="course_description" class="form-label">Course Description</label>
                        <input type="text" class="form-control" id="course_description" name="course_description" required>
                    </div>
                    <div class="mb-3">
                        <label for="course_year" class="form-label">Course Year</label>
                        <input type="number" class="form-control" id="course_year" name="course_year" min="1" max="12" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-success btn-lg px-5">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* Custom Modal Styles */
#courseModal .modal-content {
    border-radius: 12px;
}

#courseModal .modal-header {
    background-color: #004d00; /* Dark green header */
    color: white;
    font-weight: bold;
}

#courseModal .modal-body input, 
#courseModal .modal-body button {
    font-size: 1.1rem;
}

#courseModal .modal-body {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

</style>