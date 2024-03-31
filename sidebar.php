<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <title>Student Dashboard</title>
</head>

<body>
<div class="sidebar">
    <div class="course-selection">
        <h2 class="side">Course Manager</h2>
        <hr>
        <label for="courses">Select a Course:</label>
        <select id="courses" name="courses">
            <option value="math">COMP5531</option>
            <option value="science">COMP5201</option>
            <option value="history">COMP5541</option>
            <option value="english">COMP6721</option>
        </select>
        <hr>
    </div>
    <ul class="side-ul">
        <li>
            <a href="index.php">Home</a>
        </li>
        <li>
            <a href="#">Announcement</a>
        </li>
        <li>
            <a href="course_ material.php">Course Material</a>
        </li>
        <li>
            <a href="#">Group</a>
        </li>
        <li>
            <a href="assignment.php">Assignment</a>
        </li>
    </ul>
    <div>
        <ul class="bottom">
            <li>
                <a href="manage-account.php">Manage Account</a>
            </li>
            <li>
                <a href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</div>
</body>

</html>