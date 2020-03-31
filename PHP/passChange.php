<?php

session_start();

require "validate.php";

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
if ( !isset($_POST['currpass'], $_POST['newpass1'], $_POST['newpass2']) ) {
	die ('Please fill out all required fields');
}

$userID = validateInput($_SESSION['name']);

//Prepare first statement
$stmt = $con->prepare("SELECT password FROM staff WHERE staffID = ?;");
//Bind Parameters to statement
$stmt->bind_param("s", $userID);

//Execute statement
$stmt->execute();

//Store the result, bind it to a variable and fetch the result into the variable
$stmt->store_result();
$stmt->bind_result($currentPassword);
$stmt->fetch();

//First, verify current user supplied password compared to the currently stored password in the db
if(password_verify($_POST['currpass'], $currentPassword)) {
    //Prepare new SQL statement, and bind variables to parameters
    $stmt = $con->prepare("UPDATE `staff` SET `password` = ? WHERE `staffID` = ?;");
    $stmt->bind_param("ss", $newPass1, $staffID);

    //Set variables, and validate the SESSION name with the data validation function
    $staffID = validateInput($_SESSION['name']);
    $newPass1 = $_POST['newpass1'];
    $newPass2 = $_POST['newpass2'];

    //If the two new passwords match each other, hash the password, execute the query and close them
    if ($_POST['newpass1'] == $_POST['newpass2']) {
        $newPass1 = password_hash($newPass1, PASSWORD_BCRYPT);
        $stmt->execute();
        $stmt->close();

        //Redirect to success message and then redirect again to home
        header("refresh:10;url=./home.php");
        echo "<h1>Password changed</h1>";
        echo "<h3>You will be automatically redirected back to the home page in 10 seconds.</h3>";
    } else {
        //Issue error message, and then redirect user to try again
        header("refresh:10;url=./changePassword.php");
        echo "Ensure your two new passwords match and then try again! You will be redirected in 10 seconds.";
    }
} else {
    echo "Ensure your passwords match!";
}
