<?php
require 'session.php';
$pageTitle = "Grades";
require 'header.php';
require 'sidebar.php';
require 'course_selector.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grades</title>
</head>

<body>
    <main>
        <div class="container">

            <table>
                <tr>
                    <th>Course</th>
                    <th>Component</th>
                    <th>Weight</th>
                    <th>Grade</th>
                </tr>
            </table>


        </div>
    </main>
</body>

</html>