<?php
session_start();
require "server.php";
require "validate.php";

if (!isset($_SESSION['loggedin'])) {
    header('Location:../HTML/index.html');
    exit();
}

if ($_SESSION['isAdmin'] === 0) {
    header("refresh: 3; url=viewPorders.php");
    echo "Insufficient Permissions. Redirecting...";
} else {
    $_SESSION['activeInspectPorder'] = $_GET['inspectPorder'];
    header("Location: inspectPorder.php");
}

?>