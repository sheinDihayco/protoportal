
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Bootstrap CSS -->

<script>
  // Function to handle the SweetAlert and reload logic
  function handleAlert(sessionVar, icon, title, text) {
    if (sessionVar) {
      Swal.fire({
        icon: icon,
        title: title,
        text: text,
        confirmButtonText: 'OK'
      }).then((result) => {
        if (result.isConfirmed) {
          location.reload();
        }
      });
    }
  }

  // PHP embedding for the 'subject_created' session variable
  <?php if (isset($_SESSION['subject_created']) && $_SESSION['subject_created']): ?>
    handleAlert(true, 'success', 'Successful', 'The subject has been successfully created!');
    <?php unset($_SESSION['subject_created']); ?>
  <?php endif; ?>

  // PHP embedding for the 'subject_updated' session variable
  <?php if (isset($_SESSION['subject_updated']) && $_SESSION['subject_updated']): ?>
    handleAlert(true, 'success', 'Update Complete!', 'The subject has been successfully updated!');
    <?php unset($_SESSION['subject_updated']); ?>
  <?php endif; ?>
</script>


<script>
function fetchSubjectData(subjectId) {
    // Use AJAX to fetch subject data based on subjectId
    fetch('includes/get_subject.php?id=' + subjectId)
        .then(response => response.json())
        .then(data => {
            if (data) {
                // Populate the modal fields with the fetched data
                document.getElementById('edit-id').value = data.id;
                document.getElementById('edit-code').value = data.code;
                document.getElementById('edit-description').value = data.description;
                document.getElementById('edit-lec').value = data.lec;
                document.getElementById('edit-lab').value = data.lab;
                document.getElementById('edit-unit').value = data.unit;
                document.getElementById('edit-pre_req').value = data.pre_req;
                document.getElementById('edit-total').value = data.total;
                document.getElementById('edit-course').value = data.course;
                document.getElementById('edit-year').value = data.year;
                document.getElementById('edit-semester').value = data.semester;
            }
        })
        .catch(error => console.error('Error fetching subject data:', error));
}
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.btn-delete');

        deleteButtons.forEach(button => {
            button.addEventListener('click', function() {
                const subjectId = this.getAttribute('data-id');

                // SweetAlert confirmation dialog
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Send AJAX request to delete the subject
                        fetch('includes/delete_subject.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: subjectId })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Show success alert and wait for user to click 'OK' before reloading
                                Swal.fire({
                                    title: 'Deleted!',
                                    text: 'The subject has been deleted.',
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Reload the page after 'OK' button is clicked
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Error!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error!', 'An error occurred during deletion.', 'error');
                        });
                    }
                });
            });
        });
    });
</script>


<script>
    document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('includes/update_subject.php', {
      method: 'POST',
      body: formData,
    })
    .then(response => response.json())
    .then(data => {
      if (data.status === 'success') {
        Swal.fire('Success', 'Subject updated successfully!', 'success')
          .then(() => {
            location.reload();  // Reload the page or update the table dynamically
          });
      } else {
        Swal.fire('Error', 'Failed to update subject.', 'error');
      }
    })
    .catch(error => console.error('Error updating subject:', error));
  });
</script>

<script>
  function enableNextField(nextFieldId) {
    const courseField = document.getElementById('course');
    const yearField = document.getElementById('year');
    const semesterField = document.getElementById('semester');

    if (nextFieldId === 'year') {
      yearField.disabled = !courseField.value.trim();
    } else if (nextFieldId === 'semester') {
      semesterField.disabled = !yearField.value.trim();
    }
  }

  // Initialize fields based on existing values
  window.addEventListener('DOMContentLoaded', () => {
    enableNextField('year');
    enableNextField('semester');
  });
</script>

<script>
  function clearSearchForm() {
    // Clear all input fields in the form
    document.querySelectorAll('form input, form select').forEach(input => input.value = '');

    // Check if the form is empty, and hide the section if it is
    const isFormEmpty = Array.from(document.querySelectorAll('form input, form select'))
      .every(input => input.value === '');

    if (isFormEmpty) {
      const section = document.querySelector('.subjectTable');
      if (section) {
        section.style.display = 'none';
      }
    }
  }
</script>

<style>
  a {
    text-decoration: none !important;
  }

  .breadcrumb-item a {
    text-decoration: none !important;
  }

  .breadcrumb-item.active {
    text-decoration: none;
  }

  .navbar-brand {
    text-decoration: none !important;
  }

  .alert {
    padding: 20px;
    background-color: #4CAF50;
    color: white;
    opacity: 1;
    transition: opacity 0.6s;
    margin-bottom: 15px;
    border-radius: 4px;
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 5000;
    width: 300px;
  }

  .closebtn {
    margin-left: 15px;
    color: white;
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
  }

  .closebtn:hover {
    color: black;
  }
  .container {
    margin-top: 20px;
  }

  .form-group label {
    font-weight: bold;
  }

  .card-body {
    background-color: #ffffff;
    border-radius: 5px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
  }

  table {
    margin-top: 20px;
  }

  th,
  td {
    text-align: center;
  }

  .no-results {
    text-align: center;
    color: #6c757d;
    font-style: italic;
  }
</style>