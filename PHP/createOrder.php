<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$_SESSION['currentOrderSupplier'] = $_POST['pordersuppliercreate'];

$stmt = $con->prepare("INSERT INTO `order` (`orderDate`, `orderState`, `staffID`, `supplierID`) VALUES (CURDATE(), ?, ?, ?)");
$stmt->bind_param("sss", $orderstate, $_SESSION['name'], $_SESSION['currentOrderSupplier']);
$orderstate = "Pending";
$stmt->execute();

$_SESSION['currentOrder'] = mysqli_insert_id($con);

$_SESSION['currentOrderProducts'] = array();
$_SESSION['currentOrderQuantities'] = array();

$stmt = "SELECT productCode, quantity FROM requestedproduct WHERE requestID = " . $_SESSION['activeInspectPorder'] . ' AND supplierID = "' . $_SESSION['currentOrderSupplier'] . '"';
$result = $con->query($stmt);

while ($row = $result->fetch_assoc()) {
    array_push($_SESSION['currentOrderProducts'], $row['productCode']);
    array_push($_SESSION['currentOrderQuantities'], $row['quantity']);
}

$stmt = $con->prepare("SELECT costInPence FROM productsupplier WHERE productCode = ? AND supplierID = ?");
$stmt->bind_param("ss", $productCode, $_SESSION['currentOrderSupplier']);

$prices = array();

foreach ($_SESSION['currentOrderProducts'] as $prod) {
    $productCode = $prod;
    $key = array_search($prod, $_SESSION['currentOrderProducts']);
    $quant = (int)$_SESSION['currentOrderQuantities'][$key];
    $stmt->execute();
    $stmt->bind_result($cost);
    $stmt->fetch();

    $cost = $cost * $quant;

    array_push($prices, $cost);
}

$totalCost = array_sum($prices);

$totalCost = number_format((int) $totalCost / 100, "2", ".", "");

$totalCost = ($totalCost / 100) * 120;

$stmt->close();

$stmt = $con->prepare("UPDATE `order` SET orderTotalCost = ? WHERE orderNumber = ?");
$stmt->bind_param("di", $totalCost, $_SESSION['currentOrder']);
$stmt->execute();
$stmt->close();

$stmt = $con->prepare("INSERT INTO orderedproduct (orderNumber, productCode, quantity) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $_SESSION['currentOrder'], $product, $quant);

foreach ($_SESSION['currentOrderProducts'] as $item) {
    $key = array_search($item, $_SESSION['currentOrderProducts']);
    $product = $item;
    $quant = $_SESSION['currentOrderQuantities'][$key];
    $stmt->execute();
}

header("Location: viewPorders.php");
