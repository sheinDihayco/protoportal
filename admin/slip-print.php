<?php

function showAlertAndRedirect($message, $formAction, $hiddenInputName, $hiddenInputValue) {
    echo '<form id="myForm" action="' . $formAction . '" method="post">';
    echo '<input type="hidden" name="' . $hiddenInputName . '" value="' . $hiddenInputValue . '">';
    echo '</form>';
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                document.getElementById("myForm").submit();
            });
          </script>';
}

$emp_id = $_POST["emps_id"];
$prd = $_POST["period"];

$_SESSION['transaction'] = $_POST["trans_id"];



  if(isset($_SESSION['transaction']) && !empty($_SESSION['transaction'])) {
    $transid = $_SESSION['transaction'];
  }else{
    showAlertAndRedirect("Success", "profile.php?error=slipnotfound", "emps_id", $emp_id);
  }
  
// showAlertAndRedirect("Success", "../profile.php?error=nodebit", "emps_id", $emp_id);


?>

<!-- < ?php

include_once "includes/connect.php";

$_SESSION['syear'] = $_POST["sy"];
$_SESSION['ssem'] = $_POST["sem"];
$_SESSION['section'] = $_POST["sec"];
$_SESSION['yearlvl'] = $_POST["year"];
$_SESSION['course'] = $_POST["subject"];
$_SESSION['inst'] = $_POST["ins"];


$count=$conn->prepare("SELECT COUNT(*) AS Count, ROUND(AVG(final), 2) AS Average FROM tbl_grades WHERE sbj_id = :sbjid AND yr_id = :yrid AND sec_id = :secid AND ins_id = :insid");
$count->bindParam(':sbjid', $_SESSION['course']);
$count->bindParam(':yrid', $_SESSION['yearlvl']);
$count->bindParam(':secid', $_SESSION['section']);
$count->bindParam(':insid', $_SESSION['inst']);
$count->execute();
$counts = $count->fetch(PDO::FETCH_ASSOC);
$num = $counts["Count"];

if(isset($_SESSION['syear']) && !empty($_SESSION['syear'])) {
    $scyear = $_SESSION['syear'];
    $yearlvl = $_SESSION['yearlvl'];
    $section = $_SESSION['section'];
    $sem = $_SESSION['ssem'];
    $course = $_SESSION['course'];
    $inst = $_SESSION['inst'];

    if($num == 0){
        header("location:grade-print.php?error=norecordfound");
    }
    


  }else{
    header("location:grade.php?error=nofiles");
  }
  
  


include_once "../templates/header.php"; 
include_once "includes/connect.php";






// var_dump($_POST);
// var_dump($_SESSION);



