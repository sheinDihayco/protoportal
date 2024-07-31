<?php include_once "../templates/header.php"; ?>
<?php include_once 'includes/connection.php'; ?>

<?php
// Database connection
$host = 'localhost';
$dbname = 'schooldb';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Fetch data from database
$query = "SELECT * FROM tbl_subjects";
$stmt = $pdo->prepare($query);
$stmt->execute();
$courses = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<main id="main" class="main">

    <div class="modal fade" id="insertStudent" tabindex="-1">
        <div class="modal-dialog modal-dialog-right modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="upload-form-container <?php echo isset($isUploaded) && $isUploaded ? 'minimized' : ''; ?>">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="section image-upload">
        <div class="pagetitle" style="text-align:center;">
            <button type="button" class="ri-user-add-fill tablebutton" data-bs-toggle="modal" data-bs-target="#insertStudent"></button>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <table>
                            <tr>
                                <th>Subject Code</th>
                                <th>Course</th>
                                <th>Lec</th>
                                <th>Lab</th>
                                <th>Unit</th>
                                <th>Pre-requisite</th>
                            </tr>
                            <?php foreach ($courses as $course) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($course['subject_code']) ?></td>
                                    <td><?= htmlspecialchars($course['course']) ?></td>
                                    <td><?= htmlspecialchars($course['lec']) ?></td>
                                    <td><?= htmlspecialchars($course['lab']) ?></td>
                                    <td><?= htmlspecialchars($course['unit']) ?></td>
                                    <td><?= htmlspecialchars($course['pre_requisite']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->


<?php include_once "../templates/footer.php"; ?>