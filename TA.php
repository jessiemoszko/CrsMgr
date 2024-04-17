<?php
require 'session.php';
$pageTitle = 'Welcome ' . ucwords($name);
require 'header.php';


if (isStudent()) {
    header("Location: student.php");
    exit();
}

if (isprofessor()) {
    header("Location: professor.php");
    exit();
}



require 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <title>TA</title>
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
<?php require("footer.php"); ?>