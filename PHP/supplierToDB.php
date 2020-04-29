<?php
session_start();
require "validate.php";
require "server.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

if (!isset($_POST['newSuppID'], $_POST['newSuppName'], $_POST['newSuppAdd'], $_POST['newSuppCity'], $_POST['newSuppPost'], $_POST['newSuppCountry'])) {
    header("Location: supplierAdd.php");
} else {
    $stmt = $con->prepare("INSERT INTO supplier VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $ID, $name, $add, $city, $postcode, $country);

    $ID = validateInput($_POST['newSuppID']);
    $name = validateInput($_POST['newSuppName']);
    $add = validateInput($_POST['newSuppAdd']);
    $city = validateInput($_POST['newSuppCity']);
    $postcode = validateInput($_POST['newSuppPost']);
    $country = validateInput($_POST['newSuppCountry']);

    $stmt->execute();
    $stmt->close();

    header("Location: suppliers.php");
}
?>