<?php

require 'Database/DB.php';

$sql = "SELECT `course_id`, `course_name`, `course_code`, `dept_name`, `semester`, `room_no`, `instructor_name` FROM `courses`";
$result = $conn->query($sql);
$selected_course_id = isset($_SESSION['selected_course_id']) ? $_SESSION['selected_course_id'] : '';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <title>Sidebar</title>
    <script>
        // JavaScript function to submit the form when a course is selected
        document.addEventListener("DOMContentLoaded", function() {
            // Get the form element
            var courseForm = document.getElementById("courseForm");

            // Add event listener to the select element
            var selectElement = document.getElementById("courses");
            selectElement.addEventListener("change", function() {
                // Submit the form when a course is selected
                courseForm.submit();
            });
        });
    </script>
</head>

<body>
    <div class="sidebar">
        <div class="course-selection">
            <h2 class="side">Course Manager</h2>
            <hr>
            <div class="select-container">
                <form id="courseForm" method="GET">
                    <label for="courses" class="label">Select a Course:</label>
                    <select id="courses" name="course_id" onchange="this.form.submit()">
                    <!-- Default option for no course selected -->
                    <option value="" <?php if (!isset($_GET['course_id']) || $_GET['course_id'] == '') echo 'selected'; ?>>...</option>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selected = "";
                                if (isset($_GET['course_id']) && $_GET['course_id'] == $row["course_id"]) {
                                    $selected = "selected";
                                }
                                echo '<option value="' . $row["course_id"] . '" ' . $selected . '>' . $row["course_code"] . '</option>';
                            }
                        } else {
                            echo '<option value="">No courses available</option>';
                        }
                        ?>
                    </select>
                </form>
            </div>
            <hr>
        </div>
        <div class="side-ul">
            <ul>
                <li>
                    <a href="index.php"><span class="material-icons">home</span>Home</a>
                </li>
                <li>
                    <a href="announcements.php"><span class="material-icons">campaign</span>Announcements</a>
                </li>
                <li>
                    <a href="course_material.php"><span class="material-icons">description</span>Course Material</a>
                </li>
                <li>
                    <a href="groups.php"><span class="material-icons">group</span>Groups</a>
                </li>
                <li>
                    <a href="assignment.php"><span class="material-icons">assignment</span>Assignments</a>
                </li>
                <li>
                    <a href="grades.php"><span class="material-icons">grade</span>Grades</a>
                </li>
                <li>
                    <a href="FAQ.php"><span class="material-icons">quiz</span>FAQ</a>
                </li>
                <li>
                    <a href="messages.php"><span class="material-icons">message</span>Messages</a>
                </li>
            </ul>
        </div>
        <div class="side-ul">
            <ul class="bottom">
            <li>
                    <a href="manage_account.php"><span class="material-icons">manage_accounts</span>Manage Account</a>
                </li>
                <li>
                    <a href="logout.php"><span class="material-icons">logout</span>Logout</a>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>