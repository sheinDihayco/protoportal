<!-- Edit Subject Modal -->
<div class="modal fade" id="editSubjectModal" tabindex="-1" aria-labelledby="editSubjectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content rounded-4 shadow-lg">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="editSubjectModalLabel">Edit Subject</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="background-color: #f9f9f9; padding: 30px;">
        <form id="editForm" action="includes/update_subject.php" method="POST">
          <!-- Hidden input field to hold the subject ID -->
          <input type="hidden" id="edit-id" name="id">
          
          <div class="row g-3">
            <div class="col-md-6">
              <label for="edit-code" class="form-label">Course Code</label>
              <input type="text" class="form-control" id="edit-code" name="code" required>
            </div>
            <div class="col-md-6">
              <label for="edit-description" class="form-label">Description</label>
              <input type="text" class="form-control" id="edit-description" name="description" required>
            </div>
            <div class="col-md-6">
              <label for="edit-lec" class="form-label">Lecture Hours</label>
              <input type="number" class="form-control" id="edit-lec" name="lec" required>
            </div>
            <div class="col-md-6">
              <label for="edit-lab" class="form-label">Lab Hours</label>
              <input type="number" class="form-control" id="edit-lab" name="lab" required>
            </div>
            <div class="col-md-6">
              <label for="edit-unit" class="form-label">Units</label>
              <input type="number" class="form-control" id="edit-unit" name="unit" step="0.1" required>
            </div>
            <div class="col-md-6">
              <label for="edit-pre_req" class="form-label">Pre-requisite</label>
              <input type="text" class="form-control" id="edit-pre_req" name="pre_req">
            </div>
            <div class="col-md-6">
              <label for="edit-total" class="form-label">Total Hours</label>
              <input type="number" class="form-control" id="edit-total" name="total" required>
            </div>

            <div class="col-md-6">
              <label for="edit-course" class="form-label">Course</label>
              <input type="text" class="form-control" id="edit-course" name="course" placeholder="(BSIT / BSBA / BSOA / ICT / ABM / HUMSS / GAS)">
            </div>

            <div class="col-md-6">
              <label for="edit-year" class="form-label">Year</label>
              <select class="form-select" id="edit-year" name="year" required>
                <option value="" selected>Select</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
            <div class="col-md-6">
              <label for="edit-semester" class="form-label">Semester</label>
              <select class="form-select" id="edit-semester" name="semester" required>
                <option value="" selected>Select</option>
                <option value="1">1st Semester</option>
                <option value="2">2nd Semester</option>
              </select>
            </div>
          </div>

          <!-- Modal Footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success btn-lg px-5">Update Subject</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- End Edit Subject Modal -->

<style>
  /* Custom Modal Styles */
  #editSubjectModal .modal-content {
    border-radius: 12px;
  }

  #editSubjectModal .modal-header {
    background-color: #004d00; /* Dark green header */
    color: white;
    font-weight: bold;
  }

  #editSubjectModal .modal-body input, 
  #editSubjectModal .modal-body textarea,
  #editSubjectModal .modal-body select,
  #editSubjectModal .modal-body button {
    font-size: 1.1rem;
  }

  #editSubjectModal .modal-body {
    border-radius: 10px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    background-color: #f9f9f9;
    padding: 30px;
  }

  /* Modal Footer */
  #editSubjectModal .modal-footer {
    border-top: 1px solid #ddd;
    background-color: #f1f1f1;
  }

  /* Styling for form labels and inputs */
  #editSubjectModal .form-label {
    font-weight: bold;
  }

  #editSubjectModal .form-control,
  #editSubjectModal .form-select {
    border-radius: 8px;
    padding: 10px;
    font-size: 1rem;
  }

  /* Adjusting button style */
  #editSubjectModal .btn-primary {
    background-color: #28a745;
    border-color: #28a745;
  }

  #editSubjectModal .btn-primary:hover {
    background-color: #218838;
    border-color: #1e7e34;
  }

  #editSubjectModal .btn-secondary {
    background-color: #6c757d;
    border-color: #6c757d;
  }

  #editSubjectModal .btn-secondary:hover {
    background-color: #5a6268;
    border-color: #545b62;
  }
</style>
