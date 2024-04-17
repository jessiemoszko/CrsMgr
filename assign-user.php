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

global $success;
global $errors;

if (isset($_POST['add'])) {

    $userID = mysqli_real_escape_string($conn, $_POST['userID']);
    $course_id = mysqli_real_escape_string($conn, $_POST['course_id']);
    $sectionID = mysqli_real_escape_string($conn, $_POST['sectionID']);

    $query = "SELECT * FROM user_course_section WHERE userID = '$userID' AND course_id = '$course_id' AND sectionID = '$sectionID'";
    $check = mysqli_query($conn, $query);

    if (mysqli_num_rows($check) > 0) {
        array_push($errors, "User is already assigned to this courses and section.");
    } else {
        $add_ucs = "INSERT INTO user_course_section (userID, course_id, sectionID) VALUES('$userID', '$course_id', '$sectionID')";

        if (mysqli_query($conn, $add_ucs)) {
            array_push($success, "User successfully assigned to this course and section");
            
            header("Location: assign-user.php");
            
            exit();
        } else {
            array_push($errors, "Could not insert: " . mysqli_error($conn));
        }
        
    }
}

if (isset($_GET['delete_view'])) {

    $userID = mysqli_real_escape_string($conn, $_GET['userID']);
    $course_id = mysqli_real_escape_string($conn, $_GET['course_id']);
    $sectionID = mysqli_real_escape_string($conn, $_GET['sectionID']);

    $delete_ucs = "DELETE FROM user_course_section WHERE userID='$userID' AND course_id='$course_id' AND sectionID='$sectionID'";

    if (mysqli_query($conn, $delete_ucs)) {
        array_push($success, "Delete successful");
    } else {
        array_push($errors, "Could not delete: " . mysqli_error($conn));
    }
}

/* $query = "SELECT ucs.userID, ucs.sectionID, c.course_id, c.course_name, s.section_name, u.first_name, u.last_name 
            FROM user_course_section ucs 
                JOIN user u ON u.userID = ucs.userID 
                JOIN courses c ON c.course_id = ucs.course_id 
                JOIN section s ON s.sectionID = ucs.sectionID 
            ORDER BY u.userID ASC";

$results = mysqli_query($conn, $query);
 */
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<div class="content-body">

    <?php

    display_success($success);
    display_error($errors);

    
    $query = "SELECT ucs.userID, ucs.sectionID, c.course_id, c.course_name, s.section_name, u.first_name, u.last_name 
                FROM user_course_section ucs 
                    JOIN user u ON u.userID = ucs.userID 
                    JOIN courses c ON c.course_id = ucs.course_id 
                    JOIN section s ON s.sectionID = ucs.sectionID 
                ORDER BY u.userID ASC";


    $results = mysqli_query($conn, $query);

    ?>
    <h2>Users - Courses - Sections</h2>
    <hr>
    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Course Name</th>
                <th>Section ID</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($results as $row) {
                $userID = $row['userID'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $course_id = $row['course_id'];
                $course_name = $row['course_name'];
                $sectionID = $row['sectionID'];
            ?>
                <tr>
                    <td><?= $first_name . " " . $last_name ?></td>
                    <td><?= $course_name ?></td>
                    <td><?= $sectionID ?></td>
                    <td><a href="?page=assign-user&delete_view=true&userID=<?= $userID ?>&course_id=<?= $course_id ?>&sectionID=<?= $sectionID ?>" onclick="return confirm('Please confirm deletion')">Delete</a></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>

    <a href="?page=assign-user&add_view=true">
        <button>Add New</button>
    </a>

    <?php if (isset($_GET['add_view'])) { ?>

        <div class="form-container">
            <form class="form-body" action="" method="POST">

                <div class="form-input">
                    <p>User</p>
                    <div class="scroll-list">
                        <select name="userID" id="userID">
                            <option value="" selected hidden>Choose a User</option>
                            <?php
                            $query = "SELECT * FROM user";
                            $user = mysqli_query($conn, $query);
                            foreach ($user as $user) {
                                $userID = $user['userID'];
                                $username = $user['username'];
                                echo "<option value='$userID'>$username</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-input">
                    <p>Course</p>
                    <div class="scroll-list">
                        <select name="course_id" id="course_id">
                            <option value="" selected hidden>Choose a Course</option>
                            <?php
                            $query = "SELECT * FROM courses";
                            $courses = mysqli_query($conn, $query);
                            foreach ($courses as $courses) {
                                $course_id = $courses['course_id'];
                                $course_name = $courses['course_name'];
                                echo "<option value='$course_id'>$course_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-input">
                    <p>Section</p>
                    <div class="scroll-list">
                        <select name="sectionID" id="sectionID">
                            <option value="" selected hidden>Choose a Section</option>
                            <?php
                            $query = "SELECT * FROM section WHERE course_id = '$course_id'";
                            $section = mysqli_query($conn, $query);
                            foreach ($section as $section) {
                                $sectionID = $section['sectionID'];
                                $section_name = $section['section_name'];
                                echo "<option value='$sectionID'>$section_name</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-submit">
                    <input type="submit" name="add" id="submit" value="Add">
                </div>
            </form>
        </div>

    <?php } ?>
    <a href="admin.php">
        <button>Back to Admin Panel</button>
    </a>
    <a href="assign-user.php">
        <button>Refresh</button>
    </a>

</div>

</html>

