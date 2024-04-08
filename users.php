<?php

$pageTitle = 'Admin Panel';

function addUser($conn, $first_name, $last_name, $dob, $email, $username, $password, $first_login, $roleID, $groupID) {
    global $errors;
    global $success;

    if (empty($first_name) || empty($last_name) || empty($dob) || empty($email) || empty($username) || empty($password) || empty($roleID)) {
        $errors[] = "All fields are required";
    } else {

        $stmt = mysqli_prepare($conn, "INSERT INTO user (first_name, last_name, dob, email, username, password, first_login, roleID, groupID) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssssiii", $first_name, $last_name, $dob, $email, $username, $password, $first_login, $roleID, $groupID);
        if (mysqli_stmt_execute($stmt)) {
            $success[] = "User added successfully";
        } else {
            $errors[] = "Error adding user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);
}

function updateUser($conn, $first_name, $last_name, $dob, $email, $username, $password, $roleID, $groupID, $userID) {
    global $errors;
    global $success;

    if (empty($first_name) || empty($last_name) || empty($dob) || empty($email) || empty($username) || empty($password) || empty($roleID)) {
        $errors[] = "All fields are required";
    } else {
        $stmt = mysqli_prepare($conn, "UPDATE user SET first_name = ?, last_name = ?, dob = ?, email = ?, username = ?, password = ?, roleID = ?, groupID = ? WHERE userID = ?");
        mysqli_stmt_bind_param($stmt, "ssssssiii", $first_name, $last_name, $dob, $email, $username, $password, $roleID, $groupID, $userID);
        if (mysqli_stmt_execute($stmt)) {
            $success[] = "User updated successfully";
        } else {
            $errors[] = "Error updating user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt);
    }
    return array($success, $errors);
}


function deleteUser($conn, $userID) {
    global $errors;
    global $success;

    $stmt = mysqli_prepare($conn, "DELETE FROM user WHERE userID = ?");
    mysqli_stmt_bind_param($stmt, "i", $userID);
    if (mysqli_stmt_execute($stmt)) {
        $success[] = "User deleted successfully";
    } else {
        $errors[] = "Error deleting user: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
    return array($success, $errors);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['add_user'])) {
        list($success, $errors) = addUser($conn, $_POST['first_name'], $_POST['last_name'], $_POST['dob'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['first_login'], $_POST['roleID'], $_POST['groupID']);
    } elseif (isset($_POST['update_user'])) {
        list($success, $errors) = updateUser($conn, $_POST['first_name'], $_POST['last_name'], $_POST['dob'], $_POST['email'], $_POST['username'], $_POST['password'], $_POST['roleID'], $_POST['groupID'], $_GET['update_id']);
    }
}

if (isset($_GET['delete_id'])) {
    list($success, $errors) = deleteUser($conn, $_GET['delete_id']);
}

$query = "SELECT * FROM user ORDER BY userID ASC";
$results = mysqli_query($conn, $query);

?>

<div class="content-body">
    <?php display_success($success); ?>
    <?php display_error($errors); ?>

    <h2>Users</h2>
    <hr>
    <table>
        <thead>
            <tr>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Username</th>
                <th>Password</th>
                <th>Role</th>
                <th>Group</th>
                <?php if (isAdmin()): ?>
                    <th colspan="2">Action</th>
                <?php endif; ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= $row['first_name'] ?></td>
                    <td><?= $row['last_name'] ?></td>
                    <td><?= $row['dob'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['username'] ?></td>
                    <td><?= $row['password'] ?></td>
                    <td><?= $row['roleID'] ?></td>
                    <td><?= $row['groupID'] ?></td>
                    <?php if (isAdmin()): ?>
                        <td><a href="?page=user&update_view=true&update_id=<?= $row['userID'] ?>">Update</a></td>
                        <td><a href="?page=user&delete_id=<?= $row['userID'] ?>" onclick="return confirm('Are you sure you want to delete?')">Delete</a></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if (isAdmin()): ?>
        <a href="?page=user&add_view=true">
            <button>Add User</button>
        </a>

        <?php if (isset($_GET['add_view'])): ?>
            <hr>
            <div class="form-container">
                <form class="form-body" action="" method="POST">
                    <h3>Add User</h3>
                    <div class="form-input">
                        <label>First Name</label>
                        <span><input type="text" name="first_name"></span>
                    </div>
                    <div class="form-input">
                        <label>Last Name</label>
                        <span><input type="text" name="last_name"></span>
                    </div>
                    <div class="form-input">
                        <label>Date of Birth</label>
                        <span><input type="date" name="dob"></span>
                    </div>
                    <div class="form-input">
                        <label>Email</label>
                        <span><input type="email" name="email"></span>
                    </div>
                    <div class="form-input">
                        <label>Username</label>
                        <span><input type="text" name="username"></span>
                    </div>
                    <div class="form-input">
                        <label>Password</label>
                        <span><input type="password" name="password"></span>
                    </div>
                    <div class="form-input">
                        <label>Role</label>
                        <span><input type="number" name="roleID"></span>
                    </div>
                    <div class="form-input">
                        <label>Group</label>
                        <span><input type="number" name="groupID"></span>
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="add_user" value="Add">
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['update_view'])): ?>
            <?php
            $id = mysqli_real_escape_string($conn, $_GET['update_id']);
            $query = "SELECT * FROM user WHERE userID='$id'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            } else {
                $row = array();
            }
            ?>

            <hr>
            <div class="form-container">
                <form class="form-body" action="" method="POST">
                    <h3>Update User</h3>
                    <div class="form-input">
                        <label>First Name</label>
                        <span><input type="text" name="first_name" value="<?= $row['first_name'] ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Last Name</label>
                        <span><input type="text" name="last_name" value="<?= $row['last_name'] ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Date of Birth</label>
                        <span><input type="date" name="dob" value="<?= $row['dob'] ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Email</label>
                        <span><input type="email" name="email" value="<?= $row['email'] ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Username</label>
                        <span><input type="text" name="username" value="<?= $row['username'] ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Password</label>
                        <span><input type="text" name="password" value="<?= $row['password'] ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Role</label>
                        <span><input type="number" name="roleID" value="<?= $row['roleID'] ?>"></span>
                    </div>
                    <div class="form-input">
                        <label>Group</label>
                        <span><input type="number" name="groupID" value="<?= $row['groupID'] ?>"></span>
                    </div>
                    <div class="form-submit">
                        <input type="submit" name="update_user" value="Update">
                    </div>
                </form>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>