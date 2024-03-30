<?php

include 'header.php';
include 'sidebar.php';

// Initialize the session
session_start();

require("Database/DB.php");

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

$errors = array();

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$role_name = $_SESSION['role_name'];
$session_userID = $_SESSION['userID'];
$roleID = $_SESSION['roleID'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="student.css">
    <title>Student</title>
</head>

<body>


    <div class="content">
        <h1>Main Content</h1>
        <p>This is the main content area.</p>

    </div>
</body>

</html>

</body>

<!-- <?php include 'footer.php' ?> -->

</html>
