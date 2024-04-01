<?php

session_start();

$pageTitle='Reset Email';
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

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style1.css">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->
    <title>Reset Email</title>
</head>

<body>

    <header>
        <h1>Reset Email</h1>
    </header>

    <br>

    <main>

        <div class="container">

            <form class="form-body" action="" method="POST">

                <?php
                display_success($success);
                display_error($errors);
                ?>

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

            </form>

        </div>

    </main>
