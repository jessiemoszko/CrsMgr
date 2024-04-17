<?php
require 'session.php';
$pageTitle = 'Welcome ' . ucwords($name);
require 'header.php';
require 'sidebar.php';

if (isTA()) {
    header("Location: TA.php");
    exit();
}

if (isprofessor()) {
    header("Location: professor.php");
    exit();
}

$assignmentQuery = "SELECT a.*, c.course_code 
                    FROM assignments a 
                    INNER JOIN courses c ON a.course_id = c.course_id
                    ORDER BY a.`Due Date` DESC";
$assignmentResult = mysqli_query($conn, $assignmentQuery);


// Query the announcements from the database
$query = "SELECT title, content, announcement_date, userID 
          FROM announcements ORDER BY announcement_date DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Student</title>
</head>

<body>
    <main>
        <div class="container">
            <h1>Homepage</h1>
            <div class="tiles">
                <ul class="tiles">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="#">Announcement</a>
                    </li>
                    <li>
                        <a href="course_material.php">Course Material</a>
                    </li>
                    <li>
                        <a href="groups.php">Group</a>
                    </li>
                    <li>
                        <a href="assignment.php">Assignment</a>
                    </li>
                    <li>
                        <a href="manage_account.php">Manage Account</a>
                    </li>
                </ul>
            </div>

            <div class="general-tile">
                <div class="mid-tile">
                    <h1 class="mid-content">Announcements</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Content</th>
                                <th>Date</th>
                                <?php if (isProfessor() || isTA() || isAdmin()) { ?>
                                    <th>User ID</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Display each announcement in a table row
                            if ($result && mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                                    echo "<td>" . nl2br(htmlspecialchars($row['content'])) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['announcement_date']) . "</td>";
                                    if (isProfessor() || isTA() || isAdmin()) {
                                        echo "<td>" . htmlspecialchars($row['userID']) . "</td>";
                                    }
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No announcements available.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
                <div class="mid-tile">
                    <h1 class="mid-content">Asssignments</h1>
                    <table>
                        <tr>
                            <th>Course</th>
                            <th>Assignment Name</th>
                            <th>Due Date</th>
                        </tr>

                        <?php
                        while ($row = mysqli_fetch_assoc($assignmentResult)) {
                            echo "<tr>";
                            echo "<td>" . $row['course_code'] . '</td>';
                            echo "<td>" . $row['Title'] . '</td>';
                            echo '<td>' . $row['Due Date'] . '</td>';
                            echo "</tr>";
                        }
                        ?>
                    </table>
                </div>
            </div>


        </div>

    </main>
</body>

</html>
<?php require("footer.php"); ?>