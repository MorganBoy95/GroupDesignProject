<?php

session_start();
//Define Connection Info
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'id12874597_admin';
$DATABASE_PASS = 'admin';
$DATABASE_NAME = 'id12874597_purchase_order_system';
//Establish Connection
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	die ('Failed to connect to MySQL: ' . mysqli_connect_error());
}

//Ensures necessary fields have been completed
if ( !isset($_POST['newpass1'], $_POST['newpass2']) ) {
	die ('Please fill out all required fields');
}

$stmt = $con->prepare("UPDATE `staff` SET `password` = ? WHERE `staffID` = ?;");
$stmt->bind_param("ss", $newPass1, $staffID);

$staffID = $_SESSION['name'];
$newPass1 = $_POST['newpass1'];
$newPass2 = $_POST['newpass2'];

if ($_POST['newpass1'] == $_POST['newpass2']) {
    $newPass1 = password_hash($newPass1, PASSWORD_BCRYPT);
    $stmt->execute();
    $stmt->close();

    header("refresh:10;url=./home.php");
    echo "<h1>Password changed</h1>";
    echo "<h3>You will be automatically redirected back to the home page in 10 seconds.</h3>";
} else {
    header("refresh:10;url=./changePassword.php");
    echo "Ensure your two new passwords match and then try again! You will be redirected in 10 seconds.";
}

?>