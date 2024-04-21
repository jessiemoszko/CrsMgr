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


function addCourse($conn, $course_name, $course_code, $dept_name, $semester, $room_no, $instructor_name) {
    global $errors, $success;

    if (empty($course_name) || empty($course_code) || empty($dept_name) || empty($semester) || empty($room_no) || empty($instructor_name)) {
        $errors[] = "All fields are required";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO courses (course_name, course_code, dept_name, semester, room_no, instructor_name) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $course_name, $course_code, $dept_name, $semester, $room_no, $instructor_name);
        if (mysqli_stmt_execute($stmt)) {
            $success[] = "Course added successfully";
        } else {
            $errors[] = "Error adding course: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);
}

function updateCourse($conn, $course_id, $course_name, $course_code, $dept_name, $semester, $room_no, $instructor_name) {
    global $errors, $success;

    if (empty($course_name) || empty($course_code) || empty($dept_name) || empty($semester) || empty($room_no) || empty($instructor_name)) {
        $errors[] = "All fields are required";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE courses SET course_name = ?, course_code = ?, dept_name = ?, semester = ?, room_no = ?, instructor_name = ? WHERE course_id = ?");
        mysqli_stmt_bind_param($stmt, "ssssssi", $course_name, $course_code, $dept_name, $semester, $room_no, $instructor_name, $course_id);
        if (mysqli_stmt_execute($stmt)) {
            $success[] = "Course updated successfully";
        } else {
            $errors[] = "Error updating course: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);
}

function deleteCourse($conn, $course_id) {
    global $errors, $success;

    $stmt = mysqli_prepare($conn, "DELETE FROM courses WHERE course_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $course_id);
    if (mysqli_stmt_execute($stmt)) {
        $success[] = "Course deleted successfully";
    } else {
        $errors[] = "Error deleting course: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    return array($success, $errors);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_course'])) {
        list($success, $errors) = addCourse($conn, mysqli_real_escape_string($conn, $_POST['course_name']), mysqli_real_escape_string($conn, $_POST['course_code']), mysqli_real_escape_string($conn, $_POST['dept_name']), mysqli_real_escape_string($conn, $_POST['semester']), mysqli_real_escape_string($conn, $_POST['room_no']), mysqli_real_escape_string($conn, $_POST['instructor_name']));
    } elseif (isset($_POST['update_course'])) {
        list($success, $errors) = updateCourse($conn, mysqli_real_escape_string($conn, $_POST['course_id']), mysqli_real_escape_string($conn, $_POST['course_name']), mysqli_real_escape_string($conn, $_POST['course_code']), mysqli_real_escape_string($conn, $_POST['dept_name']), mysqli_real_escape_string($conn, $_POST['semester']), mysqli_real_escape_string($conn, $_POST['room_no']), mysqli_real_escape_string($conn, $_POST['instructor_name']));
    }
}

if (isset($_GET['delete_id'])) {
    list($success, $errors) = deleteCourse($conn, mysqli_real_escape_string($conn, $_GET['delete_id']));
}

$query = "SELECT * FROM courses ORDER BY course_id ASC";
$results = mysqli_query($conn, $query);

$addedOrUpdated = !empty($success);
if ($addedOrUpdated) {
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
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
    <?php display_success($success); ?>
    <?php display_error($errors); ?>

    <h2>Courses</h2>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Course Name</th>
                <th>Course Code</th>
                <th>Department</th>
                <th>Semester</th>
                <th>Room No</th>
                <th>Instructor</th>
                <?php if (isAdmin()): ?>
                    <th colspan="2">Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['course_name'] ?></td>
                    <td><?= $row['course_code'] ?></td>
                    <td><?= $row['dept_name'] ?></td>
                    <td><?= $row['semester'] ?></td>
                    <td><?= $row['room_no'] ?></td>
                    <td><?= $row['instructor_name'] ?></td>
                    <?php if (isAdmin()): ?>
                        <td><a href="?page=course&update_view=true&update_id=<?= $row['course_id'] ?>">Update</a></td>
                        <td><a href="?page=course&delete_id=<?= $row['course_id'] ?>" onclick="return confirm('Are you sure you want to delete?')">Delete Course</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isAdmin()): ?>
        <a href="?page=course&add_view=true">
            <button>Add Course</button>
        </a>

        <?php if (isset($_GET['add_view'])): ?>
            <hr>
            <div class="form-container">
                <form class="form-body" action="" method="POST">
                    <h3>Add Course</h3>
                    <div class="form-input">
                        <label>Course Name</label>
                        <span><input type="text" name="course_name"></span>
                    </div>
                    <div class="form-input">
                        <label>Course Code</label>
                        <span><input type="text" name="course_code"></span>
                    </div>
                    <div class="form-input">
                        <label>Department</label>
                        <span><input type="text" name="dept_name"></span>
                    </div>
                    <div class="form-input">
                        <label>Semester</label>
                        <span><input type="text" name="semester"></span>
                    </div>
                    <div class="form-input">
                        <label>Room No</label>
                        <span><input type="text" name="room_no"></span>
                    </div>
                    <div class="form-input">
                        <label>Instructor</label>
                        <span><input type="text" name="instructor_name"></span>
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="add_course" value="Add">
                        <a href="CRUD-Courses.php"><button type="button">Cancel</button></a>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['update_view'])): ?>
            <?php $id = mysqli_real_escape_string($conn, $_GET['update_id']);
            $query = "SELECT * FROM courses WHERE course_id='$id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $course_name = $row['course_name'];
                $course_code = $row['course_code'];
                $dept_name = $row['dept_name'];
                $semester = $row['semester'];
                $room_no = $row['room_no'];
                $instructor_name = $row['instructor_name'];
            } else {
                $course_name = "";
                $course_code = "";
                $dept_name = "";
                $semester = "";
                $room_no = "";
                $instructor_name = "";
            }
            ?>

            <div class="form-container">
                <form class="form-body" action="" method="POST">
                    <h3>Update Course</h3>
                    <input type="hidden" name="course_id" value="<?= $id ?>">
                    <div class="form-input">
                        <label>Course Name</label>
                        <span><input type="text" name="course_name" value="<?= $course_name ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Course Code</label>
                        <span><input type="text" name="course_code" value="<?= $course_code ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Department</label>
                        <span><input type="text" name="dept_name" value="<?= $dept_name ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Semester</label>
                        <span><input type="text" name="semester" value="<?= $semester ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Room No</label>
                        <span><input type="text" name="room_no" value="<?= $room_no ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Instructor</label>
                        <span><input type="text" name="instructor_name" value="<?= $instructor_name ?>"></span>
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="update_course" value="Update">
                        <a href="CRUD-Courses.php"><button type="button">Cancel</button></a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <a href="admin.php">
        <button>Back to Admin Panel</button>
    </a>
    <a href="courses.php">
        <button>Refresh</button>
    </a>
</div>

</html>
