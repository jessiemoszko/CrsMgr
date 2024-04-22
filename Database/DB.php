<?php

// $db_host = 'localhost:3308';
$db_host = 'zmc5531.encs.concordia.ca';
$db_name = 'zmc55314';
$db_user = 'zmc55314';
$db_pass = 'JYaYhQ';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("ERROR: Could not connect DB " . mysqli_connect_error());
}

?>