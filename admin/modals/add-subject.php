<!-- Start Modal for adding subjects -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="courseModalLabel">Add Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background-color: #f9f9f9; padding: 30px;">
        <form id="addSubjectForm" action="functions/add-subject.php" method="POST">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="code" class="form-label">Course Code</label>
              <input type="text" class="form-control" id="code" name="code" required>
            </div>
            <div class="col-md-6">
              <label for="description" class="form-label">Description</label>
              <input type="text" class="form-control" id="description" name="description" required>
            </div>
            <div class="col-md-6">
              <label for="lec" class="form-label">Lecture Hours</label>
              <input type="number" class="form-control" id="lec" name="lec" required>
            </div>
            <div class="col-md-6">
              <label for="lab" class="form-label">Lab Hours</label>
              <input type="number" class="form-control" id="lab" name="lab" required>
            </div>
            <div class="col-md-6">
              <label for="unit" class="form-label">Units</label>
              <input type="number" class="form-control" id="unit" name="unit" step="0.1" required>
            </div>
            <div class="col-md-6">
              <label for="pre_req" class="form-label">Pre-requisite</label>
              <input type="text" class="form-control" id="pre_req" name="pre_req">
            </div>
            <div class="col-md-6">
              <label for="total" class="form-label">Total Hours</label>
              <input type="number" class="form-control" id="total" name="total" required>
            </div>

            <div class="col-md-6">
              <label for="course" class="form-label">Course</label>
              <input type="text" class="form-control" id="course" name="course" placeholder="(BSIT / BSBA / BSOA / ICT / ABM / HUMSS / GAS">
            </div>

            <div class="col-md-6">
              <label for="year" class="form-label">Year</label>
              <select class="form-select" id="year" name="year" required>
                <option value="" selected>Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="semester" class="form-label">Semester</label>
              <select class="form-select" id="semester" name="semester" required>
                <option value="" selected>Select</option>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>
              </select>
            </div>
          </div>
          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-lg px-5">Add Subject</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Modal for adding subjects -->

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
#courseModal .modal-body textarea,
#courseModal .modal-body select,
#courseModal .modal-body button {
    font-size: 1.1rem;
}

#courseModal .modal-body {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
    padding: 30px;
}

/* Modal Footer */
#courseModal .modal-footer {
    border-top: 1px solid #ddd;
    background-color: #f1f1f1;
}

/* Styling for form labels and inputs */
#courseModal .form-label {
    font-weight: bold;
}

#courseModal .form-control,
#courseModal .form-select {
    border-radius: 8px;
    padding: 10px;
    font-size: 1rem;
}

/* Adjusting button style */
#courseModal .btn-primary {
    background-color: #28a745;
    border-color: #28a745;
}

#courseModal .btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
}

#courseModal .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
}

#courseModal .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
}

</style>