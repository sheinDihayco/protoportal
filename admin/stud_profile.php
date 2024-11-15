<?php include_once '../PHP/stud-profile-con.php'?>

<main id="main" class="main">
  <div class="pagetitle">
    <?php if ($studs) : ?>
      <h1><?php echo htmlspecialchars($studs["lname"]); ?>, <?php echo htmlspecialchars($studs["fname"]); ?></h1>

      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><?php echo htmlspecialchars($studs["course"]); ?></li>
        </ol>
      </nav>
    <?php else : ?>
      <h1>No ID Found</h1>
    <?php endif; ?>
  </div><!-- End Page Title -->

  <section class="section profile">
    <div class="col-lg-12">
      <div class="row">
        <div class="card mt-4">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">
              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#payment-status">Payment Status</button>
              </li>
              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-grades">Grades</button>
              </li>
            </ul><!-- End Bordered Tabs -->

            <div class="tab-content pt-2">
              <!-- Payment Status -->
              <div class="tab-pane fade show active" id="payment-status">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Student ID</th>
                          <th scope="col">Semester</th>
                          <th scope="col">Payment Period</th>
                          <th scope="col">Payment Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        // Your MySQL connection code
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "schooldb";

                        $conn = new mysqli($servername, $username, $password, $dbname);
                        if ($conn->connect_error) {
                          die("Connection failed: " . $conn->connect_error);
                        }

                        $sql = 'SELECT s.*, p.*
                                FROM tbl_students s 
                                LEFT JOIN tbl_payments p ON s.user_id = p.user_id
                                WHERE s.user_id = ?';

                        if ($stmt = $conn->prepare($sql)) {
                          $stmt->bind_param("s", $studid);
                          $stmt->execute();
                          $result = $stmt->get_result();

                          while ($row = $result->fetch_assoc()) {
                            // Assign the badge based on the payment status
                            $payment_status = htmlspecialchars($row["payment_status"]);
                            $badge_class = '';

                            if ($payment_status == 'PENDING') {
                              $badge_class = 'badge-warning';
                            } elseif ($payment_status == 'PAID') {
                              $badge_class = 'badge-success';
                            } elseif ($payment_status == 'OVERDUE') {
                              $badge_class = 'badge-danger';
                            } else {
                              $badge_class = 'badge-secondary'; // Default for unknown status
                            }
                        ?>
                            <tr>
                              <th scope="row"><a href=""><?php echo htmlspecialchars($row["user_name"]); ?></a></th>
                              <td><?php echo htmlspecialchars($row["semester"]) ? htmlspecialchars($row["semester"]) : 'Choose semester'; ?></td>
                              <td><?php echo htmlspecialchars($row["paymentPeriod"]) ? htmlspecialchars($row["paymentPeriod"]) : 'Choose payment period'; ?></td>
                              <td><span class="badge <?php echo $badge_class; ?>"><?php echo $payment_status ? $payment_status : 'Not Available'; ?></span></td>
                            </tr>
                        <?php
                          }
                          $stmt->close();
                        } else {
                          echo "Error preparing statement: " . $conn->error;
                        }
                        $conn->close();
                        ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- End Payment Status -->

              <!-- Grades Overview -->
              <div class="tab-pane fade" id="profile-grades">
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th scope="col">Subject Code</th>
                          <th scope="col">Description</th>
                          <th scope="col">Prelim</th>
                          <th scope="col">Midterm</th>
                          <th scope="col">Pre-final</th>
                          <th scope="col">Final</th>
                          <th scope="col">Remarks</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        if (is_array($grades) && count($grades) > 0):
                          $grades_by_subject = [];
                          foreach ($grades as $row) {
                            if (isset($row['term']) && isset($row['grade'])) {
                              $grades_by_subject[$row['subject_code']][$row['term']] = $row['grade'];
                            }
                            if (isset($row['description'])) {
                              $grades_by_subject[$row['subject_code']]['description'] = $row['description'];
                            }
                          }

                          foreach ($grades_by_subject as $subject_code => $subject_grades): ?>
                            <tr>
                              <td><?php echo htmlspecialchars($subject_code); ?></td>
                              <td><?php echo htmlspecialchars($subject_grades['description']); ?></td>
                              <td><?php echo isset($subject_grades['Prelim']) ? htmlspecialchars($subject_grades['Prelim']) : '-'; ?></td>
                              <td><?php echo isset($subject_grades['Midterm']) ? htmlspecialchars($subject_grades['Midterm']) : '-'; ?></td>
                              <td><?php echo isset($subject_grades['Pre-final']) ? htmlspecialchars($subject_grades['Pre-final']) : '-'; ?></td>
                              <td><?php echo isset($subject_grades['Final']) ? htmlspecialchars($subject_grades['Final']) : '-'; ?></td>
                              <td>
                                <?php
                                $total_grade = 0;
                                $grade_count = 0;
                                foreach (['Prelim', 'Midterm', 'Pre-final', 'Final'] as $term) {
                                  if (isset($subject_grades[$term])) {
                                    $total_grade += $subject_grades[$term];
                                    $grade_count++;
                                  }
                                }
                               if ($grade_count > 0) {
                                      $final_grade = $total_grade / $grade_count;
                                      if ($final_grade <= 3.0) {
                                          echo '<span class="badge badge-success">PASSED</span>';
                                      } else {
                                          echo '<span class="badge badge-danger">FAILED</span>';
                                      }
                                  } else {
                                      echo '<span class="badge badge-secondary">No Grade</span>';
                                  }
                                  echo "</td></tr>";
                                ?>
                              </td>
                            </tr>
                          <?php endforeach;
                        else: ?>
                          <tr>
                            <td colspan="7">No grades found.</td>
                          </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div><!-- End Grades Overview -->

            </div>
          </div><!-- End Bordered Tabs -->
        </div>
      </div><!-- End Left side columns -->
    </div>
  </section>
</main><!-- End #main -->

<?php include_once "../templates/footer.php"; ?>

