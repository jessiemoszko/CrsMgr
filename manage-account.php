<?php

session_start();

require('Database/DB.php');

$sessionUserId = $_SESSION['userID'];

$success_messages = [];
$error_messages = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    EmailReset();
    PasswordReset();
    UsernameReset();
    FirstNameReset();

    // Redirect after form submission to prevent accidental resubmissions
    header("Location: {$_SERVER['REQUEST_URI']}");
    exit();
}

function display_success_messages($success_messages) {
    if (count($success_messages) > 0) {
        echo '<div class="success-messages notification">';
        foreach ($success_messages as $success_message) {
            echo $success_message . '<br>';
        }
        echo '</div>';
    }
}

function display_error_messages($error_messages) {
    if (count($error_messages) > 0) {
        echo '<div class="error-messages notification">';
        foreach ($error_messages as $error_message) {
            echo $error_message . '<br>';
        }
        echo '</div>';
    }
}


function get_table_array($conn, $table) {
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        throw new Exception("Error fetching records: " . mysqli_error($conn));
    }
    return $result;
}

function get_records_where($conn, $table, $key, $value) {
    $query = "SELECT * FROM $table WHERE $key=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $value);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (!$result) {
        throw new Exception("Error fetching records: " . mysqli_error($conn));
    }
    return $result;
}

function EmailReset() {
    global $conn, $sessionUserId, $error_messagess, $success_messages;

    if (isset($_POST['reset_email'])) {
        // Check if the new entered email is empty
        if (empty(trim($_POST["email_new"]))) {
            array_push($error_messagess, "New Email is required");
        } else {
            $email_new = mysqli_real_escape_string($conn, $_POST['email_new']);
        }
    
        $users_array = get_table_array('users');
    
        foreach ($users_array as $users) {
            // Check if the email is already in the db
            if ($users['email'] === $email_new) {
                array_push($error_messagess, "Email already exists");
            }
        }
    
        if (count($error_messagess) == 0) {
            $query = "UPDATE users SET email='$email_new' WHERE user_id='$session_user_id'";
            if (mysqli_query($conn, $query)) {
                array_push($success_messages, "Email reset successful");
            } else {
                array_push($error_messagess, "Email reset failed" . mysqli_error_messages($conn));
            }
        }
        
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();

    }
    
}

function PasswordReset() {
    global $conn, $sessionUserId, $error_messagess, $success_messages;

    if (isset($_POST['reset_password'])) {
        if (empty(trim($_POST["password_old"]))) {
            array_push($error_messagess, "Old Password is required");
        } else {
            $password_old = mysqli_real_escape_string($conn, $_POST['password_old']);
        }
    
        // Check if the new entered password is empty
        if (empty(trim($_POST["password_new"]))) {
            array_push($error_messagess, "New Password is required!");
        } else {
            $password_new = mysqli_real_escape_string($conn, $_POST['password_new']);
        }
    
        // Check if password_confirm is empty
        if (empty(trim($_POST["password_confirm"]))) {
            array_push($error_messagess, "Confirmation Password is required!");
        } else {
            $password_confirm = mysqli_real_escape_string($conn, $_POST['password_confirm']);
        }
    
        $password_db = mysqli_fetch_assoc(get_records_where($conn, 'user', 'user_id', $session_user_id))['password'];
    
        // Check if new and confirm password match
        if ($password_new !== $password_confirm) {
            array_push($error_messagess, "New and Confirmation Password must match!");
        }
    
        // Check if old password input match with password in db
        if ($password_db !== $password_old) {
            array_push($error_messagess, "Old Password is incorrect!");
        }
    
        if (count($error_messagess) == 0) {
            $query = "UPDATE users SET password='$password_new', first_login = 0 WHERE user_id='$session_user_id'";
            if (mysqli_query($conn, $query)) {
                array_push($success_messages, "Password reset successful");
            } else {
                array_push($error_messagess, "Password reset failed" . mysqli_error_messages($conn));
            }
        }
        
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }    
}

function UsernameReset() {
    global $conn, $sessionUserId, $error_messagess, $success_messages;

    if (isset($_POST['reset_username'])) {
        if (empty(trim($_POST["username_new"]))) {
            array_push($error_messagess, "New Username is required");
        } else {
            $username_new = mysqli_real_escape_string($conn, $_POST['username_new']);
        }
    
        $users_array = get_table_array('users');
        foreach ($users_array as $user) {
            if ($user['username'] === $username_new && $user['user_id'] !== $session_user_id) {
                array_push($error_messagess, "Username already exists");
            }
        }
    
        if (count($error_messagess) == 0) {
            $query = "UPDATE users SET username='$username_new' WHERE user_id='$session_user_id'";
            if (mysqli_query($conn, $query)) {
                array_push($success_messages, "Username reset successful");
            } else {
                array_push($error_messagess, "Username reset failed" . mysqli_error_messages($conn));
            }
        }

        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
    }
}

function FirstNameReset() {
    global $conn, $sessionUserId, $error_messagess, $success_messages;

    if (isset($_POST['reset_first_name'])) {
        if (empty(trim($_POST["first_name_new"]))) {
            array_push($error_messagess, "New First Name is required");
        } else {
            $first_name_new = mysqli_real_escape_string($conn, $_POST['first_name_new']);
        }
    
        if (count($error_messagess) == 0) {
            $query = "UPDATE users SET first_name='$first_name_new' WHERE user_id='$session_user_id'";
            if (mysqli_query($conn, $query)) {
                array_push($success_messages, "First Name reset successful");
            } else {
                array_push($error_messagess, "First Name reset failed" . mysqli_error_messages($conn));
            }
        }

        header("Location: {$_SERVER['REQUEST_URI']}");
        exit();
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
    <title>Manage Account</title>
</head>

<body>

    <header>
        <h1>Manage Account</h1>
    </header>

    <br>

    <main>

    <div class="form-container">
        <form class="form-body" action="" method="POST">
            <?php
            display_error_messages($error_messages);
            display_success_messages($success_messages);
            ?>
        </form>
    </div>

    <!-- Email Reset Section -->
    <div class="form-input">
        <label>Current Email</label>
        <span> <b><?= mysqli_fetch_assoc(get_records_where($conn, 'user', 'userID', $sessionUserId))['email'] ?></b></span>
    </div>
    
    <div class="form-input">
        <label>New Email</label>
        <span>
            <input type="email" name="email_new">
        </span>
    </div>
    
    <div class="form-submit">
        <input type="submit" name="reset_email" value="Reset Email">
    </div>

    <!-- Password Reset Section -->
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
        <label>Confirm Password</label>
        <span>
            <input type="password" name="password_confirm">
        </span>
    </div>

    <div class="form-submit">
        <input type="submit" name="reset_password" value="Reset Password">
    </div>
            
    <!-- Username Reset Section -->
    <div class="form-input">
        <label>New Username</label>
        <span>
            <input type="text" name="username_new">
        </span>
    </div>
    
    <div class="form-submit">
        <input type="submit" name="reset_username" value="Reset Username">
    </div>

    <!-- First Name Reset Section -->
    <div class="form-input">
        <label>New First Name</label>
        <span>
            <input type="text" name="first_name_new">
        </span>
    </div>
    
    <div class="form-submit">
        <input type="submit" name="reset_first_name" value="Reset First Name">
    </div>

    </form>

</main>

<?php require("footer.php") ?>
