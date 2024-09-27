<!-- Optional: AJAX for dynamic updates (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Load schedules initially
        function loadSchedules() {
            $.ajax({
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var tbody = $('#scheduleTable tbody');
                    tbody.empty();
                    $.each(response, function(index, schedule) {
                        tbody.append(`
                        <tr>
                            <td>${schedule.schedule_id}</td>
                            <td>${schedule.instructor_name}</td>
                            <td>${schedule.course_description}</td>
                            <td>${schedule.subject_description}</td>
                            <td>${schedule.room_name}</td>
                            <td>${schedule.time_slot}</td>
                        </tr>
                    `);
                    });
                },
                error: function() {
                    $('#statusToast').removeClass('bg-success').addClass('bg-danger');
                    $('#toastTitle').text('Error');
                    $('#toastBody').text('Failed to load schedules.');
                    var toast = new bootstrap.Toast($('#statusToast'));
                    toast.show();
                }
            });
        }

        loadSchedules(); // Load schedules when document is ready
    });
</script>

<!-- Optional: AJAX for dynamic updates (if required) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<style>
    .formal-schedule {
        background-color: #ffffff;
        border-collapse: collapse;
        width: 100%;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .formal-schedule th,
    .formal-schedule td {
        border: 1px solid #dddddd;
        text-align: center;
        padding: 12px;
        vertical-align: middle;
    }

    .formal-schedule th {
        background-color: #2c3e50;
        color: #ffffff;
        font-weight: bold;
        font-size: 16px;
    }

    .formal-schedule td {
        font-size: 14px;
        color: #2c3e50;
        background-color: #f9f9f9;
    }

    .formal-schedule tr:nth-child(even) {
        background-color: #f1f1f1;
    }

    .formal-schedule tr:hover {
        background-color: #e1e1e1;
        cursor: pointer;
    }

    /* Styling for table header cells */
    .table th {
        font-weight: bold;
        background-color: #2c3e50;
        color: white;
    }

    /* Padding and alignment */
    .table th,
    .table td {
        padding: 15px;
        text-align: center;
        vertical-align: middle;
    }

    /* Responsive styling */
    @media (max-width: 768px) {

        .formal-schedule th,
        .formal-schedule td {
            font-size: 12px;
            padding: 8px;
        }
    }

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
</style>
