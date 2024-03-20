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
                <div class="menu-list">
                    <h2><a href="?page=announcement-home">Announcement</a></h2>
                </div>
                <div class="menu-list">
                    <h2><a href="?page=course-material-home">Course Material</a></h2>
                </div>
                <div class="menu-list">
                    <h2><a href="?page=group-home">Group</a></h2>
                </div>
                <div class="menu-list">
                    <h2><a href="?page=assignment-home">Assignment</a></h2>
                </div>
                <div class="menu-list">
                    <h2><a href="?page=reset-email">Reset Email</a></h2>
                </div>
                <div class="menu-list">
                    <h2><a href="?page=reset-password">Reset Password</a></h2>
                </div>
            </div>
        </section>

        <section class="col-right">
            
        </section>
    </div>
</main>

<?php require("footer.php"); ?>