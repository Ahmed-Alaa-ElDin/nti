<?php
    session_start();

    $serverName = 'localhost';
    $dbName = 'courses4U';
    $userName = 'root';
    $userPass = '';

    $con = mysqli_connect($serverName, $userName, $userPass, $dbName);

    if (!$con) {
        die('Error:' . mysqli_connect_error());    
    }
?>