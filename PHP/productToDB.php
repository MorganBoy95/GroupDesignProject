<?php
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header("Location: ../HTML/index.html");
    exit();
}

$stmt = $con->prepare("INSERT INTO product VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssisii", $code, $name, $type, $desc, $stock, $img, $min, $max);

$code = validateInput($_POST['newProdCode']);
$name = validateInput($_POST['newProdName']);
$type = validateInput($_POST['newProdType']);
$desc = validateInput($_POST['newProdDesc']);
$stock = validateInput($_POST['newProdInStck']);
$img = validateInput($_POST['newProdImg']);
$min = validateInput($_POST['newProdMin']);
$max = validateInput($_POST['newProdMax']);

$stmt->execute();

header("Location: products.php");
?>