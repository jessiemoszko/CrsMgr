<?php require("header.php"); ?>

<head>
    <link rel="stylesheet" href="role_style.css">
</head>

<main>
    <div class="main-body">
        <section class="col-left">
            <div class="user-info">
                <p>Role: <?= $_SESSION['role_name'] ?></p>
            </div>
            <hr>
            <div class="main-menu">
                <br>
                <h3>Manage</h3>
                <ul class="menu-list">
                    <li><a href="?page=manage-students">Manage Students</a></li>
                    <li><a href="?page=grades">Grades</a></li>
                    <li><a href="?page=assignments">Assignments</a></li>
                    <li><a href="?page=announcements">Announcements</a></li>
                </ul>
            </div>
        </section>
        <section class="col-right">
            
        </section>
    </div>
</main>
<?php require("footer.php"); ?>
