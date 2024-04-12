<?php

session_start();

$pageTitle = 'Manage Account';
$name = $_SESSION['name'];

require 'header.php';
require 'sidebar.php';

require('Database/DB.php');
require('helper_functions.php');

$session_userID = $_SESSION['userID'];


$new_email = "";

if (isset($_POST['reset_email'])) {


    $new_email = trim($_POST["new_email"]);

    if (empty($new_email)) {
        array_push($errors, "New Email is required");
    } elseif (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Invalid email format");
    } else {
        $new_email = mysqli_real_escape_string($conn, $_POST['new_email']);
    }

    $user_array = get_table_array($conn, 'user');
    foreach ($user_array as $user) {
        if ($user['email'] === $new_email) {
            array_push($errors, "Email already exists");
        }
    }

    if (empty($errors)) {
        $existing_user = mysqli_fetch_assoc(get_records_where($conn, 'user', 'userID', $session_userID));
        if ($existing_user['email'] === $new_email) {
            $errors[] = "New email is the same as the current email";
        } else {
            $query = "UPDATE user SET email = '$new_email' WHERE userID='$session_userID'";
            if (mysqli_query($conn, $query)) {
                array_push($success, "Email reset successful");
            } else {
                array_push($errors, "Email reset failed" . mysqli_error($conn));
            }
        }
    }
}

$new_username = "";

if (isset($_POST['reset_username'])) {

    $new_username = trim($_POST["new_username"]);

    if (empty($new_username)) {
        array_push($errors, "New Username is required");
    } else {
        $new_username = mysqli_real_escape_string($conn, $_POST['new_username']);
    }

    $user_array = get_table_array($conn, 'user');
    foreach ($user_array as $user) {
        if ($user['username'] === $new_username && $user['userID'] !== $session_userID) {
            array_push($errors, "Username already exists");
        }
    }

    if (empty($errors)) {
        $existing_user = mysqli_fetch_assoc(get_records_where($conn, 'user', 'userID', $session_userID));
        if ($existing_user['username'] === $new_username) {
            $errors[] = "New username is the same as the current username";
        } else {
            $query = "UPDATE user SET username = '$new_username' WHERE userID='$session_userID'";
            if (mysqli_query($conn, $query)) {
                array_push($success, "Username reset successful");
            } else {
                array_push($errors, "Username reset failed" . mysqli_error($conn));
            }
        }
    }
}

$new_password = "";

if (isset($_POST['reset_password'])) {

    $password_old = trim($_POST["password_old"]);
    $password_new = trim($_POST["password_new"]);
    $password_confirm = trim($_POST["password_confirm"]);

    if (empty($password_old)) {
        array_push($errors, "Old Password is required");
    }

    if (empty($password_new)) {
        array_push($errors, "New Password is required");
    }

    if (empty($password_confirm)) {
        array_push($errors, "Confirmation Password is required");
    }

    if ($password_new !== $password_confirm) {
        array_push($errors, "New and Confirmation Password must match");
    }

    $user = mysqli_fetch_assoc(get_records_where($conn, 'user', 'userID', $session_userID));
    if ($user && $user['password'] !== $password_old) {
        array_push($errors, "Old Password is incorrect");
    }

    if (empty($errors)) {
        $query = "UPDATE user SET password = '$password_new', first_login = 0 WHERE userID = '$session_userID'";
        if (mysqli_query($conn, $query)) {
            array_push($success, "Password reset successfully");
        } else {
            array_push($errors, "Password reset failed: " . mysqli_error($conn));
        }
    }
}
$new_first_name = "";

