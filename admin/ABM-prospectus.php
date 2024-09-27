<?php include_once "../templates/header3.php"; ?>
<?php include_once "../PHP/ABM-con.php"; ?>

<main id="main" class="main">
  <section class="section dashboard">
    <div class="row">
      <h4 class="pagetitle text-center mb-3"> ACCOUNTANCY AND BUSINESS MANAGEMENT</h4>
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
                  <th>Pre-req/Co</th>
                  <th>Total Hrs/Wk</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($subjects as $subject) : ?>
                  <tr>
                    <td><?php echo htmlspecialchars($subject['code']); ?></td>
                    <td><?php echo htmlspecialchars($subject['description']); ?></td>
                    <td><?php echo htmlspecialchars($subject['pre_req']); ?></td>
                    <td><?php echo htmlspecialchars($subject['total']); ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endforeach; ?>
        <?php endforeach; ?>
      <?php else : ?>
        <p>No subjects found for ABM course.</p>
      <?php endif; ?>
    </div>
  </section>
</main>


<style>
  main {
    line-height: 1.6;
    color: #333;
    margin: 0;
    padding: 20px;
    background-color: #f4f4f4;
  }

  .section {
    padding: 20px;
    border: 1px solid #dcdcdc;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
  }

  .dashboard {
    max-width: 1200px;
    margin: auto;
  }

  h6 {
    font-size: 1.4rem;
    color: #004080;
    /*border-bottom: 1px solid #e0e0e0;*/
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-weight: bold;
  }

  h4 {
    font-size: 1.4rem;
    color: #004080;
    /*border-bottom: 1px solid #e0e0e0;*/
    padding-bottom: 10px;
    margin-bottom: 20px;
    font-weight: bold;
  }

  table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
  }

  th,
  td {
    padding: 12px;
    text-align: left;
    border: 1px solid #e0e0e0;
  }

  th {
    background-color: #f5f5f5;
    color: #333;
    font-weight: bold;
    text-align: center;
  }

  tbody tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  tbody tr:hover {
    background-color: #f1f1f1;
  }

  p {
    font-size: 1.2rem;
    color: #666;
  }
</style>

<?php include_once "../templates/footer.php"; ?>