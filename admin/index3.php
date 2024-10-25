<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/index3-php-con.php"; ?>

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

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Instructor Count Card -->
            <div class="col-xxl-6 col-md-6">
                <div class="card info-card sales-card">
                    <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                            <li class="dropdown-header text-start">
                                <h6>Filter</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">Today</a></li>
                            <li><a class="dropdown-item" href="#">This Month</a></li>
                            <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Instructors <span>| Count</span></h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-people"></i>
                            </div>
                            <div class="ps-3">
                                <h6> <?php echo htmlspecialchars($instructorCount); ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Instructor Count Card -->

            <!-- Start Event -->
            <div class="col-xxl-6">
                    <div class="card info-card sales-card">
                        <div class="filter">
                            
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">Today's Event</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-calendar-day"></i>
                                </div>
                                <div class="ps-3">
                                    <?php if ($todaysEvent) : ?>
                                        <h6 style="font-size:12px"><?php echo htmlspecialchars($todaysEvent['start_date']); ?></h6>
                                        <li class="list-group-item d-flex justify-content-between align-items-start">
                                            <div style="flex-grow: 1;">
                                                <h6 class="card-title"><?php echo htmlspecialchars($todaysEvent['title']); ?></h6>
                                                <!--<p>Description: <?php echo htmlspecialchars($todaysEvent['description']); ?></p>-->
                                            </div>
                                        </li>
                                    <?php else : ?>
                                        <p>No events scheduled for today.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- End Event -->

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Event List <span class="badge bg-success" style="color: white;">This Month</span></h5>
                    <ul class="list-group">
                        <?php if (!empty($events)) : ?>
                            <?php foreach ($events as $event) : ?>
                                <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="card-title"><?php echo htmlspecialchars($event['title'] ?? 'Untitled Event'); ?></h6>
                                        <small class="text-muted"><?php echo htmlspecialchars($event['start_date'] ?? 'Unknown Date'); ?></small>
                                    </div>
                                    <span class="badge bg-primary rounded-pill"><?php echo htmlspecialchars($event['time'] ?? 'Time not specified'); ?></span>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li class="list-group-item">No events found for the current month.</li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

        </div><!-- End Right side columns -->

      </div>
    </section>

  </main><!-- End #main -->
<?php include_once "../templates/footer.php"; ?>