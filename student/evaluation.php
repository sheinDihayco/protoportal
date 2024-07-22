<?php
  include_once "../includes/connect.php";
  session_start();

if (!isset($_SESSION['st_id']) || $_SESSION['st_id'] == '') {
  header("location:../index.php?error=nopass");
}else{
  // echo 'Set and not empty, and no undefined index error!';
  // var_dump($_SESSION);
}

$sid = $_SESSION['st_id'];  

//var_dump($_SESSION);

    // $message = "Please Log-in";
    // if(empty($_GET)){
    //   $message = "Please Log-in!";
    // }else if($_GET["error"] == "wrongpass"){
    //   $message = "Wrong Password!";
    // }else if($_GET["error"] == "logout"){
    //   $message = "Logged Out!";
    // }else{
    //   $message = "Invalid Account";
    // }

    // var_dump($_POST);
    // var_dump($sid);

    //  $statement=$conn->prepare("SELECT * FROM student WHERE s_id = :stid");
     
    //  $statement=$conn->prepare("SELECT
    //  *
    //  FROM tbl_grades
    //  JOIN tbl_students
    //    ON tbl_grades.s_id = tbl_students.s_id
    //  JOIN tbl_sy
    //    ON tbl_grades.sy_id = tbl_sy.sy_id; ");

  // $statement=$conn->prepare("SELECT
  // *
  // FROM tbl_grades
  // JOIN tbl_students
  // ON tbl_grades.s_id = tbl_students.s_id
  // JOIN tbl_sy
  // ON tbl_grades.sy_id = tbl_sy.sy_id
  // WHERE tbl_students.s_id = :stid AND tbl_grades.sy_id= :syid");

  $statement=$conn->prepare("SELECT * FROM tbl_students LEFT JOIN tbl_grades ON tbl_students.s_id=tbl_grades.s_id WHERE tbl_students.s_id = :stid");
  $statement->bindParam(':stid', $sid);
  $statement->execute();
  $user = $statement->fetch(PDO::FETCH_ASSOC);
  
  $syd = $user["sy_id"];
  $statements=$conn->prepare("SELECT * FROM tbl_grades LEFT JOIN tbl_sy ON tbl_grades.sy_id=tbl_sy.sy_id WHERE tbl_grades.sy_id = :syd");
  $statements->bindParam(':syd', $syd);
  $statements->execute();
  $sy = $statements->fetch(PDO::FETCH_ASSOC);

  $smd = $user["sem_id"];
  $semstatements=$conn->prepare("SELECT * FROM tbl_grades LEFT JOIN tbl_sem ON tbl_grades.sem_id=tbl_sem.sem_id WHERE tbl_grades.sem_id = :smd");
  $semstatements->bindParam(':smd', $smd);
  $semstatements->execute();
  $sem = $semstatements->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Student Profile Page Design Example</title>

    <meta name="author" content="Codeconvey" />
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900&display=swap" rel="stylesheet"><link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css'>
    <!--Only for demo purpose - no need to add.-->
    <link rel="stylesheet" href="css/demo.css" />
	  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <div class="bg">


        <header class="ScriptHeader">
            <div class="rt-container">
              <div class="col-rt-12">
                  <div class="rt-heading">
                      <h1>UNDER CONSTRUCTION GRADE VIEWING</h1>
                        <p>By Yours Truly: Sir Mike</p>
                    </div>
                </div>
            </div>
        </header>

        <section>
            <div class="rt-container">
                  <div class="col-rt-12">
                      <div class="Scriptcontent">
                      
        <!-- Student Profile -->
        <div class="student-profile py-4">
          <div class="container">
            <div class="row">
            <div class="col-lg-4" style="margin: 0 0 26px 0;">
                <div class="card shadow-sm">
                  <div class="card-header bg-transparent text-center">
                    <img class="profile_img" src="../images/student.jpg" alt="student dp">
                    <h3><?php echo $user["s_name"] ?></h3>
                  </div>
                  <div class="card-body">
                    <p class="mb-0"><strong class="pr-1">Student ID:</strong><?php echo $user["s_id"] ?></p>
                    <p class="mb-0"><strong class="pr-1">Section:</strong>A</p>
                    <a href="../includes/logout.inc.php"><p class="mb-0"><strong class="pr-1">Logout</strong></p></a>
                  </div>
                </div>
              </div>
              <div class="col-lg-8">
                <div class="card shadow-sm">
                  <div class="card-header bg-transparent border-0">
                    <h3 class="mb-0">General Information</h3>
                  </div>
                  <div class="card-body pt-0">
                    <table class="table table-bordered">
                      <tr>
                        <th width="30%">COURSE</th>
                        <td width="2%">:</td>
                        <td>BACHERLOR OF SCIENCE IN INFORNATION TECHNOLOGY</td>
                      </tr>
                      <tr>
                        <th width="30%">ACADEMIC YEAR	</th>
                        <td width="2%">:</td>
                        <td><?php echo $sy["sy_desc"] ?></td>
                      </tr>
                      <tr>
                        <th width="30%">SEMESTER</th>
                        <td width="2%">:</td>
                        <td><?php echo $sem["sem_desc"] ?></td>
                      </tr>
                      <tr>
                        <th width="30%">STATUS</th>
                        <td width="2%">:</td>
                        <td>Enrolled</td>
                      </tr>
                  
                    </table>
                  </div>
                </div>
                  <div style="height: 26px"></div>
                <div class="card shadow-sm">
                  <div class="card-header bg-transparent border-0">
                    <h3 class="mb-0">PROGRAMMING 1 GRADES</h3>
                  </div>
                  <div class="card-body pt-0">


                    <div class="grds">
                      <div class="grd">PRELIM<br/><em><?php echo $user["prelim"] ?></em></div>
                      <div class="grd">MIDTERM<br/><em><?php echo $user["midterm"] ?></em></div>
                      <div class="grd">PREFINAL<br/><em><?php echo $user["prefinal"] ?></em></div>
                      <div class="grd">FINALS<br/><em><?php echo $user["final"] ?></em></div>
                    </div>




                      <!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p> -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- partial -->
                  
                </div>
            </div>
            </div>
        </section>

  </div>
     


    <!-- Analytics -->

	</body>
</html>