<?php include_once "../templates/header.php" ?>

<main id="main" class="main">

    <div class="pagetitle">
        <h1>School Calendar</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Calendar</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section calendar">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">School Events</h5>
                        <!-- Embed Google Calendar here -->
                        <iframe src="https://calendar.google.com/calendar/embed?src=your_calendar_id&ctz=your_time_zone" style="border: 0" width="100%" height="600" frameborder="0" scrolling="no"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

</main><!-- End #main -->

<?php include_once "../templates/footer.php" ?>