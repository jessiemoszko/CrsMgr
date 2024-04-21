<?php


session_start();

require("Database/DB.php");
require('helper_functions.php');

if (isset($_POST['recover_password'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);

    if (empty(trim($_POST["email"]))) {
        array_push($errors, "Email is required");
    }

    if (empty($errors)) {

        $user = get_records_where('users', 'email', $email);

        if (mysqli_num_rows($user) == 1) {

            $userData = mysqli_fetch_assoc($user);
            $username = $userData['username'];
            $password = $userData['password'];

            $to = $email;
            $subject = "Your Recovered Password";
            $message = "User info recovered\n\nusername: '$username' \npassword: '$password'";
            $headers = "From: XXXX";

            if (mail($to, $subject, $message, $headers)) {
                array_push($success, "Recovery mail sent, check email");
            } 
            
            else {
                array_push($errors, "Recovery mail not sent, please try again later");
            }
        } 
        
        else {
            array_push($errors, "Email not found in database");
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
    <link rel="stylesheet" href="login.css">
    <title>Forgot Password</title>

</head>

<body>

    <header>
        <h1>Forgot Password?</h1>
    </header>

    <main>
        <div class="form-container">

            <form class="form-body" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            
                <?php display_success($success); ?>
                <?php display_error($errors); ?>

                <div class="form-input">
                    <label>Email</label>
                    <span>
                        <input type="email" name="email">
                    </span>
                </div>

                <div class="form-submit">
                    <input type="submit" name="recover_password" value="Recover">
                    <br><br>
                    <a href="login.php">Back to login</a>
                
                </div>
            
            </form>
        
        </div>
    
    </main>

</body>

</html>
