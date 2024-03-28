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
$session_userID = $_SESSION['userID'];

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

    <header class="header">
        <div class="header-text">Welcome</div>
        <div class="user" onclick="toggleDropdown()">
            <?php
            $userInitials = "JM";
            ?>
            <div class="initials" <?php echo $userInitials; ?>></div>
            <div class="dropdown" id="dropdown">
                <a href="logout.php">Logout</a>
            </div>
        </div>

    </header>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("show");
        }
    </script>

</body>