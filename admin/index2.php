<?php
include_once "../templates/header2.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';
?>
<main id="main" class="main">

    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0 rounded-lg">
                    <div class="card-header bg-primary text-white d-flex align-items-center">
                        <span style="font-size: 3rem; margin-right: 0.5rem; margin-left: 2rem">👋</span>
                        <h5 class="card-title mb-0" style="border-radius: 3px; font-size: 1.75rem; color: white ">Welcome, <?php echo htmlspecialchars($fname); ?>!</h5>
                    </div>
                </div>
            </div>
        </div>


    </section>

</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>