<?php
session_start();

require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$_SESSION['porderItems'] = array();
$_SESSION['quantities'] = array();
$_SESSION['suppliers'] = array();
$_SESSION['costs'] = array();

if (isset($_POST['create'])) {
    $stmt = $con->prepare("INSERT INTO request (staffID, `date`, requestState) VALUES (?, CURDATE(), ?)");

    $stmt->bind_param('ss', $_SESSION['name'], $requestState);

    $requestState = "pending";

    $stmt->execute();

    $_SESSION['currentPorder'] = mysqli_insert_id($con);

    header("Location: ./addPorderItem.php");
} else {
    header("Location: ./newPorder.php");
}

?>