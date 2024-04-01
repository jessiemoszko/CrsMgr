<?php

require 'Database\DB.php';
// Initialize the session
session_start();

// Checks if user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: login.php");
    exit;
}

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$role_name = $_SESSION['role_name'];
$session_userID = $_SESSION['userID'];
$roleID = $_SESSION['roleID'];

function isProfessor()
{
    if ($_SESSION['roleID'] == 2) {
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
