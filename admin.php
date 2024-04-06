<?php
$pageTitle='Admin Panel';

require_once("session.php");
require("header.php"); 

function require_page($page)
{
    $pages = array(
        'roles' => 'modifyingRoles.php',
        'users' => 'modifyingUsers.php',
        'assigningProfessors' => 'assigningProfessors.php',
        'assigningTA' => 'assigningTA.php',
        'assigningStudents' => 'assigningStudents.php'
    );

    if (array_key_exists($page, $pages)) {
        $file = $pages[$page];
        require($file);
    } else {
        http_response_code(404);
    }
}

?>

<main>

    <div class="main-body">
        <section>
            <div class="col-left">
                <div class="main-menu">
                    <h2>Manage</h2>
                    <ul class="menu-list">
                        <li><a href="?page=roles">Roles</a></li>
                        <li><a href="?page=users">Users</a></li>
                    </ul>

                    <h2>Assign</h2>
                    <ul class="menu-list">
                        <li><a href="?page=assigningProfessors">Professors</a></li>
                        <li><a href="?page=assigningTA">Teaching Assistants</a></li>
                        <li><a href="?page=assigningStudents">Students</a></li>
                    </ul>
                </div>
            </div>
        </section>

        <section>
            <div class="col-right">

                <?php
                if (isset($_GET['page'])) {
                    require_page($_GET['page']);
                } 
                ?>

            </div>
        </section>
    </div>

</main>
