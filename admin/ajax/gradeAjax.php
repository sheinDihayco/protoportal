<?php 
// Include the database config file 
include_once '../includes/connects.php'; 

if(!empty($_POST["instructor_id"])){ 
    $query = "SELECT DISTINCT tbl_yr.yr_id, tbl_yr.yr_desc
              FROM tbl_grades 
              INNER JOIN tbl_yr
              ON tbl_grades.yr_id = tbl_yr.yr_id
              WHERE tbl_grades.ins_id = ".$_POST['instructor_id'].""; 
    $result = $db->query($query); 
     
    if($result->num_rows > 0){ 
        echo '<option value="">Select Year</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['yr_id'].'">'.$row['yr_desc'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Year not available</option>'; 
    } 
}

if(!empty($_POST["year_id"])){ 
    // Fetch city data based on the specific state 
    $query = "SELECT DISTINCT tbl_subject.sbj_id, tbl_subject.sbj_desc
              FROM tbl_grades
              INNER JOIN tbl_subject ON tbl_grades.sbj_id = tbl_subject.sbj_id
              INNER JOIN tbl_sem ON tbl_grades.sem_id = tbl_sem.sem_id
              WHERE tbl_grades.yr_id = ".$_POST['year_id']." AND tbl_grades.ins_id = ".$_POST['ins_id']." AND tbl_grades.sem_id = ".$_POST['sem_id'].""; 
    $result = $db->query($query); 

//     $query = "SELECT DISTINCT tbl_subject.sbj_id, tbl_subject.sbj_desc
//           FROM tbl_grades
//           INNER JOIN tbl_subject ON tbl_grades.sbj_id = tbl_subject.sbj_id
//           INNER JOIN tbl_sem ON tbl_grades.sem_id = tbl_sem.sem_id
//           WHERE tbl_grades.yr_id = " . intval($_POST['year_id']) . " AND tbl_grades.ins_id = " . intval($_POST['ins_id']) . " AND tbl_grades.sem_id = " . intval($_POST['sem_id']);

// $result = $db->query($query);
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select Subject</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['sbj_id'].'">'.$row['sbj_desc'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Subject not available</option>'; 
    } 
}

if(!empty($_POST["sub_id"])){ 
    // Fetch city data based on the specific state 
    $query = "SELECT DISTINCT tbl_section.sec_id, tbl_section.sec_desc
              FROM tbl_grades
              INNER JOIN tbl_section
              ON tbl_grades.sec_id = tbl_section.sec_id
              WHERE tbl_grades.sbj_id = ".$_POST['sub_id'].""; 
    $result = $db->query($query); 
     
    // Generate HTML of city options list 
    if($result->num_rows > 0){ 
        echo '<option value="">Select Section</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['sec_id'].'">'.$row['sec_desc'].'</option>'; 
        } 
    }else{ 
        echo '<option value="">Section not available</option>'; 
    } 
}


?>