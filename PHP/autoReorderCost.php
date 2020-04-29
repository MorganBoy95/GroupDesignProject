<?php
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header("Location: ../HTML/index.html");
    exit();
}

# Auto Reorder Prioritising Cost #

#Define Arrays
$suppliers = array();
$codes = array();
$quantities = array();
$costs = array();

#SQL STMT to return all records with low stock
$stmt = "SELECT * FROM product WHERE amountInStock < minStock";
$result = $con->query($stmt);

#Sort information into arrays for each returned result
while ($row = $result->fetch_assoc()) {
    array_push($codes, $row['productCode']);
    $quant = (int)$row['maxStock'] - (int)$row['amountInStock'];
    array_push($quantities, $quant);
}

$stmt = $con->prepare("SELECT supplierID, costInPence FROM productsupplier WHERE productCode = ? ORDER BY costInPence ASC LIMIT 1");
$stmt->bind_param("s", $prodCode);

foreach ($codes as $item) {
    $prodCode = $item;
    $stmt->execute();
    $stmt->bind_result($suppID, $cost);
    $stmt->fetch();
    array_push($suppliers, $suppID);
    
    $key = array_search($item, $codes);
    $calcCost = $cost * (int)$quantities[$key];
    $calcCost = number_format((float)$calcCost / 100, 2, '.', '');
    array_push($costs, $calcCost);
}

$orderSubTotal = array_sum($costs);
$orderTotal = ($orderSubTotal / 100) * 120;

$stmt->close();

$stmt = $con->prepare("INSERT INTO request (staffID, `date`, requestState, subTotal, totalCost) VALUES (?, CURDATE(), 'Pending', ?, ?)");
$stmt->bind_param("sdd", $_SESSION['name'], $orderSubTotal, $orderTotal);
$stmt->execute();

$activeAutoReq = mysqli_insert_id($con);

$stmt->close();

$stmt = $con->prepare("INSERT INTO requestedproduct VALUES (?, ?, ?, ?)");
$stmt->bind_param("isis", $activeAutoReq, $productCode, $quantity, $supplierID);

foreach ($codes as $item) {
    $key = array_search($item, $codes);
    $productCode = $item;
    $quantity = $quantities[$key];
    $supplierID = $suppliers[$key];
    $stmt->execute();
}

$stmt->close();

header("refresh:3, url=viewPorders.php");

echo "<h2>Request Added as #" . $activeAutoReq . "</h2>\n";
echo "<h4>Redirecting...</h4>"

?>