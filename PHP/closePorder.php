<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

if ($_SESSION['isAdmin'] === 0) {
    header("Location: inspectPorder.php");
}

$stmt = $con->prepare("UPDATE request SET requestState = 'Closed' WHERE requestID = ?");
$stmt->bind_param("s", $_SESSION['activeInspectPorder']);
$stmt->execute();

header("refresh:3; url=viewPorders.php");
echo "Purchase Order Closed\n";
echo "Redirecting...";
$stmt->close();
?>