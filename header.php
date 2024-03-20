<?php
// Initialize the session
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$role_name = $_SESSION['role_name'];
$session_user_id = $_SESSION['user_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Course Manager</title>
</head>

<body>

    <header>
        <div class="title-bar">
            <h1><?= $name ?></h1>
            <nav>
                <div class="header-minimum">                    
                <a href="javascript:void(0);" class="hamburger-icon" onclick="toggleHamburger(this)">
                        <div class="hamburger bar1"></div>
                        <div class="hamburger bar2"></div>
                        <div class="hamburger bar3"></div>
                    </a>

                    <ul class="header-link" id="header-link">
                        <li><a href="javascript:void(0)" onclick="history.back()">&larr;</a></li>
                        <li><a href="?page=home">Home</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>