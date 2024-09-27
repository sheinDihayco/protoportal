<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/BSIT-con.php"; ?>

<main id="main" class="main" >
  <section class="section dashboard">
    <div class="row">
      <h4 class="pagetitle text-center mb-3">BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY (BSIT)</h4>
      <h4 class="text-center">(CMO 25 S. 2015)</h4>
      <h4 class=" pagetitle"><?php echo htmlspecialchars($user['lname']); ?> , <?php echo htmlspecialchars($user['fname']); ?> <?php echo htmlspecialchars($user['middleInitial']); ?> </h4>
      <?php if (!empty($groupedSubjects)) : ?>
        <?php foreach ($groupedSubjects as $year => $semesters) : ?>
          <h6 class="pagetitle">Year: <?php echo htmlspecialchars($year); ?></h6>
          <?php foreach ($semesters as $semester => $subjects) : ?>
            <h5 class="pagetitle">Semester: <?php echo htmlspecialchars($semester); ?></h5>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Course Code</th>
                  <th>Course Title/Description</th>
                  <th>Lec</th>
                  <th>Lab</th>
                  <th>Units</th>
                  <th>Pre-req/Co</th>
                  <th>Total Hrs/Wk</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($subjects as $subject) : ?>
                  <tr>
                    <td><?php echo htmlspecialchars($subject['code']); ?></td>
                    <td><?php echo htmlspecialchars($subject['description']); ?></td>
                    <td><?php echo htmlspecialchars($subject['lec']); ?></td>
                    <td><?php echo htmlspecialchars($subject['lab']); ?></td>
                    <td><?php echo htmlspecialchars($subject['unit']); ?></td>
                    <td><?php echo htmlspecialchars($subject['pre_req']); ?></td>
                    <td><?php echo htmlspecialchars($subject['total']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php else : ?>
        <p>No subjects found for BSIT course.</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php include_once "../templates/footer.php"; ?>