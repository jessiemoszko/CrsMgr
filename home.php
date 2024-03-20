<?php

session_start();

unset($_REQUEST);

$db_host = 'localhost:3308';
$db_name = 'cga';
$db_user = 'root';
$db_pass = '';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $role_name = $_SESSION['role_name'];
    $session_user_id = $_SESSION['user_id'];
    $role_id = $_SESSION['role_id'];
}

function isProfessor()
{
    if ($_SESSION['role_id'] == 2) {
        return true;
    }
    return false;
}

function isStudent()
{
    if ($_SESSION['role_id'] == 4) {
        return true;
    }
    return false;
}
?>

<div class="content-body">
    <h2>Home Page</h2>
    <hr>

    <?php if (isStudent()) { ?>
        <div class="student-info-content">
            <h3>Student Info</h3>
            <br>
            <p>Welcome, <?= $username ?>!</p>
            <p><a href="student.php">Go to Student Page</a></p>
            <hr>
        </div>
    <?php } ?>

    <?php if (isProfessor()) { ?>
        <div class="professor-info-content">
            <h3>Professor Info</h3>
            <br>
            <p>Welcome, <?= $username ?>!</p>
            <p><a href="professor.php">Go to Professor Page</a></p>
            <hr>
        </div>
    <?php } ?>

    <div class="logout-content">
        <h3>Logout</h3>
        <br>
        <p><a href="logout.php">Logout</a></p>
        <hr>
    </div>

</div>
