<?php
session_start();
require "validate.php";
require "server.php";
if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = $con->prepare("DELETE FROM requestedproduct WHERE requestID = ?");
$stmt->bind_param("s", $_SESSION['activeInspectPorder']);
$stmt->execute();

$stmt = $con->prepare("DELETE FROM request WHERE requestID = ?");
$stmt->bind_param("s", $_SESSION['activeInspectPorder']);
$stmt->execute();
$stmt->close();

header("refresh: 3; url=viewPorders.php");
echo "Request Deleted\n";
echo "Redirecting...";
?>
