<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sidebar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <title>Student Dashboard</title>
</head>

<div class="sidebar">

    <div class="course-selection">
    <h2>Course Manager</h2>

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

    <ul>
        <li>
            <a href="#">Annoucement</a>
        </li>
        <li>
            <a href="#">Course Material</a>
        </li>
        <li>
            <a href="#">Group</a>
        </li>
        <li>
            <a href="#">Assignment</a>
        </li>

    </ul>

    <div>
        <ul class="bottom">
        <li>
            <a href="#">Reset Email</a>
        </li>
        <li>
            <a href="#">Reset Password</a>
        </li>
        </ul>
    </div>

</div>

</body>

</html>