$statement=$conn->prepare("SELECT * FROM `tbl_grades`
                           INNER JOIN `tbl_subject`
                           ON `tbl_grades`.`sbj_id` = `tbl_subject`.`sbj_id`
                           INNER JOIN `tbl_section`
                           ON tbl_grades.sec_id = tbl_section.sec_id
                           INNER JOIN `tbl_yr`
                           ON tbl_grades.yr_id = tbl_yr.yr_id
                           INNER JOIN `tbl_sem`
                           ON tbl_grades.sem_id = tbl_sem.sem_id
                           INNER JOIN `tbl_instructor`
                           ON tbl_grades.ins_id = tbl_instructor.ins_id
                           WHERE `tbl_grades`.`sbj_id` = :sbjid AND tbl_grades.sec_id = :secid AND tbl_grades.yr_id = :yrid AND tbl_grades.ins_id = :insid AND tbl_grades.sem_id = :semid");
$statement->bindParam(':sbjid', $course);
$statement->bindParam(':secid', $section);
$statement->bindParam(':yrid', $yearlvl);
$statement->bindParam(':insid', $inst);
$statement->bindParam(':semid', $sem);
$statement->execute();
$sbj_info = $statement->fetch(PDO::FETCH_ASSOC);



?> -->

<?php

include_once "../templates/header.php"; 


$statement=$conn->prepare("SELECT * FROM `tbl_transaction`
                           INNER JOIN `tbl_employee`
                           ON `tbl_transaction`.`employee_id` = `tbl_employee`.`employee_id`
                           WHERE `tbl_transaction`.`employee_id` = :eid AND `tbl_transaction`.`period` = :period");
$statement->bindParam(':eid', $emp_id);
$statement->bindParam(':period', $prd);
$statement->execute();
$emp_info = $statement->fetch(PDO::FETCH_ASSOC);

$transid = $emp_info["transaction_id"];



$statement1=$conn->prepare("SELECT amount FROM `tbl_borrows` WHERE `transaction_id` = :tid");
$statement1->bindParam(':tid', $transid);
$statement1->execute();
$borrows = $statement1->fetch(PDO::FETCH_ASSOC);
$amount = isset($borrows['amount']) ? $borrows['amount'] : 0;
$amount = $borrows['amount'] ?? 0;

$statement2=$conn->prepare("SELECT * FROM `tbl_attendance` WHERE `transaction_id` = :tid");
$statement2->bindParam(':tid', $transid);
$statement2->execute();
$att = $statement2->fetch(PDO::FETCH_ASSOC);
$late = isset($att['late']) ? $att['late'] : 0;
$late = $att['late'] ?? 0;
$abs = isset($att['absent']) ? $att['absent'] : 0;
$abs = $att['absent'] ?? 0;
?>


  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Payslip</h1>
      <nav>
        <ol class="breadcrumb">

        <form action="profile.php" method="post">
            <input type="hidden" name="emps_id" value="<?php echo $emp_id?>">
            <button type="submit" style="margin: 10px 0 2px 4px;margin-top: ;width: 62px;" name ="submit">Back</button>
        </form>    
        <!-- <button style="margin: 10px 0 2px 4px;margin-top: ;width: 62px;" onclick='goBack()'>Back</button> -->
        <a class="icon"><button style="margin: 10px 0 2px 4px;margin-top: ;width: 62px;"  onclick="window.print()">Print</button></a>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <style>
    aside#sidebar {
    display: none;
    }

    #main, #footer {
    margin-left: 0 !important;
    } 

    .d-flex {
      display: none!important;
    }

    #main {
    margin-top: 0!important;
    }

    @media print
    {    
        .pagetitle
        {
            display: none !important;
        }

        .footer
        {
            display: none !important;
        }
    }

    .card-body {
        padding: 10px 20px 10px 20px !important;
    }
    hr {
      margin: 6px 0;
    }
    td {
    font-size: 14px;
    }

    .table>:not(caption)>*>* {
    padding: 0rem 0.5rem !important ;
    }

    p.mb-0 {
    font-size: 13px;
    font-weight: bold;
    }

    .mb-4 {
    margin-bottom: 0.5rem!important;
    }
    </style>

   

        <div class="col-lg-7 mx-auto">
            <div class="card mb-4">
                  <div class="card-body">

                    <div class="row">
                          <div class="col-sm-12" style="text-align: center;">
                            <p class="text-muted mb-0" style="text-align: center;"><span class="text-primary font-italic me-1" style="font-size: 20px;">Company Name Here</span></p>
                            <h4 class="my-3" style="text-align: center;margin-top: -4px !important; font-size: 15px;">SUBTEXT HERE</h4>
                            <h6 class="my-3" style="text-align: center;margin-top: -14px !important; font-size: 15px;">Complete Address Here</h6> 
                          </div>
                      </div>

                      <div class="row">
                          <div class="col-sm-3">
                              <p class="mb-0">Employee Name:</p>
                          </div>
                          <div class="col-sm-3">
                              <p class="text-muted mb-0"><span class="text-primary font-italic me-1" style="font-size: 14px;"><?php echo $emp_info["last_name"] ?>, <?php echo $emp_info["first_name"] ?></span></p>
                          </div>
                          <div class="col-sm-3">
                              <p class="mb-0">Employee ID:</p>
                          </div>
                          <div class="col-sm-3">
                              <p class="text-muted mb-0"><span class="text-primary font-italic me-1" style="font-size: 14px;"><?php echo $emp_info["employee_id"] ?></span></p>
                          </div>
                          
                      </div>

                      <hr>
                      <div class="row">
                      <div class="col-sm-3">
                              <p class="mb-0">Date Hired:</p>
                          </div>
                          <div class="col-sm-3">
                              <p class="text-muted mb-0"><span class="text-primary font-italic me-1" style="font-size: 14px;"><?php echo date("F j, Y", strtotime($emp_info["hire_date"])); ?></span></p>
                          </div>
                          <div class="col-sm-3">
                              <p class="mb-0">Designation:</p>
                          </div>
                          <div class="col-sm-3">
                              <p class="text-muted mb-0"><span class="text-primary font-italic me-1" style="font-size: 14px;"><?php echo $emp_info["job_title"] ?></span></p>
                          </div>
                      </div>

                      <hr>
                      <div class="row">
                      <div class="col-sm-3">
                              <p class="mb-0">Salary Period</p>
                          </div>
                          <div class="col-sm-3">
                              <p class="text-muted mb-0"><span class="text-primary font-italic me-1" style="font-size: 14px;"><?php echo DateTime::createFromFormat('Y-m', $emp_info["period"])->format('F, Y'); ?></span></p>
                          </div>
                          <div class="col-sm-3">
                              <p class="mb-0">No of Days:</p>
                          </div>
                          <div class="col-sm-3">
                              <p class="text-muted mb-0"><span class="text-primary font-italic me-1" style="font-size: 14px;"><?php echo $emp_info["days"] ?></span></p>
                          </div>
                      </div>
                      <hr>
                      <br>

                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">Earnings</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col" style="border-left: 1px solid gray;">Deductions</th>
                                    <th scope="col">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td scope="col">Basic Pay</td>
                                    <td scope="col"><?php echo !empty($emp_info["gross_amount"]) ? number_format($emp_info["gross_amount"], 2, '.', ',') : '-'; ?></td>
                                    <td scope="col" style="border-left: 1px solid gray;">Loan</td>
                                    <td scope="col"><?php echo $amount === 0 ? '-' : number_format($amount, 2, '.', ',')?></td>
                                </tr>
                                <tr>
                                    <td scope="col">Others</td>
                                    <td scope="col"><?php echo $emp_info["others_type"] == 'add' ? number_format($emp_info["others_amount"], 2, '.', ',') : '-'; ?></td>
                                    <td scope="col" style="border-left: 1px solid gray;">Others</td>
                                    <td scope="col"><?php echo $emp_info["others_type"] == 'deduct' ? number_format($emp_info["others_amount"], 2, '.', ',') : '-'; ?></td>
                                </tr>
                                <tr>
                                    <td scope="col"></td>
                                    <td scope="col"></td>
                                    <td scope="col" style="border-left: 1px solid gray;">SSS</td>
                                    <td scope="col"><?php echo number_format($emp_info["sss_amount"], 2, '.', ',')?></td>
                                </tr>
                                <tr>
                                    <td scope="col" style="font-weight: bold;">Attendance</td>
                                    <td scope="col" style="font-weight: bold;">Deduction</td>
                                    <td scope="col" style="border-left: 1px solid gray;">Pag-Ibig</td>
                                    <td scope="col"><?php echo number_format($emp_info["pagibig_amount"], 2, '.', ',')?></td>
                                </tr>
                                <tr>
                                    <td scope="col">Absent &nbsp;&nbsp;&nbsp;(<?php echo $abs?> days)</td>
                                    <td scope="col"><?php echo number_format($emp_info["absent_amount"], 2, '.', ',')?></td>
                                    <td scope="col" style="border-left: 1px solid gray;">Philheatlh</td>
                                    <td scope="col"><?php echo number_format($emp_info["phil_amount"], 2, '.', ',')?></td>
                                </tr>
                                <tr>
                                    <td scope="col">Late &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; (<?php echo $late?> minutes)</td>
                                    <td scope="col"><?php echo number_format($emp_info["late_amount"], 2, '.', ',')?></td>
                                    <td scope="col" style="border-left: 1px solid gray;"></td>
                                    <td scope="col"></td>
                                </tr>
                                <tr>
                                    <td scope="col"></td>
                                    <td scope="col"></td>
                                    <td scope="col" style="border-left: 1px solid gray; font-weight: bold;">Total Deduction:</td>
                                    <td scope="col">
                                        <?php
                                        $totalDed = ($emp_info["others_type"] == 'deduct' ? $emp_info["others_amount"]: 0) + $amount + $emp_info["sss_amount"] + $emp_info["pagibig_amount"] + $emp_info["absent_amount"] + $emp_info["phil_amount"] + $emp_info["late_amount"];
                                        echo number_format($totalDed, 2, '.', ',');
                                        ?>

                                    </td>
                                </tr>
                                <tr>
                                    <th scope="col">Gross Pay:</th>
                                    <th scope="col"><?php echo number_format($emp_info["gross_amount"]+($emp_info["others_type"] == 'add' ? $emp_info["others_amount"]: 0), 2, '.', ',')?> PHP</th>
                                    <th scope="col" style="border-left: 1px solid gray;">NET PAY:</th>
                                    <!-- <th scope="col">< ?php echo number_format($emp_info["netpay"], 2, '.', ',')?> PHP</th> -->
                                    <th scope="col"><?php echo number_format(intval($emp_info["netpay"]), 2, '.', ',')?> PHP</th>

                                </tr>
                               
                            </tbody>
                        </table>
                  </div>

          

                        <div class="row">
                            <div class="col-sm-12" style="text-align: center;">
                                <p class="mb-0"style="text-align: center; font-size: 13px;" >Received By:</p>
                                <div class="row" style="margin: 10px 0 0 0;">
                                    <div class="col-sm-10" style="width: 100%;text-align: center;">
                                        <u><span class="text-primary font-italic me-1" style="font-size: 15px;font-weight: bold;">&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $emp_info["first_name"]?> <?php echo $emp_info["last_name"]?>&nbsp;&nbsp;&nbsp;&nbsp;</span></u>
                                    </div>
                                </div>
                                <div class="col-sm-2" style="width: 100%;text-align: center;">
                                    <p class="mb-0" style="font-size: 11px;margin-top: -4px;">(Signature over Printed Name)</p>
                                    <p></p>
                                </div>
                            </div>
                        </div>
              </div>
          </div>
    </section>

  </main><!-- End #main -->

<?php
include_once "../templates/footer.php"; 
?>