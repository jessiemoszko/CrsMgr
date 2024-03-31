<?php

// $db_host = 'localhost:3308';
$db_host = 'localhost:3306';
$db_name = 'crs';
$db_user = 'root';
$db_pass = 'mysql';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("ERROR: Could not connect DB " . mysqli_connect_error());
}


