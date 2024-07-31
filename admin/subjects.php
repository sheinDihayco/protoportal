<?php include_once "../templates/header.php"; ?>
<?php include_once 'includes/connection.php'; ?>

<?php
$connection = new Connection();
$pdo = $connection->open();
$message = "";
$isUploaded = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['front_image']) && isset($_FILES['back_image']) && isset($_POST['course'])) {
        $uploadFileDir = './uploaded_files/';
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        $frontImageTmpPath = $_FILES['front_image']['tmp_name'];
        $frontImageName = uniqid() . '_' . $_FILES['front_image']['name']; // Unique name to avoid conflicts
        $frontImagePath = $uploadFileDir . $frontImageName;

        $backImageTmpPath = $_FILES['back_image']['tmp_name'];
        $backImageName = uniqid() . '_' . $_FILES['back_image']['name']; // Unique name to avoid conflicts
        $backImagePath = $uploadFileDir . $backImageName;

        $course = $_POST['course'];

        $frontImageExtension = strtolower(pathinfo($frontImageName, PATHINFO_EXTENSION));
        $backImageExtension = strtolower(pathinfo($backImageName, PATHINFO_EXTENSION));

        if (in_array($frontImageExtension, $allowedfileExtensions) && in_array($backImageExtension, $allowedfileExtensions)) {
            // Generate unique identifiers for the images
            $frontImageHash = hash_file('md5', $frontImageTmpPath);
            $backImageHash = hash_file('md5', $backImageTmpPath);

            // Check if the image already exists in the database
            $sqlCheck = "SELECT COUNT(*) FROM tbl_image WHERE front_image_hash = :front_image_hash AND back_image_hash = :back_image_hash";
            $stmtCheck = $pdo->prepare($sqlCheck);
            $stmtCheck->execute([
                ':front_image_hash' => $frontImageHash,
                ':back_image_hash' => $backImageHash
            ]);
            $imageExists = $stmtCheck->fetchColumn();

            if ($imageExists == 0) {
                if (move_uploaded_file($frontImageTmpPath, $frontImagePath) && move_uploaded_file($backImageTmpPath, $backImagePath)) {
                    // Save the file paths, hashes, and course into the database
                    $sql = "INSERT INTO tbl_image (front_image_path, back_image_path, front_image_hash, back_image_hash, course) VALUES (:front_image_path, :back_image_path, :front_image_hash, :back_image_hash, :course)";
                    $stmt = $pdo->prepare($sql);
                    $stmt->execute([
                        ':front_image_path' => $frontImagePath,
                        ':back_image_path' => $backImagePath,
                        ':front_image_hash' => $frontImageHash,
                        ':back_image_hash' => $backImageHash,
                        ':course' => $course
                    ]);
                    $message = 'Files are successfully uploaded and saved to the database.';
                    $uploadedFrontImagePath = $frontImagePath;
                    $uploadedBackImagePath = $backImagePath;
                    $isUploaded = true;
                } else {
                    $message = 'There was an error moving the files to the upload directory.';
                }
            } else {
                $message = 'This image has already been uploaded.';
            }
        } else {
            $message = 'Upload failed. Allowed file types: ' . implode(', ', $allowedfileExtensions);
        }
    } elseif (isset($_POST['delete_image'])) {
        $frontImagePath = $_POST['delete_front_image'];
        $backImagePath = $_POST['delete_back_image'];

        // Delete the image record from the database
        $sql = "DELETE FROM tbl_image WHERE front_image_path = :front_image_path AND back_image_path = :back_image_path";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':front_image_path' => $frontImagePath,
            ':back_image_path' => $backImagePath
        ]);

        // Delete the image files from the server
        if (file_exists($frontImagePath)) {
            unlink($frontImagePath);
        }
        if (file_exists($backImagePath)) {
            unlink($backImagePath);
        }
        $message = 'Images deleted successfully.';
        unset($uploadedFrontImagePath, $uploadedBackImagePath);
    }
}

// Fetch the latest uploaded images
$sql = "SELECT * FROM tbl_image ORDER BY id DESC LIMIT 1";
$stmt = $pdo->query($sql);
$image = $stmt->fetch(PDO::FETCH_ASSOC);
if ($image) {
    $uploadedFrontImagePath = $image['front_image_path'];
    $uploadedBackImagePath = $image['back_image_path'];
    $course = $image['course'];
}

$connection->close();
?>




