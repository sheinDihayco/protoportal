<?php
include_once 'includes/connection.php';

// Initialize database connection
$connection = new Connection();
$conn = $connection->open();

// Fetch initial data for time slots and rooms
$timeSlots = [];
$rooms = [];

try {
    $stmt = $conn->prepare("SELECT * FROM tbl_sched_time ORDER BY start_time, end_time");
    $stmt->execute();
    $timeSlots = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmt = $conn->prepare("SELECT * FROM tbl_rooms ORDER BY room_name");
    $stmt->execute();
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection->close();
?>


<!-- JavaScript for Handling Form Submissions and Data Display -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {


        // Load and display time slots
        function loadTimes() {
            $.ajax({
                url: 'includes/get-times.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        let tableContent = '';
                        data.data.forEach(function(item) {
                            tableContent += `<tr>
                            <td>${item.start_time}</td>
                            <td>${item.end_time}</td>
                            <td><button class="btn btn-primary edit-time" data-id="${item.time_id}" data-start="${item.start_time}" data-end="${item.end_time}">Edit</button></td>
                            <td><button class="btn btn-danger delete-time" data-id="${item.time_id}">Delete</button></td>
                        </tr>`;
                        });
                        $('#timesTable tbody').html(tableContent);
                    } else {
                        alert(data.message);
                    }
                }
            });
        }

        // Handle room form submission
        $('#roomForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'includes/set-rooms.inc.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#roomModal').modal('hide');
                        loadRooms(); // Refresh the rooms table

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../admin/set-slots.php'; // Redirect after confirmation
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });

        // Load and display rooms
        function loadRooms() {
            $.ajax({
                url: 'includes/get-rooms.php',
                type: 'GET',
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        let tableContent = '';
                        data.data.forEach(function(item) {
                            tableContent += `<tr>
                            <td>${item.room_name}</td>
                            <td><button class="btn btn-primary edit-room" data-id="${item.room_id}" data-name="${item.room_name}">Edit</button></td>
                            <td><button class="btn btn-danger delete-room" data-id="${item.room_id}">Delete</button></td>
                        </tr>`;
                        });
                        $('#roomsTable tbody').html(tableContent);
                    } else {
                        alert(data.message);
                    }
                }
            });
        }

        // Display edit modal with current time slot data
        $(document).on('click', '.edit-time', function() {
            const id = $(this).data('id');
            const start = $(this).data('start');
            const end = $(this).data('end');
            $('#time_id').val(id);
            $('#start_time').val(start);
            $('#end_time').val(end);
            $('#timeSlotModal').modal('show');
        });

        // Handle time slot form submission
        $('#timeSlotForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'includes/set-times.inc.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        Swal.fire({
                            title: 'Success',
                            text: data.message,
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            $('#timeSlotModal').modal('hide');
                            window.location.href = '../admin/set-slots.php'; // Redirect after success
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });


        $(document).on('click', '.delete-time', function() {
            const id = $(this).data('id');

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion if confirmed
                    $.ajax({
                        url: 'includes/delete-time.php',
                        type: 'POST',
                        data: {
                            time_id: id
                        },
                        success: function(response) {
                            const data = JSON.parse(response);
                            if (data.status === 'success') {
                                loadTimes(); // Refresh the time slots table
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirect to the set-slots.php page after clicking OK
                                    window.location.href = '../admin/set-slots.php';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        },
                        error: function() {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'There was an error processing your request. Please try again.',
                                confirmButtonText: 'OK'
                            });
                        }
                    });
                }
            });
        });


        // Edit and delete functionality for rooms
        $(document).on('click', '.edit-room', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#room_id').val(id);
            $('#room_name').val(name);
            $('#roomModal').modal('show');
        });

        // Handle room form submission
        $('#roomForm').on('submit', function(event) {
            event.preventDefault();
            $.ajax({
                url: 'includes/update-rooms.inc.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        $('#roomModal').modal('hide');
                        loadRooms(); // Refresh the rooms table

                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '../admin/set-slots.php'; // Redirect after confirmation
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                }
            });
        });


        $(document).on('click', '.delete-room', function() {
            const id = $(this).data('id');

            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Proceed with deletion if confirmed
                    $.ajax({
                        url: 'includes/delete-room.php',
                        type: 'POST',
                        data: {
                            room_id: id
                        },
                        success: function(response) {
                            const data = JSON.parse(response);
                            if (data.status === 'success') {
                                loadRooms(); // Refresh the rooms table
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Deleted!',
                                    text: data.message,
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    // Redirect to the set-slots.php page after clicking OK
                                    window.location.href = '../admin/set-slots.php';
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: data.message,
                                    confirmButtonText: 'OK'
                                });
                            }
                        }
                    });
                }
            });
        });



        // Initial load of data
        loadTimes();
        loadRooms();
    });
</script>