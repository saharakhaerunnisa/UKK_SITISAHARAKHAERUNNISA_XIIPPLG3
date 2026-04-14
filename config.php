<?php

    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "";

    $conn = mysqli_connect($server, $username, $password, $database) or die ("Connection failed: " . mysqli_connect_error());
?>

