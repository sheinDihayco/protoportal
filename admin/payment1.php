<?php
include_once "../templates/header3.php";
if (!isset($_SESSION["login"])) {
    header("location:login.php?error=loginfirst");
    exit;
}

$userid = $_SESSION["login"];

$statements = $conn->prepare("SELECT * FROM tbl_users WHERE user_id = '$userid'");
$statements->execute();
$user = $statements->fetch(PDO::FETCH_ASSOC);
$fname = $user['user_fname'];
$lname = $user['user_lname'];
?>

<main id="main" class="main">
    <?php
    if (isset($_SESSION['change-pass']) && $_SESSION['change-pass']) {
        echo "
        <div class='alert'>
            <span class='closebtn' onclick='this.parentElement.style.display=\"none\";'>&times;</span>
           Password successfully changed!
        </div>
        <script>
            // Automatically close the alert after 5 seconds
            setTimeout(function() {
                document.querySelector('.alert').style.opacity = '0';
                setTimeout(function() {
                    document.querySelector('.alert').style.display = 'none';
                }, 600);
            }, 5000);
        </script>";
        unset($_SESSION['change-pass']);
    }
    ?>
    <div class="pagetitle">
        <h1>Student Records</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Student</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <!-- Left side columns -->
            <div class="col-lg-12">
                <div class="row">
                    <!-- Recent Sales -->
                    <div class="col-12">
                        <div class="card recent-sales overflow-auto">

                            <div class="filter">
                                <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                    <li class="dropdown-header text-start">
                                        <h6>Filter</h6>
                                    </li>
                                    <li><a class="dropdown-item" href="../admin/bsit-payment.php">BSIT</a></li>
                                    <li><a class="dropdown-item" href="../admin/bsba-payment.php">BSBA</a></li>
                                    <li><a class="dropdown-item" href="../admin/bsoa-payment.php">BSOA</a></li>
                                </ul>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">Students <span>| Enrolled</span></h5>

                                <table class="table table-borderless datatable">
                                    <thead>
                                        <tr>
                                            <th scope="col">Student ID</th>
                                            <th scope="col">Full Name</th>
                                            <th scope="col">Course</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $database = new Connection();
                                        $db = $database->open();

                                        try {
                                            $sql = 'SELECT * FROM tbl_students WHERE user_id = :user_id ORDER BY lname ASC';

                                            $stmt = $db->prepare($sql);
                                            $stmt->bindParam(':user_id', $userid, PDO::PARAM_INT);
                                            $stmt->execute();

                                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                                <tr>
                                                    <th scope="row"><a href="#"><?php echo htmlspecialchars($row["studentID"]); ?></a></th>
                                                    <td><?php echo htmlspecialchars($row["lname"]); ?>, <?php echo htmlspecialchars($row["fname"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["course"]); ?> - <?php echo htmlspecialchars($row["year"]); ?></td>
                                                    <td>
                                                        <form action="stud_profile.php" method="post">
                                                            <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['studentID']); ?>">
                                                            <button type="submit" class="btn btn-sm btn-success" name="submit"><i class="ri-arrow-right-circle-fill"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                        <?php
                                            }
                                        } catch (PDOException $e) {
                                            echo "There is some problem in connection: " . $e->getMessage();
                                        }

                                        $database->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div><!-- End Recent Sales -->
                </div>
            </div><!-- End Left side columns -->
        </div>
    </section>

</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>

<style>
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
        z-index: 1000;
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
</style>