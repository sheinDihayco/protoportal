<?php include_once "../templates/header.php" ?>
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

<main id="main" class="main">

    <div class="pagetitle">
        <h1> Time Records</h1>
        <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#timeSlotModal">
        </button>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Time </li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <section class="section dashboard">
        <div class="row">

            <!-- Recent Sales -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Time <span>| Available</span></h5>

                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Start Time</th>
                                    <th scope="col">End Time</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($timeSlots as $slot): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($slot['start_time']); ?></td>
                                        <td><?php echo htmlspecialchars($slot['end_time']); ?></td>

                                        <td>
                                            <button class="btn btn-sm btn-warning ri-edit-2-fill edit-time" data-id="<?php echo $slot['time_id']; ?>" data-start="<?php echo htmlspecialchars($slot['start_time']); ?>" data-end="<?php echo htmlspecialchars($slot['end_time']); ?>"></button>

                                            <button class="btn btn-sm btn-danger ri-delete-bin-6-line delete-time" data-id="<?php echo $slot['time_id']; ?>"></button>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div><!-- End Recent Sales -->
            <div class="modal fade" id="timeSlotModal" tabindex="-1" aria-labelledby="timeSlotModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="timeSlotModalLabel">Add Time Slot</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="timeSlotForm">
                                <input type="hidden" name="time_id" id="time_id">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>
                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="end_time" name="end_time" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pagetitle">
                <h1> Room Records</h1>
                <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#roomModal">
                </button>
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                        <li class="breadcrumb-item active">Room</li>
                    </ol>
                </nav>
            </div><!-- End Page Title -->

            <!-- Recent Sales -->
            <div class="col-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title">Room <span>| Available</span></h5>

                        <table class="table table-striped datatable">
                            <thead>
                                <tr>
                                    <th scope="col">Room Name</th>
                                    <th scope="col">Action</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rooms as $room): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($room['room_name']); ?></td>
                                        <td>
                                            <button class="btn btn-sm btn-warning ri-edit-2-fill edit-room"
                                                data-id="<?php echo $room['room_id']; ?>"
                                                data-name="<?php echo htmlspecialchars($room['room_name']); ?>"></button>

                                            <button class="btn btn-sm btn-danger ri-delete-bin-6-line delete-room"
                                                data-id="<?php echo $room['room_id']; ?>"></button>
                                        </td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div><!-- End Recent Sales -->

            <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="roomModalLabel">Add Room</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="roomForm">
                                <input type="hidden" name="room_id" id="room_id">
                                <div class="mb-3">
                                    <label for="room_name" class="form-label">Room Name</label>
                                    <input type="text" class="form-control" id="room_name" name="room_name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- End Left side columns -->
    </section>
</main>


<!-- JavaScript for Handling Form Submissions and Data Display -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    $(document).ready(function() {
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
                        $('#timeSlotModal').modal('hide');
                        loadTimes(); // Refresh the time slots table
                        alert(data.message);
                        window.location.href = '../admin/set-slots.php';
                    } else {
                        alert(data.message);
                    }
                }
            });
        });

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
                        alert(data.message);
                        window.location.href = '../admin/set-slots.php';
                    } else {
                        alert(data.message);
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

        // Edit and delete functionality for time slots
        $(document).on('click', '.edit-time', function() {
            const id = $(this).data('id');
            const start = $(this).data('start');
            const end = $(this).data('end');
            $('#time_id').val(id);
            $('#start_time').val(start);
            $('#end_time').val(end);
            $('#timeSlotModal').modal('show');
        });

        $(document).on('click', '.delete-time', function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this time slot?')) {
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
                            alert(data.message);
                            window.location.href = '../admin/set-slots.php';
                        } else {
                            alert(data.message);
                        }
                    }
                });
            }
        });

        // Edit and delete functionality for rooms
        $(document).on('click', '.edit-room', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#room_id').val(id);
            $('#room_name').val(name);
            $('#roomModal').modal('show');
        });

        $(document).on('click', '.delete-room', function() {
            const id = $(this).data('id');
            if (confirm('Are you sure you want to delete this room?')) {
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
                            alert(data.message);
                            window.location.href = '../admin/set-slots.php';
                        } else {
                            alert(data.message);
                        }
                    }
                });
            }
        });

        // Initial load of data
        loadTimes();
        loadRooms();
    });
</script>
<?php include_once "../templates/footer.php" ?>