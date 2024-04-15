<?php
require 'session.php';
$pageTitle = "Grades";
require 'header.php';
require 'sidebar.php';

$sql = "SELECT
c.course_id, c.course_code,
g.grade_item, g.grade, g.weight,
u.userID, u.first_name, u.last_name
FROM grades g
JOIN courses c ON g.course_id = c.course_id
JOIN user u ON g.userID = u.userID";

$sqlResult = mysqli_query($conn, $sql);

if (!$sqlResult) {
    die("Error fetching data: ". mysqli_error($conn));
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Grades</title>
</head>

<body>
    <main>
        <div class="container">

            <table>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Course</th>
                    <th>Grade Item</th>
                    <th>Grade</th>
                    <th>Weight</th>
                </tr>

                    <!-- Fetch and display existing data from the database -->
                    <?php
                while ($row = mysqli_fetch_assoc($sqlResult)) {
                    echo "<tr>";
                    echo "<td>{$row['userID']}</td>";
                    echo "<td>{$row['first_name']} {$row['last_name']}</td>";
                    echo "<td>{$row['course_code']}</td>";
                    echo "<td>{$row['grade_item']}</td>";
                    echo "<td>{$row['grade']}</td>";
                    echo "<td>{$row['weight']}</td>";
                    echo "</tr>";
                }
                ?>
            </table>




        </div>
    </main>
</body>

</html>