<?php
    //session_start();
    //Define Connection Info
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'id12874597_admin';
    $DATABASE_PASS = 'admin';
    $DATABASE_NAME = 'id12874597_purchase_order_system';
    //Establish Connection
    $con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
    if ( mysqli_connect_errno() ) {
        die ('Failed to connect to MySQL: ' . mysqli_connect_error());
    }
?>