<?php
include_once "../templates/header3.php";

$statements = $conn->prepare("SELECT COUNT(studentID) AS count_stud FROM tbl_students");
$statements->execute();
$studcount = $statements->fetch(PDO::FETCH_ASSOC);
?>

<main id="main" class="main">

    <section class="section dashboard">

        <!-- Student Count Card /// ILISANAN PANI-->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">

                <div class="card-body">
                    <h5 class="card-title">Subject <span>| Count</span></h5>
                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6><?php echo $studcount['count_stud'] ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- End Student Count Card -->
    </section>

</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>