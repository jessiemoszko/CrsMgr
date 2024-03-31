<?php
require 'session.php';
$pageTitle = "Course Material";
include 'header.php';
include 'sidebar.php';

$course_materials = array(
    "WEEK 1" => array("Lecture slides", "Reading materials"),
    "WEEK 2" => array("Lab assignments", "Video tutorials"),
    "WEEK 3" => array("Homework assignments", "Additional resources")
);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="course_material.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <title>Course Material</title>
    <style>
        .week-header {
            cursor: pointer;
        }

        .week-header::after {
            content: "\25BC";
            /* Downward arrow */
            margin-left: 5px;
        }

        .course-materials {
            display: block;
        }
    </style>
</head>

<body>
    <main>
    <div class='container'>
        <?php if (isProfessor()) { ?>
            <div class="form">
                <br>
                <form class="add-week-form" action="" method="post">
                    <input type="text" id="new-week" name="new_week" placeholder="Enter week title">
                    <button type="submit" name="add_week">Add Week</button>
                </form>
                <br>
                <form action="add-material">
                    <input type="text" id="new-assignment" name="new_assignment" placeholder="Enter assignment title">
                    <button type="submit" name="add_assignment">Add Assignment</button>
                </form>
            </div>
        <?php } ?>
        <div class="main">
            <h3>Course Materials</h3>
            <?php foreach ($course_materials as $week => $materials) : ?>
                <h4 class="week-header"><?php echo $week; ?></h4>
                <ul class="course-materials">
                    <?php foreach ($materials as $material) : ?>
                        <li><?php echo $material; ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>

        
    </div>
    </main>
    <script>
        // Add click event listener to week headers to toggle course materials
        document.querySelectorAll('.week-header').forEach(item => {
            item.addEventListener('click', event => {
                const courseMaterials = item.nextElementSibling;
                courseMaterials.style.display = (courseMaterials.style.display === 'none') ? 'block' : 'none';
            });
        });
    </script>


</body>

</html>