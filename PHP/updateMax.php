<?php
session_start();
require "server.php";
require "validate.php";

if(!isset($_SESSION['loggedin'])) {
    header("Location: ../HTML/index.html");
    exit();
}

$stmt = $con->prepare("UPDATE product SET maxStock = ? WHERE productCode = ?");
$stmt->bind_param("is", $_POST['updateMaxNum'], $_POST['updateMaxProdCode']);
$stmt->execute();
$stmt->close();

header("Location: products.php");
?>