<?php

session_start();

$errors = array();

//Database params
$db_host = 'localhost:3308';
$db_name = 'CRS';
$db_user = 'root';
$db_pass = '';

$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("ERROR: Could not connect DB " . mysqli_connect_error());
}

$select_db = mysqli_select_db($conn, $db_name);

if (!$select_db) {
    die("ERROR: Could not select DB " . mysqli_error($conn));
}

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

        $query = "SELECT * FROM users as u WHERE username='$username' AND password='$password' LIMIT 1";
        $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

        if (mysqli_num_rows($result) == 1) {

            $_SESSION['loggedin'] = true;

            $check = mysqli_fetch_assoc($result);
            $_SESSION['first_login'] = $check['first_login'];

            $_SESSION['user_id'] = $check['user_id'];
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $check['first_name'] . " " . $check['last_name'];

            $_SESSION['role_id'] = $check['role_id'];
            $roles = get_records_where('roles', 'role_id', $check['role_id']);
            foreach ($roles as $role) {
                if ($role['role_id'] == $check['role_id']) {
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="login_style.css">
    <title>Login</title>
</head>

<body>

    <header>
        <h1>Login</h1>
    </header>

    <main>


        <div class="form-container">

            <form class="form-body" action="<?= htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
                <br>
                <div class="input-container">
                    <div class="form-input">
                        <label>Username</label>
                        <span>
                            <input type="text" name="username" value="<?= $username; ?>">
                        </span>

                    </div>
                    
                    <div class="form-input">
                        <label>Password</label>
                        <span>
                            <input type="password" name="password">
                        </span>

                    </div>

                    <div class="form-submit">
                        <input type="submit" name="login_user" value="Login">
                        <br><br>
                    </div>
                </div>
            </form>
        </div>

    </main>

    </body>

</html>