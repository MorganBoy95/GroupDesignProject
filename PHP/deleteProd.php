<?php
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header("Location ../HTML/index.html");
    exit();
}

$stmt = $con->prepare("DELETE FROM product WHERE productCode = ?");
$stmt->bind_param("s", $_POST['prodCode']);
$stmt->execute();
$stmt->close();

header("Location: products.php");
?>