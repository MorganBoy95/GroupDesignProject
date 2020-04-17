<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

if(!isset($_POST['porderissue'])) {
    header("Location: viewPorders.php");
} else {
    $stmt = $con->prepare("UPDATE request SET requestState = 'Issue', issueText = ? WHERE requestID = ?");
    $stmt->bind_param("ss", $issueText, $_SESSION['activeInspectPorder']);
    $issueText = validateInput($_POST['porderissue']);
    $stmt->execute();
    $stmt->close();

    header("Location: viewPorders.php");
}
?>