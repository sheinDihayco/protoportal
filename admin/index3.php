<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/index3-php-con.php"; ?>

<main id="main" class="main" >
    <section class="section dashboard">                      
        <div class="row">
            <!-- Instructor Count Card -->
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
            <div class="col-xxl-4">
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

        <div class="row">
            <div class="col-lg-8">
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
                            <h5 class="card-title">Profile <span>| viewing</span></h5>

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
                                                <th scope="row"><a href="#"><?php echo htmlspecialchars($row["user_name"]); ?></a></th>
                                                <td><?php echo htmlspecialchars($row["lname"]); ?>, <?php echo htmlspecialchars($row["fname"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["course"]); ?> - <?php echo htmlspecialchars($row["year"]); ?></td>
                                                <td>
                                                    <form action="stud_profile.php" method="post">
                                                        <input type="hidden" name="stud_id" value="<?php echo htmlspecialchars($row['user_id']); ?>">
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

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Event List <span class="badge bg-success" style="color: white;">This month</span></h5>
                        <ul class="list-group">
                            <?php if (!empty($events)) : ?>
                                <?php foreach ($events as $event) : ?>
                                    <li class="list-group-item">
                                        <h6 class="card-title"><?php echo htmlspecialchars($event['title'] ?? 'Untitled Event'); ?>
                                            <span><?php echo htmlspecialchars($event['start_date'] ?? 'Unknown Date'); ?></span>
                                        </h6>
                                    </li>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <li class="list-group-item">No events found for the current month.</li>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>  
    </section>
</main><!-- End #main -->

<?php include_once "../PHP/index3-php-script.php"; ?>
<?php include_once "../templates/footer.php"; ?>