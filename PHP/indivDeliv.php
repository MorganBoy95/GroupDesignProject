<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = $con->prepare("UPDATE orderedproduct SET delivered = 1, deliveredOn = CURDATE() WHERE orderNumber = ? AND productCode = ?");
$stmt->bind_param("is", $_SESSION['currentInspectOrder'], $_GET['indivDeliv']);
$stmt->execute();
$stmt->close();

$stmt = $con->prepare("SELECT quantity FROM orderedproduct WHERE orderNumber = ? AND productCode = ?");
$stmt->bind_param("is", $_SESSION['currentInspectOrder'], $_GET['indivDeliv']);
$stmt->execute();
$stmt->bind_result($quant);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("SELECT amountInStock FROM product WHERE productCode = ?");
$stmt->bind_param("s", $_GET['indivDeliv']);
$stmt->execute();
$stmt->bind_result($currStock);
$stmt->fetch();
$stmt->close();

$stmt = $con->prepare("UPDATE product SET amountInStock = ? WHERE productCode = ?");
$stmt->bind_param("is", $quant, $_GET['indivDeliv']);
$quant = $quant + $currStock;
$stmt->execute();
$stmt->close();

header("Location: viewOrders.php");
?>