<?php
$pageTitle = 'Admin Panel';

require("helper_functions.php");
require("session.php");
require("InitialsExtraction.php");

if (isStudent()) {
    header("Location: student.php");
    exit();
}

if (isprofessor()) {
    header("Location: professor.php");
    exit();
}

if (isTA()) {
    header("Location: TA.php");
    exit();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Admin Panel</title>
</head>

<header class="header">
    <div class="header-text"><?php echo strtoupper($pageTitle) ?></div>
    <div class="user" onclick="toggleDropdown()">
        <div class="initials"><?php $initials = extractInitials($name);
                                echo $initials; ?></div>
        <div class="dropdown" id="dropdown">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</header>

<body>

    <div class="admin-container">

        <div class="tile-group">
            <div class="tiles-large">
                <h2>Manage</h2>
                <ul class="tiles">
                    <li><a href="roles.php">Modify Roles</a></li>
                    <li><a href="users.php">Modifiy Users</a></li>
                    <li><a href="CRUD-courses.php">Modifiy Courses</a></li>
                     <li><a href="CRUD-section.php">Modifiy Sections</a></li>

                </ul>
            </div>

            <div class="tiles-large">
                <h2>Assign</h2>
                <ul class="tiles">
                    <li><a href="assign-user.php">Assign User to Class and Section</a></li>
                </ul>
            </div>
        </div>
    </div>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("show");
        }
    </script>
</body>

</html>