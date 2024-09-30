

<?php
// Display a success message if a new subject was added
if (isset($_SESSION['subject_created']) && $_SESSION['subject_created']) {
  echo "
    <div class='alert alert-success'>
        <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
        New subject successfully added!
    </div>
    <script>
        setTimeout(function() {
            document.querySelector('.alert').style.opacity = '0';
            setTimeout(function() {
                document.querySelector('.alert').style.display = 'none';
            }, 600);
        }, 5000);
    </script>";
  unset($_SESSION['subject_created']);
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  // Handle the Edit Button Click
  $(document).on('click', '.btn-edit', function() {
    // Get the subject ID from the data attribute
    var subjectId = $(this).data('id');
    
    // Make an AJAX request to fetch the subject details
    $.ajax({
      url: 'includes/get_subject.php', // PHP file to fetch subject details
      type: 'GET',
      data: { id: subjectId },
      dataType: 'json',
      success: function(data) {
        // Populate the modal fields with the fetched data
        $('#edit-id').val(data.id);
        $('#edit-code').val(data.code);
        $('#edit-description').val(data.description);
        $('#edit-lec').val(data.lec);
        $('#edit-lab').val(data.lab);
        $('#edit-unit').val(data.unit);
        $('#edit-pre_req').val(data.pre_req);
        $('#edit-total').val(data.total);
        $('#edit-course').val(data.course);
        $('#edit-year').val(data.year);
        $('#edit-semester').val(data.semester);
        
        // Show the modal
        $('#editCourseModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.log("Error fetching subject data: " + error);
      }
    });

     $(document).on('click', '.btn-delete', function() {
    // Get the subject ID from the data attribute
    var subjectId = $(this).data('id');
    
    // Show a confirmation alert before proceeding with deletion
    if (confirm('Are you sure you want to delete this subject?')) {
      // If confirmed, make an AJAX request to delete the subject
      $.ajax({
        url: 'includes/delete-subject.php', // PHP file to handle deletion
        type: 'POST',
        data: { id: subjectId },
        success: function(response) {
          // Optionally reload the page or update the table to reflect changes
          alert('Subject deleted successfully.');
          location.reload(); // Reload the page to reflect changes
        },
        error: function(xhr, status, error) {
          console.log("Error deleting subject: " + error);
        }
      });
    }
  });
});
</script>


<script>
    document.getElementById('editSubjectForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    
    fetch('functions/update-subject.php', {
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
      const section = document.querySelector('.section.dashboard');
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