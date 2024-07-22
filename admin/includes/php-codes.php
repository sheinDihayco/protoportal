<?php
// database connection info.
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'miit-portal';

// Create a connection
$conn = new mysqli($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user data
$id = 1; // Replace with the actual user ID
$sql = "SELECT * FROM profile WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

// Assign fetched data to variables
$fname = htmlspecialchars($profile['fname']);
$lname = htmlspecialchars($profile['lname']);
$course = htmlspecialchars($profile['course']);
$year = htmlspecialchars($profile['year']);
$country = htmlspecialchars($profile['country']);
$address = htmlspecialchars($profile['address']);
$phone = htmlspecialchars($profile['phone']);
$email = htmlspecialchars($profile['email']);
$middleInitial = htmlspecialchars($profile['middleInitial']);
$term = htmlspecialchars($profile['term']);
$studentID = htmlspecialchars($profile['studentID']);
// Close statement
$stmt->close();
$conn->close();
