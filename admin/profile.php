<?php


$_SESSION['emp'] = $_POST["emps_id"];


if (isset($_SESSION['emp']) && !empty($_SESSION['emp'])) {
  $empid = $_SESSION['emp'];
} else {
  header("location:compensation.php?error=nofile");
}


?>

<?php
include_once "../templates/header.php";
include_once "includes/connect.php";
include_once 'includes/connection.php';



$statement = $conn->prepare("SELECT * FROM tbl_employee WHERE employee_id = :eid");
$statement->bindParam(':eid', $empid);
$statement->execute();
$emps = $statement->fetch(PDO::FETCH_ASSOC);

$statement1 = $conn->prepare("SELECT * FROM tbl_compensation WHERE employee_id = :eid");
$statement1->bindParam(':eid', $empid);
$statement1->execute();


if ($statement1) {
  $comps = $statement1->fetch(PDO::FETCH_ASSOC);

  if (!$comps) {
    // If the result set is empty, set default values or handle it accordingly
    $comps = array(
      'basic_pay' => '0.0',
      'sss' => '0.0',
      'pagibig' => '0.0',
      'philhealth' => '0.0'
    );
  }
} else {
  // Handle the error, for example, redirect to an error page
  die("Error fetching compensation data.");
}

$statement2 = $conn->prepare("SELECT * FROM tbl_borrows WHERE employee_id = :eid");
$statement2->bindParam(':eid', $empid);
$statement2->execute();
$borr = $statement2->fetch(PDO::FETCH_ASSOC);;


$statement3 = $conn->prepare("SELECT employee_id, 
                            SUM(CASE WHEN status = 'Credit' 
                            THEN amount ELSE -amount END) AS total_balance
                            FROM tbl_borrows
                            WHERE employee_id = :eid
                            GROUP BY employee_id");
$statement3->bindParam(':eid', $empid);
$statement3->execute();
$bal = $statement3->fetch(PDO::FETCH_ASSOC);

$stat = 'Approved';

$statement4 = $conn->prepare("SELECT 
                            COUNT(lvs_id) AS num_leave
                            FROM tbl_leave
                            WHERE employee_id = :eid
                            AND leave_status = :stat
                            GROUP BY employee_id");
$statement4->bindParam(':eid', $empid);
$statement4->bindParam(':stat', $stat);
$statement4->execute();
$lvs = $statement4->fetch(PDO::FETCH_ASSOC);

if (is_array($lvs) && isset($lvs['num_leave'])) {
  // Access the array element safely
  $numLeave = $lvs['num_leave'];

  // Use $numLeave in your code as needed
} else {
  // Handle the case where $lvs is not an array or 'num_leave' key doesn't exist
  // For example, set a default value or show an error message
  $numLeave = 0; // Default value
  // or
  // echo "Error: Unable to retrieve the number of leaves.";
}


?>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // ... (your existing code)

    const absentInput = document.getElementById('absent');
    const daysInMonthInput = document.getElementById('daysInMonth');
    const grossSalaryInput = document.getElementById('yourNumberInputId');
    const absTotalInput = document.getElementById('abs_total');
    const lateInput = document.getElementById('late');
    const lateTotalInput = document.getElementById('late_total');

    // Function to calculate and update the total
    function updateTotal() {
      // Get the values from the inputs
      const daysInMonth = parseFloat(daysInMonthInput.value);
      const grossSalary = parseFloat(grossSalaryInput.value);
      const absents = parseFloat(absentInput.value);

      // Calculate the total for "Number of Absents"
      const absTotal = (grossSalary / daysInMonth) * absents;

      // Update the "Total" input for "Number of Absents"
      absTotalInput.value = isNaN(absTotal) ? '' : absTotal.toFixed(2); // Adjust the precision as needed
    }

    // Function to calculate and update the late total
    function updateLateTotal() {
      // Get the values from the inputs
      const daysInMonth = parseFloat(daysInMonthInput.value);
      const grossSalary = parseFloat(grossSalaryInput.value);
      const lateMinutes = parseFloat(lateInput.value);

      // Calculate the total for "Late"
      const lateTotal = (grossSalary / (daysInMonth * 8 * 60)) * lateMinutes;

      // Update the "Total" input for "Late"
      lateTotalInput.value = isNaN(lateTotal) ? '' : lateTotal.toFixed(2); // Adjust the precision as needed
    }

    // Add event listeners for the "Number of Absents" and "Late" inputs
    absentInput.addEventListener('input', updateTotal);
    lateInput.addEventListener('input', updateLateTotal);

    // ... (the rest of your existing code)
  });
</script>





