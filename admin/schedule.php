<?php include_once "../templates/header.php"; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['scheduleFile'])) {
    $fileTmpPath = $_FILES['scheduleFile']['tmp_name'];
    $fileName = $_FILES['scheduleFile']['name'];
    $fileSize = $_FILES['scheduleFile']['size'];
    $fileType = $_FILES['scheduleFile']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedfileExtensions = array('csv');

    if (in_array($fileExtension, $allowedfileExtensions)) {
        $uploadFileDir = './uploaded_files/';
        $dest_path = $uploadFileDir . $fileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $message = 'File is successfully uploaded.';
        } else {
            $message = 'There was some error moving the file to upload directory.';
        }
    } else {
        $message = 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions);
    }

    // Load the CSV data into an array
    $schedule = [];
    if (($handle = fopen($dest_path, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $schedule[] = $data;
        }
        fclose($handle);
    }
}
?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Upload Schedule</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Upload Schedule</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section schedule-upload">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Upload Schedule</h5>
                        <!-- Schedule Form -->
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="scheduleFile" class="form-label">Upload Schedule File (CSV)</label>
                                <input type="file" class="form-control" id="scheduleFile" name="scheduleFile" required>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>

</main><!-- End #main -->

<?php include_once "../templates/footer.php"; ?>