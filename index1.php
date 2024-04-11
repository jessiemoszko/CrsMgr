<?php
require 'Database/DB.php';

if (isStudent()) {
    header("Location: student.php");
    exit();
} 

if (isTA()) {
    header("Location: TA.php");
    exit();
} 

if (isProfessor()) {
    header("Location: professor.php");
    exit();
} 

if (isAdmin()) {
    header("Location: admin.php");
    exit();
}

$pageTitle='Welcome '.$name;
require 'header.php';
require 'sidebar.php';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Homepage</title>
</head>
<body>
    <main>
    <div class="container">
        <h1>Main Content</h1>
        <p>This is the main content area.</p>

    </div>
    </main>
</body>
</html>