<main id="main" class="main">

    <div class="modal fade" id="insertStudent" tabindex="-1">
        <div class="modal-dialog modal-dialog-right modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="upload-form-container <?php echo isset($isUploaded) && $isUploaded ? 'minimized' : ''; ?>">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="course" class="form-label">Course</label>
                                <input type="text" class="form-control" id="course" name="course" required>
                            </div>
                            <div class="mb-3">
                                <label for="front_image" class="form-label">Upload Front Image (JPG, PNG, GIF)</label>
                                <input type="file" class="form-control" id="front_image" name="front_image" required>
                            </div>
                            <div class="mb-3">
                                <label for="back_image" class="form-label">Upload Back Image (JPG, PNG, GIF)</label>
                                <input type="file" class="form-control" id="back_image" name="back_image" required>
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary">Upload</button>
                        </form>
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
                        <!-- Image Upload Form -->
                        <?php if (isset($uploadedFrontImagePath) && isset($uploadedBackImagePath)) : ?>
                            <div class="mt-4">
                                <div class="image-container">
                                    <img id="frontImage" src="<?php echo htmlspecialchars($uploadedFrontImagePath); ?>" alt="Front Image" class="img-fluid">
                                    <img id="backImage" src="<?php echo htmlspecialchars($uploadedBackImagePath); ?>" alt="Back Image" class="img-fluid" style="display:none;">
                                </div>
                                <div class="button-group mt-2">
                                    <button id="flipButton" class="btn btn-sm btn-secondary"><i class="ri-arrow-go-back-fill"></i></button>

                                    <form action="" method="POST" class="delete-form">
                                        <input type="hidden" name="delete_front_image" value="<?php echo htmlspecialchars($uploadedFrontImagePath); ?>">
                                        <input type="hidden" name="delete_back_image" value="<?php echo htmlspecialchars($uploadedBackImagePath); ?>">
                                        <button type="submit" name="delete_image" class="btn btn-sm btn-danger"><i class="ri-delete-bin-6-line"></i></button>
                                    </form>
                                    <button id="nextButton" class="btn btn-sm btn-secondary">
                                        <i class="ri-arrow-right-fill"></i>
                                    </button>

                                </div>

                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main><!-- End #main -->

<style>
    .upload-form-container {
        perspective: 1000px;
    }

    .upload-form {
        width: 300px;
        /* Set width */
        height: 200px;
        /* Set height */
        position: relative;
        transform-style: preserve-3d;
        /* Allows 3D transformation */
        transition: transform 0.6s ease;
        /* Smooth transition for the flip effect */
    }

    .upload-form-container:hover .upload-form {
        transform: rotateY(180deg);
        /* Flips the element on hover */
    }

    .upload-form .front,
    .upload-form .back {
        position: absolute;
        width: 100%;
        height: 100%;
        backface-visibility: hidden;
        /* Hides the back side when facing away */
    }

    .upload-form .back {
        transform: rotateY(180deg);
        /* Rotates the back side */
        background: #f0f0f0;
        /* Customize background color as needed */
    }

    .upload-form .front {
        background: #fff;
        /* Customize background color as needed */
    }

    .upload-form-container.minimized {
        position: fixed;
        top: 10%;
        right: 0;
        width: 300px;
        padding: 10px;
        border: 1px solid #ddd;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #fff;
    }

    .image-container {
        position: relative;
        width: 100%;
        max-width: 816px;
        height: 1238px;
        margin: auto;
    }

    .image-container img {
        width: 100%;
        height: 100%;
        padding: 10px;
    }

    .button-group {
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .delete-form {
        display: inline;
    }

    .modal-dialog-right {
        position: fixed;
        top: 0;
        right: 0;
        margin: 1rem;
        max-width: 100%;
        height: auto;
        pointer-events: none;
    }

    .modal.fade .modal-dialog-right {
        transform: translate(0, 0);
    }

    .modal-content {
        pointer-events: auto;
    }
</style>
<script>
    // Ensure the modal is positioned correctly when shown
    $('#insertStudent').on('shown.bs.modal', function() {
        $(this).find('.modal-dialog').css({
            'top': '10%',
            'right': '10%',
            'position': 'fixed',
            'margin': '0'
        });
    });
</script>
<script>
    document.getElementById('flipButton').addEventListener('click', function() {
        var frontImg = document.getElementById('frontImage');
        var backImg = document.getElementById('backImage');
        if (frontImg.style.display === "none") {
            frontImg.style.display = "block";
            backImg.style.display = "none";
        } else {
            frontImg.style.display = "none";
            backImg.style.display = "block";
        }
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var imageDisplay = document.getElementById('imageDisplay');
        var nextButton = document.getElementById('nextButton');

        // Array of image URLs. Replace this with your actual image URLs fetched from the database.
        var images = [
            '../',
            'path/to/image2.jpg',

        ];

        var currentIndex = 0;

        // Function to update the displayed image
        function updateImage() {
            imageDisplay.src = images[currentIndex];
        }

        // Initialize with the first image
        updateImage();

        // Event listener for the Next button
        nextButton.addEventListener('click', function() {
            currentIndex = (currentIndex + 1) % images.length;
            updateImage();
        });
    });
</script>
<?php include_once "../templates/footer.php"; ?>