if (isset($_POST['reset_first_name'])) {

    $new_first_name = trim($_POST["new_first_name"]);

    if (empty($new_first_name)) {
        array_push($errors, "New First Name is required");
    } else {
        $new_first_name = mysqli_real_escape_string($conn, $_POST['new_first_name']);
    }

    if (empty($errors)) {
        $query = "UPDATE user SET first_name = '$new_first_name' WHERE userID='$session_userID'";
        if (mysqli_query($conn, $query)) {
            array_push($success, "First Name reset successful");
        } else {
            array_push($errors, "First Name reset failed" . mysqli_error($conn));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Reset Email</title>
</head>

<body>

    <header>
        <h1>Reset Email</h1>
    </header>
    <br>
    <main>
        <div class="container">
            <div class="tiles">
                <ul class="tiles">
                    <li id="reset-email-button">
                        <a href="#">Reset Email</a>
                    </li>
                    <li id="reset-username-button">
                        <a href="#">Reset Username</a>
                    </li>
                    <li id="reset-password-button">
                        <a href="#">Reset Password</a>
                    </li>
                    <li id="reset-name-button">
                        <a href="#">Reset Name</a>
                    </li>
                </ul>
            </div>
            <div class="block" id="reset-email">
                <form class="form-body" action="" method="POST">
                    <h1>Reset Email</h1>
                    <?php if (!isset($_POST['reset_email']) || !empty($errors)) { ?>
                        <div class="form-input">
                            <label>Current Email</label>
                            <span> <b><?= mysqli_fetch_assoc(get_records_where($conn, 'user', 'userID', $session_userID))['email'] ?></b></span>
                        </div>
                        <div class="form-input">
                            <label>New Email</label>
                            <span>
                                <input type="email" name="new_email">
                            </span>
                        </div>
                        <div class="form-submit">
                            <input type="submit" name="reset_email" value="Reset">
                        </div>
                    <?php } ?>

                    <?php if (isset($_POST['reset_email']) && empty($errors)) { ?>
                        <span>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </span>
                    <?php } ?>
                    <br>
                    <?php
                    display_success($success);
                    display_error($errors);
                    ?>

                </form>


            </div>
            <div class="block" id="reset-username">

                <form class="form-body" action="" method="POST">
                    <h1>Reset Username</h1>


                    <?php if (!isset($_POST['reset_username']) || !empty($errors)) { ?>
                        <div class="form-input">
                            <label>Current Username</label>
                            <span> <b><?= mysqli_fetch_assoc(get_records_where($conn, 'user', 'userID', $session_userID))['username'] ?></b></span>
                        </div>
                        <div class="form-input">
                            <label>New Username</label>
                            <span>
                                <input type="text" name="new_username">
                            </span>
                        </div>
                        <div class="form-submit">
                            <input type="submit" name="reset_username" value="Reset">
                        </div>
                    <?php } ?>

                    <?php if (isset($_POST['reset_username']) && empty($errors)) { ?>
                        <span>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </span>
                    <?php } ?>
                    <br>
                    <?php
                    display_success($success);
                    display_error($errors);
                    ?>

                </form>
            </div>

            <div class="block" id="reset-password">
                <form class="form-body" action="" method="POST">
                    <h1>Reset Password</h1>
                    <?php if (!isset($_POST['reset_password']) || !empty($errors)) { ?>
                        <div class="form-input">
                            <label>Old Password</label>
                            <span>
                                <input type="password" name="password_old">
                            </span>
                        </div>
                        <div class="form-input">
                            <label>New Password</label>
                            <span>
                                <input type="password" name="password_new">
                            </span>
                        </div>
                        <div class="form-input">
                            <label>Confirm New Password</label>
                            <span>
                                <input type="password" name="password_confirm">
                            </span>
                        </div>
                        <div class="form-submit">
                            <input type="submit" name="reset_password" value="Reset">
                        </div>
                    <?php } ?>

                    <?php if (isset($_POST['reset_password']) && empty($errors)) { ?>
                        <span>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </span>
                    <?php } ?>
                    <br>
                    <?php
                    display_success($success);
                    display_error($errors);
                    ?>

                </form>
            </div>
            <div class="block" id="reset-name">
                <form class="form-body" action="" method="POST">
                    <h1>Reset Name</h1>
                    <?php if (!isset($_POST['reset_first_name']) || !empty($errors)) { ?>
                        <div class="form-input">
                            <label>Current First Name</label>
                            <span> <b><?= mysqli_fetch_assoc(get_records_where($conn, 'user', 'userID', $session_userID))['first_name'] ?></b></span>
                        </div>
                        <div class="form-input">
                            <label>New First Name</label>
                            <span>
                                <input type="text" name="new_first_name">
                            </span>
                        </div>
                        <div class="form-submit">
                            <input type="submit" name="reset_first_name" value="Reset">
                        </div>
                    <?php } ?>

                    <?php if (isset($_POST['reset_first_name']) && empty($errors)) { ?>
                        <span>
                            <a href="index.php">
                                <i class="fas fa-home"></i>
                            </a>
                        </span>
                    <?php } ?>
                    <br>
                    <?php
                    display_success($success);
                    display_error($errors);
                    ?>

                </form>
            </div>
        </div>

    </main>

    <script>
        // Hide all blocks initially
        document.getElementById("reset-email").style.display = "none";
        document.getElementById("reset-username").style.display = "none";
        document.getElementById("reset-password").style.display = "none";
        document.getElementById("reset-name").style.display = "none";

        // Function to hide all blocks
        function hideAllBlocks() {
            document.getElementById("reset-email").style.display = "none";
            document.getElementById("reset-username").style.display = "none";
            document.getElementById("reset-password").style.display = "none";
            document.getElementById("reset-name").style.display = "none";
        }

        // Function to show the corresponding block based on the clicked tile
        function showBlock(event) {
            hideAllBlocks();  // Hide all blocks
            const clickedTileId = event.target.parentNode.id;  // Get the ID of the clicked tile
            
            // Map the clicked tile ID to the corresponding block ID
            let blockId;
            switch (clickedTileId) {
                case "reset-email-button":
                    blockId = "reset-email";
                    break;
                case "reset-username-button":
                    blockId = "reset-username";
                    break;
                case "reset-password-button":
                    blockId = "reset-password";
                    break;
                case "reset-name-button":
                    blockId = "reset-name";
                    break;
                default:
                    return;  // Exit if no match
            }
            
            // Show the corresponding block
            document.getElementById(blockId).style.display = "block";
        }

        // Attach click event listeners to each tile link
        document.getElementById("reset-email-button").addEventListener("click", showBlock);
        document.getElementById("reset-username-button").addEventListener("click", showBlock);
        document.getElementById("reset-password-button").addEventListener("click", showBlock);
        document.getElementById("reset-name-button").addEventListener("click", showBlock);
    </script>



</body>

</html>