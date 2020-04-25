<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = $con->prepare("UPDATE `order` SET orderState = 'All Delivered' WHERE orderNumber = ?");
$stmt->bind_param("i", $_SESSION['currentInspectOrder']);
$stmt->execute();
$stmt->close();

header("Location: viewOrders.php");
?>