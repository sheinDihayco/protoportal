<?php include_once "../templates/header2.php"; ?>

<main id="main" class="main">
  <div class="pagetitle">
    <h1>Student Grade Records</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index2.php">Home</a></li>
        <li class="breadcrumb-item active">Grades</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title">Classes <span>| Enrolled </span></h5>
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                      <th scope="col">Student Name</th>
                                      <th scope="col">Subject Code</th>
                                      <th scope="col">Subject Description</th>
                                      <th scope="col">Semester</th>
                                      <th scope="col">Year</th>
                                      <th scope="col">Grade</th>
                                  </tr>
                                </thead>
                                 <tbody>
                                <?php
                                // Database connection
                                $pdo = new PDO('mysql:host=localhost;dbname=schooldb', 'root', '');
                                $userid = $_SESSION['login']; // Assuming this is the instructor's user ID
                                
                                // Query to fetch grades for the logged-in instructor
                                $sql = "
                                    SELECT 
                                        CONCAT(s.lname, ', ', s.fname) AS student_name,
                                        sub.code AS subject_code,
                                        sub.description AS subject_description,
                                        g.semester,
                                        g.year,
                                        g.grade
                                    FROM tbl_grades g
                                    INNER JOIN tbl_students s ON g.user_id = s.user_id
                                    INNER JOIN tbl_users u ON g.instructor_id = u.user_id
                                    INNER JOIN tbl_subjects sub ON g.id = sub.id
                                    WHERE g.instructor_id = :instructor_id
                                    ORDER BY s.user_name, sub.code, g.year, g.semester";

                                $stmt = $pdo->prepare($sql);
                                $stmt->bindParam(':instructor_id', $userid, PDO::PARAM_INT);
                                $stmt->execute();

                                // Display data in table rows
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['student_name']) . "</td>
                                            <td>" . htmlspecialchars($row['subject_code']) . "</td>
                                            <td>" . htmlspecialchars($row['subject_description']) . "</td>
                                            <td>" . htmlspecialchars($row['semester']) . "</td>
                                            <td>" . htmlspecialchars($row['year']) . "</td>
                                            <td>" . htmlspecialchars($row['grade']) . "</td>
                                          </tr>";
                                }
                                ?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include_once "../templates/footer.php"; ?>