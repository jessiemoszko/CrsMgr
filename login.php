<?php

session_start();

$errors = array();

require("Database/DB.php");

function get_records_where($table, $key, $value)
{
    global $conn;
    $query = "SELECT * FROM $table WHERE $key='$value'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    return $result;
}

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    header("location: index.php");
    exit;
}

$username = $password = "";

if (isset($_POST['login_user'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required!");
    }
    if (empty($password)) {
        array_push($errors, "Password is required!");
    }

    if (count($errors) == 0) {

        $query = "SELECT * FROM user as u WHERE username='$username' AND password='$password' LIMIT 1";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($result) == 1) {

            $_SESSION['loggedin'] = true;

            $check = mysqli_fetch_assoc($result);
            $_SESSION['first_login'] = $check['first_login'];

            $_SESSION['userID'] = $check['userID'];
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $check['first_name'] . " " . $check['last_name'];

            $_SESSION['roleID'] = $check['roleID'];
            $roles = get_records_where('role', 'roleID', $check['roleID']);
            foreach ($roles as $role) {
                if ($role['roleID'] == $check['roleID']) {
                    $_SESSION['role_name'] = $role['role_name'];
                }
            }

            // Check role name after retrieving it from the database
            if (isset($_SESSION['role_name'])) {
                // Redirect based on the role name
                if ($_SESSION['role_name'] === "Professor") {
                    header("Location: professor.php");
                    exit;
                } elseif ($_SESSION['role_name'] === "Student") {
                    header("Location: student.php");
                    exit;
                }
            }

            /*
            if ($check['first_login'] == 1) {
                // I plan to have the user re-initialize the password
                header("Location: student.php");
                exit;
            } else {
                header("Location: student.php");
                exit;
            }
            */
        } else {
            array_push($errors, "Invalid username or password");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <title>Login</title>
</head>

<body>

    <div class="overlay">

        <div style="margin-top: 200px">
            <br>
        </div>

        <div>
            <h1 class="logo">Course Manager</h1>
        </div>

        <div class="form-container">

            <form class="form-body" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <br>
                <div class="input-container">
                    <div class="form-input">
                        <h2>Login</h2>
                        <span>
                            <input type="text" name="username" placeholder="USERNAME" value="<?= $username; ?>">
                        </span>

                    </div>

                    <br>

                    <div class="form-input">
                        <span>
                            <input type="password" name="password" placeholder="PASSWORD">
                        </span>

                    </div>

                    <br>

                    <div class="form-submit">
                        <input type="submit" name="login_user" value="Login">
                    </div>
                    <br><br>

                </div>
            </form>
        </div>

    </div>


</body>

</html>