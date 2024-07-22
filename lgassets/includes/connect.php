<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname="mike";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  //   echo "Connect Successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>

