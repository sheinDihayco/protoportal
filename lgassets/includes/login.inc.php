<?php
include_once "connect.php";

// if(isset($_POST['login']))
// {
// 	if(isset($_POST['uname'],$_POST['psw']) && !empty($_POST['uname']) && !empty($_POST['psw']))
// 	{
// 		$email = trim($_POST['uname']);
// 		$password = trim($_POST['psw']);
 
// 		if(filter_var($email, FILTER_VALIDATE_EMAIL))
// 		{
// 			$sql = "SELECT * FROM tbl_user WHERE email = :email";
// 			$handle = $conn->prepare($sql);
// 			$params = ['email'=>$email];
// 			$handle->execute($params);
// 			if($handle->rowCount() > 0)
// 			{
// 				$getRow = $handle->fetch(PDO::FETCH_ASSOC);
// 				if(password_verify($password, $getRow['password']))
// 				{
// 					//unset($getRow['password']);
// 					// $_SESSION = $getRow;
// 					// header('location:dashboard.php');
//                     $_SESSION['u_id']=$user["user_id"];
//                     $_SESSION["name"]=$user['firstName'];
//                     $_SESSION["email"]=$user['email'];
//                     header("location:../index.php?error=success");
// 					exit();
// 				}
// 				else
// 				{
// 					// $errors[] = "Wrong Email or Password";
//                     header("location:../admin/index.php?error=1");
// 				}
// 			}
// 			else
// 			{
// 				//$errors[] = "Wrong Email or Password";
//                 header("location:../admin/index.php?error=2");
// 			}
			
// 		}
// 		else
// 		{
// 			// $errors[] = "Email address is not valid";	
//             header("location:../admin/index.php?error=3");
// 		}
 
// 	}
// 	else
// 	{
// 		// $errors[] = "Email and Password are required";
//         header("location:../admin/index.php?error=4");
//     }
// }





if (isset($_POST["login"])){
$user=$_POST["user"];
$pass=$_POST["pass"];

$statement=$conn->prepare("SELECT * FROM tbl_students WHERE s_id = :id");
$statement->bindParam(':id', $user);
$statement->execute();

$user = $statement->fetch(PDO::FETCH_ASSOC);

$stid = $user["s_id"];
$password = $user["s_pass"];

$checkpass=password_verify($pass, $password);




if($checkpass ===false){
// if (password_verify($pass, $user['password'])) {
    header("location:../../index.php?error=wrongpass");
exit;
}else{
    session_start();
    $_SESSION['st_id']=$user["s_id"];

    
    // $_SESSION["st_name"]=$user['firstName'];
    // $_SESSION["email"]=$user['email'];
    header("location:../../student/index.php?error=success");
    exit;
    
}

}

?>