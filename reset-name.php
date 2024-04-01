<?php

session_start();

$pageTitle='Reset First Name';
$name = $_SESSION['name'];

require 'header.php';
require 'sidebar.php';

require('Database/DB.php');
require('helper_functions.php');

$session_userID = $_SESSION['userID'];

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
    <link rel="stylesheet" href="style1.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Reset First Name</title>
</head>

<body>

    <header>
        <h1>Reset First Name</h1>
    </header>

    <br>

    <main>

        <div class="container">

            <form class="form-body" action="" method="POST">

                <?php
                display_success($success);
                display_error($errors);
                ?>

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

            </form>

        </div>

    </main>
