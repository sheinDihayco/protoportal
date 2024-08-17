    <?php
    include_once 'connection.php';

    header('Content-Type: application/json');

    // Create an instance of the Connection class
    $connClass = new Connection();
    $conn = $connClass->open();

    if (isset($_GET['schedule_id'])) {
        $schedule_id = $_GET['schedule_id'];

        $stmt = $conn->prepare("SELECT * FROM tbl_schedule WHERE schedule_id = ?");
        $stmt->execute([$schedule_id]);

        $schedule = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($schedule) {
            echo json_encode($schedule);
        } else {
            echo json_encode(['error' => 'Schedule not found']);
        }
    } else {
        echo json_encode(['error' => 'No schedule ID provided']);
    }
