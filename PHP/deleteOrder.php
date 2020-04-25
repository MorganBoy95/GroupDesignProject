<?php
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = $con->prepare("DELETE FROM orderline WHERE orderNumber = ?");
$stmt->bind_param("i", $_SESSION['currentInspectOrder']);
$stmt->execute();
$stmt->close();

$stmt = $con->prepare("DELETE FROM `order` WHERE orderNumber = ?");
$stmt->bind_param("i", $_SESSION['currentInspectOrder']);
$stmt->execute();
$stmt->close();

header("Location: viewOrders.php");
?>