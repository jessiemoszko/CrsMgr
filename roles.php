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

function addRole($conn, $role_name) {
    global $errors;
    global $success;

    if (empty($role_name)) {
        $errors[] = "Role Name is required";
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO role (role_name) VALUES(?)");
        mysqli_stmt_bind_param($stmt, "s", $role_name);
        if (mysqli_stmt_execute($stmt)) {
            array_push($success, "Role added successfully");
        } else {
            array_push($errors, "Error adding role: " . mysqli_error($conn));
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);
}

function updateRole($conn, $role_name, $role_id) {
    global $errors;
    global $success;
    
    if (empty($role_name)) {
        array_push($errors, "Role Name is required");
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE role SET role_name = ? WHERE roleID = ?");
        mysqli_stmt_bind_param($stmt, "si", $role_name, $role_id);
        if (mysqli_stmt_execute($stmt)) {
            array_push($success, "Role updated successfully");
        } else {
            array_push($errors, "Error updating role: " . mysqli_error($conn));
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);

}

function deleteRole($conn, $role_id) {
    global $errors;
    global $success;
 
    $stmt = mysqli_prepare($conn, "DELETE FROM role WHERE roleID = ?");
    mysqli_stmt_bind_param($stmt, "i", $role_id);
    if (mysqli_stmt_execute($stmt)) {
        array_push($success, "Role deleted successfully");
    } else {
        array_push($errors, "Error deleting role: " . mysqli_error($conn));
    }
    mysqli_stmt_close($stmt);
    return array($success, $errors);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_role'])) {
        list($success, $errors) = addRole($conn, mysqli_real_escape_string($conn, $_POST['role_name']));
    } elseif (isset($_POST['update_role'])) {
        list($success, $errors) = updateRole($conn, mysqli_real_escape_string($conn, $_POST['role_name']), mysqli_real_escape_string($conn, $_GET['update_id']));
    }
}

if (isset($_GET['delete_id'])) {
    list($success, $errors) = deleteRole($conn, mysqli_real_escape_string($conn, $_GET['delete_id']));
}

$query = "SELECT * FROM role ORDER BY roleID ASC";
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

    <h2>Roles</h2>
    <hr>
    <table>
        <thead>
            <tr>
                <th>Role Name</th>
                <th>Role Description</th>
                <?php if (isAdmin()): ?>
                    <th colspan="2">Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['role_name'] ?></td>
                    <?php if (isAdmin()): ?>
                        <td><a href="?page=role&update_view=true&update_id=<?= $row['roleID'] ?>">Update</a></td>
                        <td><a href="?page=role&delete_id=<?= $row['roleID'] ?>" onclick="return confirm('Are you sure you want to delete?')">Delete Role</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isAdmin()): ?>
        <a href="?page=role&add_view=true">
            <button>Add Role</button>
        </a>

        <?php if (isset($_GET['add_view'])): ?>
            <hr>
            <div class="form-container">
                <form class="form-body" action="" method="POST">
                    <h3>Add Role</h3>
                    <div class="form-input">
                        <label>Role Name</label>
                        <span><input type="text" name="role_name"></span>
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="add_role" value="Add">
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['update_view'])): ?>
            <?php $id = mysqli_real_escape_string($conn, $_GET['update_id']);
            $query = "SELECT * FROM role WHERE roleID='$id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $role_name = $row['role_name'];
            } else {
                $role_name = "";
            }
            ?>

        <div class="form-container">
        <form class="form-body" action="" method="POST">
            <h3>Update Role</h3>
            <div class="form-input">
                <label>Role Name</label>
                <span><input type="text" name="role_name" value="<?= $role_name ?>"></span>
            </div>
            <div class="form-submit">
                <input type="submit" name="update_role" value="Update">
            </div>
        </form>
    </div>
        <?php endif; ?>
    <?php endif; ?>
    <a href="admin.php">
        <button>Back to Admin Panel</button>
    </a>
    <a href="roles.php">
        <button>Refresh</button>
    </a>
</div>
