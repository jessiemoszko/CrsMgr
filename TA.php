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

<<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <title>TA Panel</title>
</head>

<header class="header">

    <div class="header-text">
        <?php echo strtoupper($pageTitle) ?>
    </div>
    
    <div class="user" onclick="toggleDropdown()">

        <div class="initials"><?php $initials = extractInitials($name);
                                echo $initials; ?>
        </div>
        
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
                     <li><a href="groups.php">Modifiy Groups</a></li>
                     <li><a href="announcements.php">Modifiy Announcements</a></li>
                     <li><a href="assignments.php">Modifiy Assignments</a></li>
                     <li><a href="course_material.php">Modifiy Course Material</a></li>
                     <li><a href="FAQ.php">Modifiy FAQ</a></li>
                     <li><a href="grades.php">Modifiy Grades</a></li>
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