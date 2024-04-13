<?php
require 'session.php';
$pageTitle = "Announcements";
require 'header.php';
require 'sidebar.php';
require 'course_selector.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="mid-tile">
                <h1><?php
                $today = date("l, F j, Y");
                echo $today;
                ?></h1>
            </div>



        </div>
    </main>

</body>

</html>