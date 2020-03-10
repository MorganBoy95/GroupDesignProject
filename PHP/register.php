<?php
session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'id12874597_admin';
$DATABASE_PASS = 'admin';
$DATABASE_NAME = 'id12874597_purchase_order_system';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['staffID'], $_POST['title'], $_POST['firstName'], $_POST['lastName'], $_POST['appointment'], $_POST['password']) ) {
	die ('Please fill out all required fields');
}

$stmt = $con->prepare("INSERT INTO staff (staffID, title, firstName, lastName, appointment, departmentID, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $staffID, $title, $firstName, $lastName, $appointment, $departmentID, $password);

$staffID = $_POST['staffID'];
$title = $_POST['title'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$appointment = $_POST['appointment'];

if (empty($_POST['department'])) {
    $departmentID = NULL;
} else {
    $departmentID = $_POST['department'];
}

$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$stmt->execute();

$stmt->close();

echo "Registration Complete";


?>