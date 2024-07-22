<?php
include_once("../includes/connect.php");
$connect = mysqli_connect("localhost", "root", "", "mike");

    
   if (isset($_POST["Import"])){

    $course = $_POST["course"];
    $year = $_POST["year"];
    $section = $_POST["section"];

    if ($_FILES['file']['name'] == "")
    {
    header('Location:../enrollment.php?error=Nofile');
    exit();
    }else{


if($_FILES['file']['name'])
{
    $filename = explode(".", $_FILES['file']['name']);
    if($filename[1] == 'csv'){

        $handle = fopen($_FILES['file']['tmp_name'], "r");

        while($data = fgetcsv($handle))//handling csv file 
        
        {
        $st_id = mysqli_real_escape_string($connect, utf8_encode($data[0]));

            $statement=$conn->prepare("SELECT * FROM tbl_general WHERE status = 'Active'");
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);

            if(!empty($result)){
                $genid = $result["gen_id"];
            }else{
                $genid = "";
            }

            $stmt_eval=$conn->prepare("SELECT * FROM tbl_enrollees WHERE gen_id = '$genid' AND s_id = '$st_id'");
            $stmt_eval->execute();
            $enroll_rst = $stmt_eval->fetch(PDO::FETCH_ASSOC);
        

            if(!empty($enroll_rst)){
                $en_id = $enroll_rst["en_id"];
                $query = "UPDATE tbl_enrollees SET gen_id='$genid', s_id='$st_id', course_id='$course', yr_id='$year', sec_id='$section' WHERE en_id='$en_id'";


            }else{
                $query = "INSERT INTO tbl_enrollees (gen_id, s_id, course_id, yr_id, sec_id) 
                VALUES('$genid','$st_id','$course','$year','$section')";
            }

        mysqli_query($connect, $query);
        
    }

    }

    fclose($handle);
    header("location:../enrollment.php?error=Uploaded");
        exit;

}


}
} 


 ?>











