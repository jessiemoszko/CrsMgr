<?php


require 'Database/DB.php';

$sql = "SELECT `course_id`, `course_name`, `course_code`, `dept_name`, `semester`, `room_no`, `instructor_name` FROM `courses`";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="sidebar.css">
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
            </ul>
        </div>
        <div class="side-ul">
            <ul class="bottom">
                <li>
                    <a href="reset-email.php">Reset Email</a>
                </li>
                <li>
                    <a href="reset-password.php">Reset Password</a>
                </li>
                <li>
                    <a href="reset-username.php">Reset Username</a>
                </li>
                <li>
                    <a href="reset-name.php">Reset First Name</a>
                </li>
                <li>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</body>

</html>