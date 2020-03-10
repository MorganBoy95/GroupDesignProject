<?php
session_start();
// Connection Info:
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'id12874597_admin';
$DATABASE_PASS = 'admin';
$DATABASE_NAME = 'id12874597_purchase_order_system';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if ( !isset($_POST['staffID'], $_POST['password']) ) {
	die ('Please fill both the username and password field!');
}

// Prepared SQL to stop SQL Injection
if ($stmt = $con->prepare('SELECT staffID, password FROM staff WHERE staffID = ?')) {
	$stmt->bind_param('s', $_POST['staffID']);
	$stmt->execute();
	$stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($staffID, $password);
        $stmt->fetch();
        if (password_verify($_POST['password'], $password)) {
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['staffID'];
            $_SESSION['id'] = $staffID;
            header('Location: home.php');
        } else {
            echo 'Incorrect password!';
        }
    } else {
        echo 'Incorrect username!';
    }
	$stmt->close();
}
?>