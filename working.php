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
            display: none; /* Initially hide course materials */
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
                        <button type="button" id="addWeek">Add Week</button>
                    </form>
                    <br>
                    <form id="addAssignmentForm" action="add-material">
                        <input type="text" id="new-assignment" name="new_assignment" placeholder="Enter assignment title">
                        <select id="week-select" name="week_select">
                            <?php foreach ($course_materials as $week => $materials) : ?>
                                <option value="<?php echo $week; ?>"><?php echo $week; ?></option>
                            <?php endforeach; ?>
                        </select>
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
        // Function to toggle display of course materials
        function toggleCourseMaterials(event) {
            const courseMaterials = event.target.nextElementSibling;
            courseMaterials.style.display = (courseMaterials.style.display === 'none') ? 'block' : 'none';
        }

        // Add click event listener to existing week headers
        document.querySelectorAll('.week-header').forEach(item => {
            item.addEventListener('click', toggleCourseMaterials);
        });

        // Add week dynamically
        document.getElementById('addWeek').addEventListener('click', function(event) {
            event.preventDefault();
            const newWeekTitle = document.getElementById('new-week').value.trim();
            if (newWeekTitle !== '') {
                const container = document.querySelector('.main');
                const newWeekHeader = document.createElement('h4');
                newWeekHeader.classList.add('week-header');
                newWeekHeader.textContent = newWeekTitle;
                newWeekHeader.addEventListener('click', toggleCourseMaterials);
                const newWeekMaterials = document.createElement('ul');
                newWeekMaterials.classList.add('course-materials');
                container.appendChild(newWeekHeader);
                container.appendChild(newWeekMaterials);
                document.getElementById('new-week').value = ''; // Clear input field
            }
        });

        // Add assignment under specific week
        document.getElementById('addAssignmentForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const assignmentTitle = document.getElementById('new-assignment').value.trim();
            const selectedWeek = document.getElementById('week-select').value;
            const weekList = document.querySelector('.main').querySelectorAll('.week-header');
            for (let week of weekList) {
                if (week.textContent === selectedWeek) {
                    const assignmentList = week.nextElementSibling;
                    const assignmentItem = document.createElement('li');
                    assignmentItem.textContent = assignmentTitle;
                    assignmentList.appendChild(assignmentItem);
                    break;
                }
            }
            document.getElementById('new-assignment').value = ''; // Clear input field
        });
    </script>
</body>

</html>
