<?php
// Initialize the session
session_start();

// Database connection parameters
$db_host = 'localhost:3308';
$db_name = 'CRS';
$db_user = 'root';
$db_pass = '';

// Attempt to connect to MySQL database
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Check database connection
if (!$conn) {
    die("ERROR: Could not connect DB " . mysqli_connect_error());
}

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("Location: login.php");
    exit;
}

$errors = array();

$username = $_SESSION['username'];
$name = $_SESSION['name'];
$role_name = $_SESSION['role_name'];
$session_user_id = $_SESSION['user_id'];
$role_id = $_SESSION['role_id'];

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Welcome</title>
</head>

<body>

    <header>
        <div class="title-bar">
            <h1>Course Manager</h1>
            <nav>
                <div class="header-minimum">
                    <p>Logged in as <b><?= $name ?></b></p>
                    <a href="javascript:void(0);" class="hamburger-icon" onclick="toggleHamburger(this)">
                        <div class="hamburger bar1"></div>
                        <div class="hamburger bar2"></div>
                        <div class="hamburger bar3"></div>
                    </a>
                </div>
                <ul class="header-link" id="header-link">
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

</body>

<php require footer.php ?>

</html>
