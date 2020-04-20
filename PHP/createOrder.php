<?php
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
$orderstate = "Not Delivered";
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

$stmt = $con->prepare("INSERT INTO orderline (orderNumber, productCode, quantity) VALUES (?, ?, ?)");
$stmt->bind_param("isi", $_SESSION['currentOrder'], $product, $quant);

foreach ($_SESSION['currentOrderProducts'] as $item) {
    $key = array_search($item, $_SESSION['currentOrderProducts']);
    $product = $item;
    $quant = $_SESSION['currentOrderQuantities'][$key];
    $stmt->execute();
}

header("Location: viewPorders.php");

?>