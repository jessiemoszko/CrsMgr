<?php
require 'session.php';
$pageTitle = "Messages";
include 'header.php';
include 'sidebar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Messages</title>
    <style>
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .input-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .input-group label {
            text-align: right;
            flex: 1;
        }

        input[type="text"] {
            width: 100%;
        }
    </style>
</head>
<main>

    <body>
        <div class="container">
            <form action="" method="post">
                <div class="input-group">
                    <label for="to">To:</label>
                    <input type="text" id="to" name="To">
                </div>

                <div class="input-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject">
                </div>

                <div class="input-group">
                    <label for="message">Message:</label>

                    <textarea id="message" name="message" rows="4" cols="50"></textarea>
                </div>

                <input type="submit" value="Submit">
            </form>
    </body>

    </div>
</main>

</html>

<?php
include 'footer.php';
?>