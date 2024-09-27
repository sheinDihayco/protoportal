
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function enableNextField(nextFieldId) {
        var currentField = event.target;

        if (currentField.value !== "") {
            document.getElementById(nextFieldId).disabled = false;
        } else {
            document.getElementById(nextFieldId).disabled = true;
        }
    }
</script>


<script>
    function toggleSelectAll(selectAllCheckbox) {
        // Get all checkboxes with class 'student-select'
        var checkboxes = document.querySelectorAll('.student-select');

        // Loop through all checkboxes and set their checked property
        checkboxes.forEach(function(checkbox) {
            checkbox.checked = selectAllCheckbox.checked;
        });
    }
</script>


<script>
    function clearSearchForm() {
        // Clear all input fields in the form
        document.querySelectorAll('form input, form select').forEach(input => input.value = '');

        // Check if the form is empty, and hide the section if it is
        const isFormEmpty = Array.from(document.querySelectorAll('form input, form select'))
            .every(input => input.value === '');

        if (isFormEmpty) {
            const studentResult = document.querySelector('.studentResult');
            if (studentResult) {
                studentResult.style.display = 'none';
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


    .modal-content {
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }

    .modal-header {
        background-color: #007bff;
        color: white;
        border-bottom: none;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }

    .modal-title {
        font-size: 1rem;
        font-weight: bold;
    }

    .btn-close {
        filter: invert(1);
    }

    .modal-body {
        color: #333;
        padding: 20px;
        font-size: 1rem;
    }

    #eventModalDate {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 10px;
    }

    #editSubjectModal {
        font-size: 1rem;
        line-height: 1.5;
        word-wrap: break-word;
    }

    .modal-footer {
        background-color: #f1f1f1;
        border-top: none;
        padding: 10px 20px;
        border-bottom-left-radius: 8px;
        border-bottom-right-radius: 8px;
        text-align: right;
    }

    body {
        background-color: #f8f9fa;
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
