<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/BSIT-con.php"; ?>

<main id="main" class="main">
  <section class="section dashboard">
    <div class="row">
      <h4 class="pagetitle text-center mb-3">BACHELOR OF SCIENCE IN INFORMATION TECHNOLOGY (BSIT)</h4>
      <h4 class="text-center">(CMO 25 S. 2015)</h4>
      <h4 class="pagetitle"><?php echo htmlspecialchars($user['lname']); ?>, <?php echo htmlspecialchars($user['fname']); ?> <?php echo htmlspecialchars($user['middleInitial']); ?></h4>
      
      <?php if (!empty($groupedSubjects)) : ?>
        <?php foreach ($groupedSubjects as $year => $semesters) : ?>
          <h6 class="pagetitle">Year: <?php echo htmlspecialchars($year); ?></h6>
          <?php foreach ($semesters as $semester => $subjects) : ?>
            <h5 class="pagetitle">Semester: <?php echo htmlspecialchars($semester); ?></h5>
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Final Grade</th>
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
                      <td><?php echo htmlspecialchars($subject['final_grade']); ?></td>
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
            </div>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php else : ?>
        <p class="text-center">No subjects found for BSIT course.</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<?php include_once "../templates/footer.php"; ?>

<style>
/* Adjust font sizes and table responsiveness */
.pagetitle {
  font-size: 1.5rem;
}

.table-responsive {
  overflow-x: auto;
}

/* Responsive adjustments */
@media (max-width: 1200px) {
  .pagetitle {
    font-size: 1.4rem;
  }
  .table thead th {
    font-size: 0.95rem;
  }
  .table tbody td {
    font-size: 0.9rem;
  }
}

@media (max-width: 992px) {
  .pagetitle {
    font-size: 1.3rem;
  }
}

@media (max-width: 768px) {
  .pagetitle {
    font-size: 1.2rem;
  }
  .table thead th,
  .table tbody td {
    font-size: 0.85rem;
  }
}

@media (max-width: 576px) {
  .pagetitle {
    font-size: 1rem;
    text-align: center;
  }
  .table thead th,
  .table tbody td {
    font-size: 0.8rem;
  }
}
</style>