<script>
  document.addEventListener('DOMContentLoaded', function() {
    // ... (your existing code)

    // Add an event listener to update the number of days and enable/disable input fields when the month changes
    monthInput.addEventListener('change', function() {
      updateDays(); // Call the function to update the number of days

      const selectedMonth = new Date(monthInput.value).getMonth() + 1; // Note: Months are zero-indexed
      const absentInput = document.getElementById('absent');
      const lateInput = document.getElementById('late');

      // Enable or disable the "Number of Absents" input based on the selected month
      if (selectedMonth >= 1 && selectedMonth <= 12 /* December */ ) {
        absentInput.removeAttribute('disabled');
        absentInput.value = '0';
        lateInput.removeAttribute('disabled');
        lateInput.value = '0';
      } else {
        absentInput.setAttribute('disabled', true);
        absentInput.value = '0'; // Clear the input value when disabled
        lateInput.setAttribute('disabled', true);
        lateInput.value = '0'; // Clear the input value when disabled
      }

      // Add similar logic for other input fields as needed
    });

    // Trigger the change event to initialize the number of days and enable/disable input fields
    monthInput.dispatchEvent(new Event('change'));
  });

  function updateDays() {
    const monthInput = document.getElementById('monthInput');
    const daysInMonthInput = document.getElementById('daysInMonth');

    // Get the selected month and year from the input value
    const selectedDate = new Date(monthInput.value);
    const selectedYear = selectedDate.getFullYear();
    const selectedMonth = selectedDate.getMonth() + 1; // Note: Months are zero-indexed

    // Calculate the number of days in the selected month
    const daysInSelectedMonth = new Date(selectedYear, selectedMonth, 0).getDate();

    // Subtract the number of Sundays in the month
    const sundaysCount = countSundays(selectedYear, selectedMonth);
    const daysAfterSubtractingSundays = daysInSelectedMonth - sundaysCount;

    // Update the number of days input
    daysInMonthInput.value = daysAfterSubtractingSundays;
  }

  // Function to count the number of Sundays in a month
  function countSundays(year, month) {
    const firstDay = new Date(year, month - 1, 1);
    const lastDay = new Date(year, month, 0);
    let count = 0;

    for (let day = firstDay; day <= lastDay; day.setDate(day.getDate() + 1)) {
      if (day.getDay() === 0) {
        count++;
      }
    }

    return count;
  }
</script>

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
    // Programmatically click the "Edit Profile" tab
    document.querySelector('.nav-link[data-bs-target="#payouts"]').click();
});
</script> -->



<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Check if the URL contains the query parameter for success or error
    if (window.location.search.includes('error=success') || window.location.search.includes('error=error') || window.location.search.includes('error=exceed') || window.location.search.includes('error=exist')) {
      // Display the success or error alert
      showStatusAlert();

      // Add event listener to the close button
      document.getElementById('statusAlertClose').addEventListener('click', function() {
        // Remove the query parameter from the URL without triggering a page reload
        window.history.replaceState({}, document.title, window.location.pathname);
      });
    }
  });

  function showStatusAlert() {
    // Add your code to display the success or error alert here
    // For example, using Bootstrap's alert component
    // You can replace this with your own alert implementation
    var statusAlert = document.getElementById('statusAlert');
    statusAlert.style.display = 'block';
  }
</script>


