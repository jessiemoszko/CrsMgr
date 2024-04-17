<?php
$pageTitle = 'Admin Panel';

require("helper_functions.php");
require("session.php");

// Function to extract initials from a name
function extractInitials($name)
{
    $words = explode(" ", $name);
    $initials = "";

    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }

    return $initials;
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>Document</title>
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
                    <li><a href="roles.php">Modifying Roles</a></li>
                    <li><a href="users.php">Modifiying users</a></li>
                </ul>
            </div>

            <div class="tiles-large">
                <h2>Assign</h2>
                <ul class="tiles">
                    <li><a href="assign-user.php">Assigning Someone to a class</a></li>
                </ul>
            </div>
            <div class="tiles-large">
                <h2>Home</h2>
                <ul class="tiles">
                    <li><a href="admin.php">Home</a></li>
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