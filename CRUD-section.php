<?php

$pageTitle = 'Admin Panel';

require("helper_functions.php");
require("session.php");
require("InitialsExtraction.php");


function addSection($conn, $section_name, $course_id) {
    global $errors, $success;

    if (empty($section_name) || empty($course_id)) {
        $errors[] = "All fields are required";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO section (section_name, course_id) VALUES (?, ?)");
        mysqli_stmt_bind_param($stmt, "si", $section_name, $course_id);
        if (mysqli_stmt_execute($stmt)) {
            $success[] = "Section added successfully";
        } else {
            $errors[] = "Error adding section: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);
}

function updateSection($conn, $section_name, $course_id, $sectionID) {
    global $errors, $success;

    if (empty($section_name) || empty($course_id)) {
        $errors[] = "All fields are required";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE section SET section_name = ?, course_id = ? WHERE sectionID = ?");
        mysqli_stmt_bind_param($stmt, "sii", $section_name, $course_id, $sectionID);
        if (mysqli_stmt_execute($stmt)) {
            $success[] = "Section updated successfully";
        } else {
            $errors[] = "Error updating section: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);
}

function deleteSection($conn, $sectionID) {
    global $errors, $success;

    $stmt = mysqli_prepare($conn, "DELETE FROM section WHERE sectionID = ?");
    mysqli_stmt_bind_param($stmt, "i", $sectionID);
    if (mysqli_stmt_execute($stmt)) {
        $success[] = "Section deleted successfully";
    } else {
        $errors[] = "Error deleting section: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    return array($success, $errors);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_section'])) {
        list($success, $errors) = addSection($conn, mysqli_real_escape_string($conn, $_POST['section_name']), mysqli_real_escape_string($conn, $_POST['course_id']));
    } elseif (isset($_POST['update_section'])) {
        list($success, $errors) = updateSection($conn, mysqli_real_escape_string($conn, $_POST['section_name']), mysqli_real_escape_string($conn, $_POST['course_id']), mysqli_real_escape_string($conn, $_POST['sectionID']));
    }
}

if (isset($_GET['delete_id'])) {
    list($success, $errors) = deleteSection($conn, mysqli_real_escape_string($conn, $_GET['delete_id']));
}


$query = "SELECT s.sectionID, s.section_name, s.course_id, c.course_name 
                FROM section as s
                JOIN courses as c ON s.course_id = c.course_id 
                ORDER BY s.sectionID ASC";

$results = mysqli_query($conn, $query);


$addedOrUpdated = !empty($success);
if ($addedOrUpdated) {
    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}
?>

<div class="content-body">
    <?php display_success($success); ?>
    <?php display_error($errors); ?>

    <h2>Sections</h2>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Section Name</th>
                <th>Course ID</th>
                <th>Course Name</th>
                <?php if (isAdmin()): ?>
                    <th colspan="2">Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['section_name'] ?></td>
                    <td><?= $row['course_id'] ?></td>
                    <td><?= $row['course_name'] ?></td>
                    <?php if (isAdmin()): ?>
                        <td><a href="?page=section&update_view=true&update_id=<?= $row['sectionID'] ?>">Update</a></td>
                        <td><a href="?page=section&delete_id=<?= $row['sectionID'] ?>" onclick="return confirm('Are you sure you want to delete?')">Delete Section</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isAdmin()): ?>
        <a href="?page=section&add_view=true">
            <button>Add Section</button>
        </a>

        <?php if (isset($_GET['add_view'])): ?>
            <hr>
            <div class="form-container">
                <form class="form-body" action="" method="POST">
                    <h3>Add Section</h3>
                    <div class="form-input">
                        <label>Section Name</label>
                        <span><input type="text" name="section_name"></span>
                    </div>
                    <div class="form-input">
                        <label>Course ID</label>
                        <span><input type="text" name="course_id"></span>
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="add_section" value="Add">
                        <a href="CRUD-section.php"><button type="button">Cancel</button></a>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['update_view'])): ?>
            <?php $id = mysqli_real_escape_string($conn, $_GET['update_id']);
            $query = "SELECT * FROM section WHERE sectionID='$id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $section_name = $row['section_name'];
                $course_id = $row['course_id'];
            } else {
                $section_name = "";
                $course_id = "";
            }
            ?>

            <div class="form-container">
                <form class="form-body" action="" method="POST">
                    <h3>Update Section</h3>
                    <input type="hidden" name="sectionID" value="<?= $id ?>">
                    <div class="form-input">
                        <label>Section Name</label>
                        <span><input type="text" name="section_name" value="<?= $section_name ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Course ID</label>
                        <span><input type="text" name="course_id" value="<?= $course_id ?>"></span>
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="update_section" value="Update">
                        <a href="CRUD-section.php"><button type="button">Cancel</button></a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
    <a href="admin.php">
        <button>Back to Admin Panel</button>
    </a>
    <a href="CRUD-section.php">
        <button>Refresh</button>
    </a>
</div>