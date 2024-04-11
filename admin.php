<?php 
$pageTitle = 'Admin Panel';

require("helper_functions.php");
 
require("session.php"); 
require("header.php");
?>

<main>
    <div class="main-body">
        <section class="col-left">
            <div class="main-menu">
                <h2>Manage</h2>
                <ul class="menu-list">
                    <li><a href="?page=roles">Modifying Roles</a></li>
                    <li><a href="?page=users">Modifiying users</a></li>
                </ul>

                <h2>Assign</h2>
                <ul class="menu-list">
                    <li><a href="?page=assign-professors">Professors</a></li>
                    <li><a href="?page=assign-tas">Teaching Assistants</a></li>
                    <li><a href="?page=assign-students">Students</a></li>
                </ul>

                <h2>Home</h2>
                <ul class="menu-list">
                    <li><a href="admin.php">Home</a></li>
                </ul>
            </div>
        </section>

        <section>
            <div class="col-right">

                <?php
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];
                        if (file_exists($page . ".php")) {
                            include($page . ".php");
                        }
                    }
                ?>
            </div>
        </section>
    </div>
</main>
