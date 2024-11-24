
<?php include_once "../templates/header.php"; ?>
<?php include_once "../PHP/index-php-con.php"; ?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="../admin/index.php">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

        <div class="col-lg-8">
            <div class="row">
                <!-- Employee Count Card -->
                <div class="col-xxl-4 col-md-6">
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
                            <h5 class="card-title">Employee <span>| Count</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo $empcount['count_emp']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Employee Count Card -->

                <!-- Student Count Card -->
                <div class="col-xxl-4 col-md-6">
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
                            <h5 class="card-title">Student <span>| Count</span></h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                    <i class="bi bi-people"></i>
                                </div>
                                <div class="ps-3">
                                    <h6><?php echo $studcount['count_stud']; ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Student Count Card -->

                 <!-- Start Event -->
                <div class="col-xxl-4 col-md-6">
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
                            <h5 class="card-title">Today's Event</h5>
                            <div class="d-flex align-items-center">
                                <div class="ps-3">
                                    <?php if ($todaysEvent) : ?>
                                        <h6 style="font-size:12px"><?php echo htmlspecialchars($todaysEvent['start_date']); ?></h6>
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <div style="flex-grow: 1;">
                                                <h6 class="card-title" style="font-size: 27px;"><?php echo htmlspecialchars($todaysEvent['title']); ?></h6>
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

                <!-- Student Report -->
                <div class="card mt-4">
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

                  <div class="card-body pb-0">
                    <h5 class="card-title">Student Report <span>| This Month</span></h5>

                    <div id="studentChart" style="min-height: 400px;" class="echart"></div>

                    <?php
                    // Connect to the database
                    $dsn = 'mysql:host=localhost;dbname=schooldb;charset=utf8mb4';
                    $username = 'root';
                    $password = '';
                    try {
                      $pdo = new PDO($dsn, $username, $password);
                      $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                      // Query data for each department or category
                      $stmt = $pdo->query("SELECT course, COUNT(*) as count FROM tbl_students GROUP BY course");
                      $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                      // Prepare data for chart
                      $course = [];
                      $studentCounts = [];
                      foreach ($data as $row) {
                        $course[] = $row['course'];
                        $studentCounts[] = (int) $row['count'];
                      }
                    } catch (PDOException $e) {
                      echo "Database error: " . $e->getMessage();
                    }
                    ?>

                   <script>
                    document.addEventListener("DOMContentLoaded", () => {
                      const course = <?php echo json_encode($course); ?>;
                      const studentCounts = <?php echo json_encode($studentCounts); ?>;

                      // Initialize the chart on the correct element
                      var studentChart = echarts.init(document.querySelector("#studentChart"));
                      
                      studentChart.setOption({
                        title: {
                          text: 'Number of Students per Department'
                        },
                        tooltip: {},
                        xAxis: {
                          type: 'category',
                          data: course
                        },
                        yAxis: {
                          type: 'value'
                        },
                        series: [{
                          name: 'Students',
                          type: 'bar',
                          data: studentCounts,
                          itemStyle: {
                            normal: {
                              color: function(params) {
                                const colors = [
                                  'rgba(255, 99, 132, 0.6)',
                                  'rgba(255, 159, 64, 0.6)',
                                  'rgba(255, 205, 86, 0.6)',
                                  'rgba(75, 192, 192, 0.6)',
                                  'rgba(54, 162, 235, 0.6)',
                                  'rgba(153, 102, 255, 0.6)',
                                  'rgba(201, 203, 207, 0.6)'
                                ];
                                return colors[params.dataIndex % colors.length];
                              },
                              borderColor: function(params) {
                                const borderColors = [
                                  'rgb(255, 99, 132)',
                                  'rgb(255, 159, 64)',
                                  'rgb(255, 205, 86)',
                                  'rgb(75, 192, 192)',
                                  'rgb(54, 162, 235)',
                                  'rgb(153, 102, 255)',
                                  'rgb(201, 203, 207)'
                                ];
                                return borderColors[params.dataIndex % borderColors.length];
                              },
                              borderWidth: 1 // Adjusted for stronger visibility
                            }
                          },
                          barWidth: '55%'
                        }]
                      });
                    });
                  </script>
                  </div>
                </div><!-- End Student Report -->
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Event List -->
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
            </div><!-- End Event List -->

        </div>
    </div>

  </section>

</main><!-- End #main -->

<?php include_once "../templates/footer.php"; ?>