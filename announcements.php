<?php
require 'session.php';
$pageTitle = "Announcements";
require 'header.php';
require 'sidebar.php';
require 'course_selector.php';


// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $userID = mysqli_real_escape_string($conn, $_POST['userID']);

    // Insert the announcement into the database
    $sql = "INSERT INTO announcements (title, content, announcement_date, userID)
            VALUES ('$title', '$content', '$date', '$userID')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the same page to avoid resubmission on refresh
        header("Refresh:0");
    } else {
        echo "Error posting announcement: " . mysqli_error($conn);
    }
}

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
    <title>Document</title>
</head>

<body>
    <main>
        <div class="container">
            <div class="mid-tile">
                <h1>Recent Announcements</h1>

                <!-- Display announcements in a table -->
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Content</th>
                            <th>Date</th>
                            <?php  if (isProfessor() || isTA() || isAdmin()) { ?>
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
                                echo "<td>" . htmlspecialchars($row['userID']) . "</td>";}
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No announcements available.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <?php  if (isProfessor() || isTA() || isAdmin()) { ?>
            <h1>Post Announcement</h1>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" required><br>
                <label for="content" class="form-label">Content:</label><br>
                <textarea id="content" name="content" required></textarea><br>
                <label for="date" class="form-label">Announcement Date:</label>
                <input type="date" id="date" name="date" required><br>
                <label for="userID" class="form-label">User ID:</label>
                <input type="number" id="userID" name="userID" required><br>

                <button type="submit">Post Announcement</button>
            </form>
            <?php } ?>
        </div>
    </main>
</body>

</html>
<?php
$activityLog = new ActivityLog(...$dbData);
$activityLog->setAction($_SESSION['user_id'], "accessed the announcements page");
?>