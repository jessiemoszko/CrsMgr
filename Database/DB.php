<?php

// $db_host = 'localhost:3308';
$db_host = 'localhost';
$db_name = 'CRS';
$db_user = 'root';
$db_pass = '';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("ERROR: Could not connect DB " . mysqli_connect_error());
}

?>