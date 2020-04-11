<?php
session_start();

require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = $con->prepare("INSERT INTO requestedproduct VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $requestID, $productCode, $quantity, $supplierID);

$requestID = (int)$_SESSION['currentPorder'];

foreach($_SESSION['porderItems'] as $item) {
    $key = array_search($item, $_SESSION['porderItems']);
    $quantity = (int)$_SESSION['quantities'][$key];
    $supplierID = $_SESSION['suppliers'][$key];
    $productCode = $item;

    $_SESSION['costs'][$key] = $_SESSION['costs'][$key] * $_SESSION['quantities'][$key];

    $stmt->execute();
}

$totalCosts = array_sum($_SESSION['costs']);
$totalCosts = number_format((int) $totalCosts / 100, "2", ".", "");

$totalCostsVAT = ($totalCosts / 100 * 20) + $totalCosts;

$stmt = $con->prepare("UPDATE request SET subTotal = ?, totalCost = ? WHERE requestID = ?;");
$stmt->bind_param("dds", $totalCosts, $totalCostsVAT, $requestID);
$stmt->execute();

unset($_SESSION['porderItems']);
unset($_SESSION['suppliers']);
unset($_SESSION['quantities']);
unset($_SESSION['currentPorder']);
unset($_SESSION['activePorderItem']);
unset($_SESSION['costs']);

$stmt->close();

header("refresh:10;url=./home.php");
echo "<h1>Porder Complete.</h1>";
echo "<h5>Redirecting...</h5>";

?>