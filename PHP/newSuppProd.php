<?php
session_start();
require "validate.php";
require "server.php";

if(!isset($_SESSION['loggedin'])){
    header("Location: ../HTML/index.html");
    exit();
}

$stmt = $con->prepare("INSERT INTO productsupplier VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssii", $_POST['SPCode'], $_POST['SPSupp'], $_POST['SPCost'], $_POST['SPDeliv']);
$stmt->execute();

header("Location: products.php");

?>