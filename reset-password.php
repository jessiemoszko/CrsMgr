<?php

session_start();

$pageTitle='Reset Password';
$name = $_SESSION['name'];

require 'header.php';
require 'sidebar.php';

require('Database/DB.php');
require('helper_functions.php');

$session_userID = $_SESSION['userID'];

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Reset Password</title>
</head>

<body>

    <header>
        <h1>Reset Password</h1>
    </header>

    <br>

    <main>

        <div class="container">

            <form class="form-body" action="" method="POST">

                <?php
                display_success($success);
                display_error($errors);
                ?>

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

            </form>

        </div>

    </main>

</body>

</html>
