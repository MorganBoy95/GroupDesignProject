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
if ( !isset($_POST['staffID'], $_POST['title'], $_POST['firstName'], $_POST['lastName'], $_POST['appointment'], $_POST['password']) ) {
	die ('Please fill out all required fields');
}

//Prepare the statement with areas for substitution with variables
$stmt = $con->prepare("INSERT INTO staff (staffID, title, firstName, lastName, appointment, departmentID, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
//Bind parameters to variables - in this case there are 7 cases of strings (s)
$stmt->bind_param("sssssss", $staffID, $title, $firstName, $lastName, $appointment, $departmentID, $password);
//Set all statement variables to the values obtained from the form using POST
$staffID = $_POST['staffID'];
$title = $_POST['title'];
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$appointment = $_POST['appointment'];
//If the department field is left empty, the value is set to NULL as it is not required
//If NOTNULL, the departmentID is set to the $_POST value obtained from the 
if (empty($_POST['department'])) {
    $departmentID = NULL;
} else {
    $departmentID = $_POST['department'];
}

//Hash the password using BCRYPT
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
//Execute prepared statement on the database
$stmt->execute();
//Close the prepared statement
$stmt->close();

echo "<h1>Registration Complete</h1>";
echo "<a href='../HTML/register.html'>Register Again</a>";
echo "<br />";
echo "<a href='../PHP/home.php'>Home</a>";

?>