<main id="main" class="main">

  <div class="pagetitle">
    <h1><?php echo $emps["last_name"] ?>, <?php echo $emps["first_name"] ?></h1>
    <!-- <button type="button" class="btn btn-primary btn-sm tablebutton" data-bs-toggle="modal" data-bs-target="#verticalycentered">
          Add Employee
        </button> -->

    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><?php echo $emps["job_title"] ?></li>
      </ol>
    </nav>
  </div><!-- End Page Title -->


  <?php
  // Other code...

  // Check if the error parameter is set in the URL
  if (isset($_GET['error'])) {
    $errorMessage = '';

    // Check the value of the error parameter and set the appropriate message
    switch ($_GET['error']) {
      case 'exceed':
        $errorMessage = 'Error: The debit amount cannot exceed the credit amount';
        break;

      case 'exist':
        $errorMessage = 'Error: Payroll period already added.';
        break;
        // Add more cases as needed

      default:
        // Handle other error cases or do nothing
        break;
    }

    // Display the alert if there is an error message
    if ($errorMessage !== '') {
      echo '
        <div id="statusAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-octagon me-1"></i>
            ' . $errorMessage . '
            <button id="statusAlertClose" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

      // Add JavaScript to automatically hide the error alert after 10 seconds
      echo '
        <script>
            setTimeout(function() {
                var errorAlert = document.getElementById("errorAlert");
                if (errorAlert) {
                    errorAlert.remove();
                }
            }, 10000); // 10 seconds
        </script>';
    }
  }

  // Check if the success parameter is set in the URL
  if (isset($_GET['error'])) {
    $successMessage = '';

    // Check the value of the success parameter and set the appropriate message
    switch ($_GET['error']) {
      case 'success':
        $successMessage = 'Updated successfully!';
        break;
        // Add more cases as needed

      default:
        // Handle other success cases or do nothing
        break;
    }



    // Display the alert if there is a success message
    if ($successMessage !== '') {
      echo '
        <div id="statusAlert" class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            ' . $successMessage . '
            <button id="statusAlertClose" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';

      // Add JavaScript to automatically hide the success alert after 10 seconds
      echo '
        <script>
            setTimeout(function() {
                var successAlert = document.getElementById("successAlert");
                if (successAlert) {
                    successAlert.remove();
                }
            }, 10000); // 10 seconds
        </script>';
    }
  }

  // Rest of your code...
  ?>






  <section class="section dashboard">
    <div class="row">



      <div class="col-xl-12">

        <div class="card">
          <div class="card-body pt-3">
            <!-- Bordered Tabs -->
            <ul class="nav nav-tabs nav-tabs-bordered">

              <li class="nav-item">
                <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Payouts</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Salary Info.</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#payouts">Overview</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#borrow">Borrows</button>
              </li>

              <li class="nav-item">
                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#leaves">Leaves</button>
              </li>

              <!-- <li class="nav-item">
                  <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-change-password">Change Password</button>
                </li> -->



            </ul>

            <div class="tab-content pt-2">
              <div class="tab-pane fade show active profile-overview" id="profile-overview">

                <!-- Payout Form -->

                <div class="modal fade" id="verticalycentered" tabindex="-1">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"><?php echo $emps["first_name"] ?> <?php echo $emps["last_name"] ?> (Payout)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="functions/insert_transaction.php" method="post" class="row g-3 needs-validation" novalidate>

                          <input type="hidden" class="form-control" name="emp_id" value="<?php echo $emps["employee_id"] ?>" required>

                          <div class="col-md-6">
                            <label for="monthInput" class="form-label">Payroll Period</label>
                            <input type="month" class="form-control" id="monthInput" name="period" onchange="updateDays()" required>
                            <div class="invalid-feedback">
                              Please provide a valid first name.
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="daysInMonth" class="form-label">Number of Days</label>
                            <input type="text" class="form-control" id="daysInMonth" name="days" readonly>
                            <div class="invalid-feedback">
                              Please provide a valid number.
                            </div>
                          </div>

                          <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">Basic Pay</label>
                            <input type="number" class="form-control" id="yourNumberInputId" name="gross_sal" value="<?php echo $comps["basic_pay"] ?>" required readonly>
                            <div class="invalid-feedback">
                              Please provide a valid first name.
                            </div>
                          </div>
                          <div class="col-md-6">
                            <!-- <label for="validationCustom02" class="form-label">Last name</label>
                              <input type="text" class="form-control" id="validationCustom02" name="lname" required>
                              <div class="invalid-feedback">
                              Please provide a valid last name.
                              </div> -->
                          </div>


                          <div class="col-md-6">
                            <label for="absent" class="form-label">Number of Absents</label>
                            <input type="text" class="form-control" id="absent" name="absent" required disabled>
                            <div class="invalid-feedback">
                              Please provide a valid title.
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="abs_total" class="form-label">Total (Absences)</label>
                            <input type="text" class="form-control" id="abs_total" name="abs_total" required readonly>
                            <div class="invalid-feedback">
                              Please provide a valid department.
                            </div>
                          </div>

                          <div class="col-md-6">
                            <label for="late" class="form-label">Late (Minutes)</label>
                            <input type="text" class="form-control" id="late" name="late" required disabled>
                            <div class="invalid-feedback">
                              Please provide a valid title.
                            </div>
                          </div>
                          <div class="col-md-6">
                            <label for="late_total" class="form-label">Total (Lates)</label>
                            <input type="text" class="form-control" id="late_total" name="late_total" required readonly>
                            <div class="invalid-feedback">
                              Please provide a valid department.
                            </div>
                          </div>

                          <div class="col-md-4">
                            <label for="sss_ded" class="form-label">SSS Deduction</label>
                            <input type="text" class="form-control" id="sss_ded" name="sss_ded" value="<?php echo $comps["sss"] ?>" readonly>
                            <div class="invalid-feedback">
                              Please select a valid value.
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="pag_ded" class="form-label">Pag-Ibig Deduction</label>
                            <input type="text" class="form-control" id="pag_ded" name="pag_ded" value="<?php echo $comps["pagibig"] ?>" readonly>
                            <div class="invalid-feedback">
                              Please select a valid value.
                            </div>
                          </div>
                          <div class="col-md-4">
                            <label for="ph_ded" class="form-label">Philhealth Deduction</label>
                            <input type="text" class="form-control" id="ph_ded" name="ph_ded" value="<?php echo $comps["philhealth"] ?>" readonly>
                            <div class="invalid-feedback">
                              Please select a valid value.
                            </div>
                          </div>

                          <div class="col-md-12">
                            <h5 class="card-title"><span>Credit Balance</span> | <?php echo is_array($bal) ? '₱ ' . number_format($bal["total_balance"], 2) : '0.00' ?> </h5>
                          </div>


                          <script>
                            window.onload = handleCreditBalance;

                            function handleCreditBalance() {
                              var creditAmountInput = document.getElementById('partial_amount');
                              var credDescInput = document.getElementById('partial_desc');
                              var credsDiv = document.getElementById('creds');

                              // Check if credit balance is zero
                              var creditBalance = parseFloat("<?php echo is_array($bal) ? $bal["total_balance"] : '0.00'; ?>");


                              // Get the inputted value in partial_amount
                              var partialAmount = parseFloat(creditAmountInput.value);

                              if (creditBalance > 0) {
                                // Credit balance is greater than zero, show the "creds" div
                                credsDiv.style.display = 'block';

                                // Set the credit_amount and cred_desc inputs to zero and make them readonly
                                creditAmountInput.value = '0';
                                credDescInput.readOnly = true;
                                credDescInput.value = 'Salary Deduction';

                                // Add validation for partial_amount exceeding credit balance
                                creditAmountInput.addEventListener('input', function() {
                                  var enteredAmount = parseFloat(creditAmountInput.value);

                                  if (enteredAmount > creditBalance) {
                                    alert('Payment cannot exceed the credit amount.');
                                    creditAmountInput.value = creditBalance.toFixed(2);
                                  }
                                });
                              } else {
                                // Credit balance is not zero, hide the "creds" div
                                credsDiv.style.display = 'none';

                                // Reset the credit_amount and cred_desc inputs and make them editable
                                creditAmountInput.value = '';
                                creditAmountInput.readOnly = true;
                                credDescInput.readOnly = true;
                                credDescInput.value = 'Salary Deduction';
                              }
                            }
                          </script>


                          <div id="creds" style="display: none;">
                            <div class="row">
                              <div class="col-md-6">
                                <label for="partial" class="form-label">Add Credit Payment</label>
                                <input type="number" class="form-control" id="partial_amount" step="0.01" name="credit_amount">
                                <div class="invalid-feedback">
                                  Please provide a valid number.
                                </div>
                              </div>
                              <div class="col-md-6">
                                <label for="partial" class="form-label">Description</label>
                                <input type="text" class="form-control" id="partial_desc" name="cred_desc">
                                <div class="invalid-feedback">
                                  Please provide a valid number.
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <h5 class="card-title" style="margin-bottom: -18px;">Others</h5>
                          </div>

                          <div class="col-md-6">
                            <label for="stat" class="form-label">Options</label>
                            <select class="form-select" id="mySelect" name="others_type" onchange="handleOthersChange()">
                              <option selected value="">Choose...</option>
                              <option value="add">Additional</option>
                              <option value="deduct">Deduction</option>
                            </select>
                          </div>

                          <div class="col-md-6">

                          </div>

                          <script>
                            function handleOthersChange() {
                              var selectValue = document.getElementById('mySelect').value;

                              // Hide both sections initially
                              document.getElementById('additional').style.display = 'none';

                              // Show the selected section
                              if (selectValue !== '') {
                                document.getElementById('additional').style.display = 'block';
                              } else if (selectValue === 'deduct') {
                                document.getElementById('additional').style.display = 'none';
                              }
                            }
                          </script>

                          <div id="additional" style="display: none;">
                            <div class="row">
                              <div class="col-md-6">
                                <label for="add" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="add" step="0.01" name="others_amount">
                                <div class="invalid-feedback">
                                  Please provide a valid number.
                                </div>
                              </div>
                              <div class="col-md-6">
                                <label for="add" class="form-label">Description</label>
                                <input type="text" class="form-control" id="add" name="others_desc">
                                <div class="invalid-feedback">
                                  Please provide a valid number.
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <label for="gross_salary" class="form-label">Gross Salary</label>
                            <input type="number" class="form-control" id="gross_salary" name="gross_salary" readonly>
                            <div class="invalid-feedback">
                              Please provide a valid first name.
                            </div>
                          </div>

                          <div class="col-md-6">
                            <label for="net_pay" class="form-label">Net Pay</label>
                            <input type="number" class="form-control" id="net_pay" name="net_pay" readonly>
                            <div class="invalid-feedback">
                              Please provide a valid number.
                            </div>
                          </div>

                          <script>
                            window.onload = function() {
                              handleCreditBalance(); // Call the existing function to handle credit balance

                              // Add event listener to update gross salary and net pay when input values change
                              document.getElementById('yourNumberInputId').addEventListener('input', updateGrossAndNet);
                              document.getElementById('absent').addEventListener('input', updateGrossAndNet);
                              document.getElementById('late').addEventListener('input', updateGrossAndNet);
                              document.getElementById('partial_amount').addEventListener('input', updateGrossAndNet);
                              document.getElementById('mySelect').addEventListener('change', updateGrossAndNet);
                              document.getElementById('add').addEventListener('input', updateGrossAndNet);
                              document.getElementById('monthInput').addEventListener('change', updateGrossAndNet);




                              function updateGrossAndNet() {
                                var basicPay = parseFloat(document.getElementById('yourNumberInputId').value) || 0;
                                var absTotal = parseFloat(document.getElementById('abs_total').value) || 0;
                                var lateTotal = parseFloat(document.getElementById('late_total').value) || 0;
                                var sssDed = parseFloat(document.getElementById('sss_ded').value) || 0;
                                var pagDed = parseFloat(document.getElementById('pag_ded').value) || 0;
                                var phDed = parseFloat(document.getElementById('ph_ded').value) || 0;
                                var credPay = parseFloat(document.getElementById('partial_amount').value) || 0;
                                var mySelect = document.getElementById('mySelect').value;


                                var grossSalary = basicPay;
                                var netPay = grossSalary - (sssDed + pagDed + phDed) - credPay - lateTotal - absTotal;

                                // Adjust net pay based on mySelect value
                                if (mySelect === 'add') {
                                  netPay += parseFloat(document.getElementById('add').value) || 0;
                                  grossSalary += parseFloat(document.getElementById('add').value) || 0;
                                } else if (mySelect === 'deduct') {
                                  netPay -= parseFloat(document.getElementById('add').value) || 0;
                                }

                                document.getElementById('gross_salary').value = grossSalary.toFixed(2);
                                document.getElementById('net_pay').value = netPay.toFixed(2);
                              }
                            }
                          </script>







                          <!-- <div class="col-12">
                              <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                                <label class="form-check-label" for="invalidCheck">
                                  Agree to terms and conditions
                                </label>
                                <div class="invalid-feedback">
                                  You must agree before submitting.
                                </div>
                              </div>
                            </div> -->
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="submit">Save changes</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>



                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#verticalycentered" style="margin-bottom: 12px;">
                  Add Transaction
                </button>


                <div class="col-12">
                  <div class="card recent-sales overflow-auto">

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
                      <h5 class="card-title">Transaction <span>| History</span></h5>

                      <table class="table table-borderless datatable">
                        <thead>
                          <tr>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Period</th>
                            <th scope="col">Gross Pay</th>
                            <th scope="col">Net Pay</th>
                            <th scope="col">Date</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $database = new Connection();
                          $db = $database->open();

                          try {
                            $sql = "SELECT * FROM tbl_transaction
                                  WHERE employee_id = '$empid'
                                  ORDER BY date ASC";

                            foreach ($db->query($sql) as $row) {
                          ?>
                              <tr>
                                <th scope="row"><a href="#"><?php echo $row["transaction_id"] ?></a></th>
                                <td><?php echo DateTime::createFromFormat('Y-m', $row["period"])->format('F, Y'); ?></td>
                                <td><?php echo number_format($row["grosspay"], 2, '.', ','); ?></td>
                                <td><?php echo number_format($row["netpay"], 2, '.', ','); ?></td>
                                <td><?php echo $row["date"] ?></td>
                                <td>
                                  <form action="slip-print.php" method="post">
                                    <input type="hidden" name="emps_id" value="<?php echo $row['employee_id']; ?>">
                                    <input type="hidden" name="trans_id" value="<?php echo $row['transaction_id']; ?>">
                                    <input type="hidden" name="period" value="<?php echo $row['period']; ?>">
                                    <button type="submit" class="btn btn-success btn-sm" name="submit">View</button>
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

              </div>

              <div class="tab-pane fade profile-edit pt-3" id="profile-edit">


                <!-- Profile Edit Form -->
                <form action="functions/add-edit-deductions.php" method="post">
                  <div class="row mb-3">
                    <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Full Name</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="fullName" type="text" class="form-control" id="fullName" value="<?php echo $emps["first_name"] ?> <?php echo $emps["last_name"] ?>" readonly>
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="company" class="col-md-4 col-lg-3 col-form-label">Basic Pay</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="basic_pay" type="number" class="form-control" id="company" value="<?php echo $comps["basic_pay"] ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Instagram" class="col-md-4 col-lg-3 col-form-label">SSS</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="sss" type="number" class="form-control" id="Instagram" value="<?php echo $comps["sss"] ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Pag-Ibig</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="pagibig" type="number" class="form-control" id="Linkedin" value="<?php echo $comps["pagibig"] ?>">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="Linkedin" class="col-md-4 col-lg-3 col-form-label">Philhealth</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="philhealth" type="number" class="form-control" id="Linkedin" value="<?php echo $comps["philhealth"] ?>">
                    </div>
                  </div>
                  <input type="hidden" class="form-control" id="inputEmail" value="<?php echo $emps["employee_id"] ?>" name="employee_id">

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary" name="submit">Save Changes</button>
                  </div>
                </form>

                <!-- End Profile Edit Form -->

              </div>



              <div class="tab-pane fade payouts pt-3" id="payouts">

                <h5 class="card-title">About</h5>
                <p class="small fst-italic">Sunt est soluta temporibus accusantium neque nam maiores cumque temporibus. Tempora libero non est unde veniam est qui dolor. Ut sunt iure rerum quae quisquam autem eveniet perspiciatis odit. Fuga sequi sed ea saepe at unde.</p>

                <h5 class="card-title">Profile Details</h5>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Employee Id</div>
                  <div class="col-lg-9 col-md-8"><?php echo $emps["employee_id"] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label ">Full Name</div>
                  <div class="col-lg-9 col-md-8"><?php echo $emps["first_name"] ?> <?php echo $emps["last_name"] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Job</div>
                  <div class="col-lg-9 col-md-8"><?php echo $emps["job_title"] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Country</div>
                  <div class="col-lg-9 col-md-8">PH</div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Address</div>
                  <div class="col-lg-9 col-md-8"><?php echo $emps["address"] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Phone</div>
                  <div class="col-lg-9 col-md-8"><?php echo $emps["phone_number"] ?></div>
                </div>

                <div class="row">
                  <div class="col-lg-3 col-md-4 label">Date Hired</div>
                  <div class="col-lg-9 col-md-8"><?php echo $emps["hire_date"] ?></div>
                </div>



              </div>
              <!-- Payout Form -->





              <!--Borrow-->
              <div class="tab-pane fade payouts pt-3" id="borrow">
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#smallModal" style="margin-bottom: 12px;">
                  Add Credit
                </button>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#smallModaldebit" style="margin-bottom: 12px;">
                  Add Payment
                </button>
                <!-- Sales Card -->
                <div class="col-xxl-12 col-md-12">
                  <div class="card info-card sales-card">

                    <!-- <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                          <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                          </li>

                          <li><a class="dropdown-item" href="#">Today</a></li>
                          <li><a class="dropdown-item" href="#">This Month</a></li>
                          <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                      </div> -->

                    <div class="card-body">
                      <h5 class="card-title">Credit <span>| Balance</span></h5>

                      <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                          <i class="bi bi-coin"></i><i class="fa-solid fa-peso-sign"></i>
                        </div>
                        <div class="ps-3">
                          <h6><?php echo is_array($bal) ? '₱ ' . number_format($bal["total_balance"], 2) : '0.00' ?></h6>
                          <!-- <span class="text-success small pt-1 fw-bold">Student</span> <span class="text-muted small pt-2 ps-1">Count</span> -->

                        </div>
                      </div>
                    </div>

                  </div>
                </div><!-- End Sales Card -->


                <div class="col-12">
                  <div class="card recent-sales overflow-auto">

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
                      <h5 class="card-title">Loans <span></span></h5>

                      <table class="table table-borderless datatable">
                        <thead>
                          <tr>
                            <th scope="col">Transaction ID</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Decription</th>
                            <th scope="col">Date</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $database = new Connection();
                          $db = $database->open();

                          try {
                            $sql = "SELECT * FROM tbl_borrows WHERE employee_id = '{$emps["employee_id"]}'
                            ORDER BY date ASC";
                            foreach ($db->query($sql) as $row) {
                          ?>
                              <tr>
                                <th scope="row"><a href="#"><?php echo $row["borrow_id"] ?></a></th>
                                <td><?php echo $row["amount"] ?></td>
                                <td><?php echo $row["status"] ?></a></td>
                                <td><?php echo $row["type"] ?></td>
                                <td><?php echo $row["date"] ?></td>
                                <?php include('modals/edit-employee.php'); ?>
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


              </div>

              <!--borrow-->

              <!-- Small Modal for Credit-->

              <div class="modal fade" id="smallModal" tabindex="-1">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Loans (Add Credit)</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <form action="functions/add-credit.php" method="post" class="row g-3 needs-validation" novalidate>
                        <div class="col-md-12">
                          <label for="amount" class="form-label">Amount</label>
                          <input type="number" class="form-control" id="amount" name="amount" required>
                          <div class="invalid-feedback">
                            Please provide a valid amount.
                          </div>
                        </div>


                        <input type="hidden" class="form-control" name="stat" value="Credit" required>
                        <input type="hidden" class="form-control" name="emp_id" value="<?php echo $emps["employee_id"] ?>" required>
                        <input type="hidden" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>


                        <script>
                          function handleSelectChanges() {
                            var select = document.getElementById("mySelects");
                            var othersInputContainer = document.getElementById("othersInputContainer");
                            var othersInput = document.getElementById("othersInput");

                            if (select.value === "others") {
                              othersInputContainer.style.display = "block";
                              othersInput.value = ""; // Reset the input value when "Others" is selected
                            } else {
                              othersInputContainer.style.display = "none";
                              othersInput.value = select.value; // Set the input value to the selected option value
                            }
                          }
                        </script>

                        <div class="col-md-12">
                          <label for="stat" class="form-label">Type</label>
                          <select class="form-select" id="mySelects" onchange="handleSelectChanges()" required>
                            <option selected disabled value="">Choose...</option>
                            <option value="Cash Advance">Cash Advance</option>
                            <option value="Allowance">Allowance</option>
                            <option value="others">Others</option>
                          </select>
                        </div>

                        <div class="col-md-12">
                          <div id="othersInputContainer" style="display: none;">
                            <label for="othersInput" class="form-label">Please specify:</label>
                            <input class="form-control" type="text" id="othersInput" name="othersInput">
                          </div>


                          <div class="invalid-feedback">
                            Please select a valid status.
                          </div>
                          <input type="hidden" class="form-control" name="emp_id" value="<?php echo $emps["employee_id"] ?>" required>
                          <input type="hidden" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" name="submit" class="btn btn-primary">Add</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Small Modal for Credit -->

              <!-- Small Modal for Debit-->

              <div class="modal fade" id="smallModaldebit" tabindex="-1">
                <div class="modal-dialog modal-sm">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Loans (Add Payment)</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                      <form action="functions/add-credit.php" method="post" class="row g-3 needs-validation" novalidate>
                        <div class="col-md-12">
                          <label for="amount" class="form-label">Amount</label>
                          <input type="number" class="form-control" id="amount" name="amount" required>
                          <div class="invalid-feedback">
                            Please provide a valid amount.
                          </div>
                        </div>


                        <input type="hidden" class="form-control" name="stat" value="Debit" required>
                        <input type="hidden" class="form-control" name="emp_id" value="<?php echo $emps["employee_id"] ?>" required>
                        <input type="hidden" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>





                        <div class="col-md-12">
                          <div id="othersInputContainer">
                            <label for="othersInput" class="form-label">Description:</label>
                            <input class="form-control" type="text" id="othersInput" name="othersInput">
                          </div>


                          <div class="invalid-feedback">
                            Please select a valid status.
                          </div>
                          <input type="hidden" class="form-control" name="emp_id" value="<?php echo $emps["employee_id"] ?>" required>
                          <input type="hidden" class="form-control" name="date" value="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" name="submit" class="btn btn-primary">Add</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Small Modal for Debit -->

              <!-- Leaves Form -->

              <div class="tab-pane fade pt-3" id="leaves">



                <div class="modal fade" id="disablebackdrop" tabindex="-1" data-bs-backdrop="false">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Leave Application Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <form action="functions/leave_process.php" method="post" class="row g-3" id="leaveForm">

                          <div class="col-12">
                            <label for="leaveType" class="form-label">Type of Leave</label>
                            <select class="form-select" id="leaveType" name="leaveType" required>
                              <option selected disabled value="">Choose...</option>
                              <option value="Sick Leave">Sick Leave</option>
                              <option value="Vacation Leave">Vacation Leave</option>
                            </select>
                          </div>

                          <div class="col-12">
                            <label for="dateStart" class="form-label">Date Start</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                          </div>
                          <div class="col-12">
                            <label for="dateEnd" class="form-label">Date End</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                          </div>
                          <div class="col-12">
                            <label for="leaveDuration" class="form-label">Leave Duration (Days):</label>
                            <input type="text" class="form-control" id="leaveDuration" name="leaveDuration" readonly>
                            <input type="hidden" class="form-control" name="leaveFiled" value="<?php echo date('Y-m-d'); ?>" required>
                            <input type="hidden" class="form-control" name="emp_id" value="<?php echo $emps["employee_id"] ?>" required>
                          </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        <button type="submit" class="btn btn-primary" id="submitLeaveBtn" name="submit">Submit</button>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>



                <script>
                  function calculateLeaveDuration() {
                    const startDate = new Date(document.getElementById('startDate').value);
                    const endDate = new Date(document.getElementById('endDate').value);

                    // Calculate the difference in days
                    const timeDifference = endDate - startDate;
                    const daysDifference = Math.ceil(timeDifference / (1000 * 60 * 60 * 24)) + 1;

                    // Update the leave duration input
                    document.getElementById('leaveDuration').value = daysDifference;
                    validateLeaveDuration();
                  }

                  function disablePastDates() {
                    const today = new Date().toISOString().split('T')[0];
                    document.getElementById('startDate').min = today;
                    document.getElementById('endDate').min = today;
                  }

                  // Attach the function to the change event of Date Start and Date End inputs
                  document.getElementById('startDate').addEventListener('change', function() {
                    // Set the minimum allowed date for Date End to the selected Date Start
                    document.getElementById('endDate').min = document.getElementById('startDate').value;
                    calculateLeaveDuration();
                  });

                  document.getElementById('endDate').addEventListener('change', calculateLeaveDuration);

                  // Call the function to disable past dates when the page loads
                  disablePastDates();
                </script>
                <!-- End Disabled Backdrop Modal-->




                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#disablebackdrop" style="margin-bottom: 12px;">File a Leave </button>

                <div class="row">
                  <!-- Sales Card 1 -->
                  <div class="col-xxl-3 col-md-12">
                    <div class="card info-card sales-card">
                      <div class="card-body">
                        <h5 class="card-title">Filed <span>| Leaves</span></h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi ri-task-line"></i><i class="fa-solid fa-peso-sign"></i>
                          </div>
                          <div class="ps-3">
                            <h6><?php echo $numLeave ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!-- End Sales Card 1 -->

                  <!-- Sales Card 2 (Duplicated) -->
                  <div class="col-xxl-3 col-md-12">
                    <div class="card info-card sales-card">
                      <div class="card-body">
                        <h5 class="card-title">Remaining <span>| Leaves</span></h5>
                        <div class="d-flex align-items-center">
                          <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi ri-task-line"></i><i class="fa-solid fa-peso-sign"></i>
                          </div>
                          <div class="ps-3">
                            <h6><?php echo 5 - $numLeave ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div><!-- End Sales Card 2 (Duplicated) -->
                </div>


                <div class="col-12">
                  <div class="card recent-sales overflow-auto">

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
                      <h5 class="card-title">Loans <span></span></h5>

                      <table class="table table-borderless datatable">
                        <thead>
                          <tr>
                            <th scope="col">Date Filed</th>
                            <th scope="col">Type</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $database = new Connection();
                          $db = $database->open();

                          try {
                            $sql = "SELECT * FROM tbl_leave WHERE employee_id = '{$emps["employee_id"]}'
                              ORDER BY leave_filed ASC";
                            foreach ($db->query($sql) as $row) {
                          ?>
                              <tr>
                                <td><?php $formattedDate = date("F d, Y", strtotime($row["leave_filed"]));
                                    echo $formattedDate ?></td>
                                <td><?php echo $row["leave_type"] ?></a></td>
                                <td><?php echo $row["leave_duration"] ?></td>
                                <td><?php $formattedDate = date("F d, Y", strtotime($row["leave_start"]));
                                    echo $formattedDate ?></td>
                                <td><?php $formattedDate = date("F d, Y", strtotime($row["leave_end"]));
                                    echo $formattedDate ?></td>
                                <td><?php echo $row["leave_status"] ?></td>
                                <td>
                                  <?php
                                  // Check if the leave status is not "Cancelled"
                                  if ($row["leave_status"] !== "Cancelled" && strtotime($row["leave_end"]) >= strtotime(date("Y-m-d"))) {
                                  ?>
                                    <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#editLeave<?php echo $row["lvs_id"] ?>">Edit</button>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#editLeave<?php echo $row["lvs_id"] ?>">Cancel</button>
                                  <?php
                                  } elseif ($row["leave_status"] !== "Cancelled") {
                                    // If the end date has passed, display "Done"
                                    echo 'Done';
                                  } else {
                                    // If the leave is cancelled, display "Cancelled"
                                    echo 'Cancelled';
                                  }
                                  ?>
                                </td>
                                <?php include('modals/leave_mod.php'); ?>
                              </tr>


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


                <!-- End Leaves Form -->



              </div>

              <div class="tab-pane fade pt-3" id="profile-change-password">
                <!-- Change Password Form -->
                <form>

                  <div class="row mb-3">
                    <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="password" type="password" class="form-control" id="currentPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="newpassword" type="password" class="form-control" id="newPassword">
                    </div>
                  </div>

                  <div class="row mb-3">
                    <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New Password</label>
                    <div class="col-md-8 col-lg-9">
                      <input name="renewpassword" type="password" class="form-control" id="renewPassword">
                    </div>
                  </div>

                  <div class="text-center">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                  </div>
                </form><!-- End Change Password Form -->

              </div>

            </div><!-- End Bordered Tabs -->

          </div>
        </div>

      </div>
    </div>
  </section>


  </div>
  </div>
  <!-- End Left side columns -->


  </div>
  </section>

</main><!-- End #main -->

<?php
include_once "../templates/footer.php";
?>