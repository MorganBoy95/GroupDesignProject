<?php
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = $con->prepare("SELECT maxStock, amountInStock FROM product WHERE productCode = ?");
$stmt->bind_param('s', $productCode);
$productCode = $_POST['productIDPorder'];
$stmt->execute();
$stmt->bind_result($maxStock, $currentStock);
$stmt->fetch();

if((int)$_POST['quantityPorder'] + (int)$currentStock > (int)$maxStock) {
    header("refresh:5;url=./addPorderItem.php");
    echo "Please ensure you are not exceeding the maximum stock limit of " . $maxStock . " for this item";
} else {
    $_SESSION['activePorderItem'] = $_POST['productIDPorder'];
    array_push($_SESSION['porderItems'], $_POST['productIDPorder']);
    array_push($_SESSION['quantities'], $_POST['quantityPorder']);

    header("Location: ./chooseSupplier.php");
}

$stmt->close();

?>