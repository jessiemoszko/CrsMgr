<?php

session_start();

$pageTitle='Reset Username';
$name = $_SESSION['name'];

require 'header.php';
require 'sidebar.php';

require('Database/DB.php');
require('helper_functions.php');

$session_userID = $_SESSION['userID'];

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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Reset Username</title>
</head>

<body>

    <header>
        <h1>Reset Username</h1>
    </header>

    <br>

    <main>

        <div class="container">

            <form class="form-body" action="" method="POST">

                <?php
                display_success($success);
                display_error($errors);
                ?>

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

            </form>

        </div>

    </main>
