<?php

require 'Database/DB.php';
// Initialize the session
session_start();

// Checks if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

/* I am trying to implement an automatic log out*/
/* 
$_SESSION['last_activity'] = time();
if (isset($_SESSION['userID'])) {
    $inactive_time = time() - $_SESSION['last_activity'];
    
    $timeout = 60; // in seconds
    
    if ($inactive_time > $timeout) {
        header("Location: logout.php");
        exit();
    }
}
*/
$username = $_SESSION['username'];
$name = $_SESSION['name'];
$role_name = $_SESSION['role_name'];
$session_userID = $_SESSION['userID'];
$roleID = $_SESSION['roleID'];

function isAdmin()
{
    if ($_SESSION['roleID'] == 1) {
        return true;
    }
    return false;
}

function isProfessor()
{
    if ($_SESSION['roleID'] == 2) {
        return true;
    }
    return false;
}

function isTA()
{
    if ($_SESSION['roleID'] == 3) {
        return true;
    }
    return false;
}

function isStudent()
{
    if ($_SESSION['roleID'] == 4) {
        return true;
    }
    return false;
}

?>
