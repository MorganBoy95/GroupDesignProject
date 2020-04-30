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

$stmt = $con->prepare("SELECT requestState FROM request WHERE requestID = ?");
$stmt->bind_param("s", $_SESSION['activeInspectPorder']);
$stmt->execute();
$stmt->bind_result($state);
$stmt->fetch();
$stmt->close();

if ($state === 'Authorised') {
    $stmt = $con->prepare("UPDATE request SET requestState = 'Confirmed', confirmed = 1, confirmedDate = CURDATE(), confirmedStaffID = ? WHERE requestID = ?");
    $stmt->bind_param("si", $_SESSION['name'], $requestID);
    $requestID = $_SESSION['activeInspectPorder'];
    $stmt->execute();
    $stmt->close();

    header("refresh:3;url=viewPorders.php");
    echo "Successfully Authorised Purchase Order Request #" . $requestID;
    echo "\nRedirecting...";
} else {
    header("refresh:3;url=viewPorders.php");
    echo "The state of this order does not allow confirmation, please authorise first.";
    echo "\nRedirecting...";
}
?>