<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

$stmt = $con->prepare("SELECT requestState FROM request WHERE requestID = ?");
$stmt->bind_param("s", $_SESSION['activeInspectPorder']);
$stmt->execute();
$stmt->bind_result($state);
$stmt->fetch();
$stmt->close();

if ($state === 'Pending' || $state === 'Issue') {
    $stmt = $con->prepare("UPDATE request SET requestState = 'Authorised', authorised = 1, authDate = CURDATE(), authStaffID = ? WHERE requestID = ?");
    $stmt->bind_param("si", $_SESSION['name'], $requestID);
    $requestID = $_SESSION['activeInspectPorder'];
    $stmt->execute();
    $stmt->close();

    header("refresh:3;url=inspectPorder.php");
    echo "Successfully Authorised Purchase Order Request #" . $requestID;
    echo "\nRedirecting...";
} else {
    header("refresh:3;url=inspectPorder.php");
    echo "The state of this order does not allow authorisation, as this has already occured.";
    echo "\nRedirecting...";
}
?>