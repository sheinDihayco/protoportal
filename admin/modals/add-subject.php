<!-- Start Modal for adding subjects -->
  <div class="modal fade" id="courseModal" tabindex="-1" aria-labelledby="courseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="courseModalLabel">Add Subject</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="background-color:#e6ffe6;">
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
       
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Add Subject</button>
            </div>
        </form>
      </div>
    </div>
  </div>
 <!-- End Modal for adding subjects -->
 