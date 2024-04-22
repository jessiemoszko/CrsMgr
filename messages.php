<?php
require 'session.php';
$pageTitle = "Messages";
include 'header.php';
include 'sidebar.php';
require 'course_selector.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$classmateQuery = "SELECT userID FROM user_course_section WHERE 'course_id' = $course_id AND 'section_id' = $section_id";
// link to user_id from classmate query
$senderQuery = "SELECT first_name, last_name FROM user WHERE user_id IN $classmateQuery";
// Add a similar thing with groups
$groupQuery = "SELECT userID FROM student_groups WHERE groupID = $groupID";
$groupMessage = "SELECT first_name, last_name FROM user WHERE user_id IN $groupQuery";

/*
if (isset($_POST['submit_question'])) {
    $message = $_POST['message'];
    $subject = $_POST['subject'];
    $recipient = $_POST['To'];
    $userID = $_POST['userID'];

    $query = "INSERT INTO email (`userID`, `message`, `subject`, `is_sender`) VALUES ($userID, $message, $subject, 1)";


    //$query = "INSERT INTO email (userID, message, subject, is_sender) VALUES ($recipient, $message, $subject, 0)";

}*/
if (isset($_POST['submit_question'])) {

    $message = $_POST['message'];
    $subject = $_POST['subject'];
    $recipient = $_POST['To'];
    $userID = $_SESSION['userID'];

    if (empty($recipient)) {
        echo "Error: No recipient selected";
    } else {

        $senderQuery = "INSERT INTO email (`userID`, `message`, `subject`, `is_sender`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $senderQuery);
        mysqli_stmt_bind_param($stmt, "issi", $message, $subject, $is_sender);
        $is_sender = 1;
        mysqli_stmt_execute($stmt);
        if (mysqli_query($conn, $senderQuery)) {
            // Refresh the page to display the updated table
            header("Refresh:0");
        } else {
            echo "Error: " . $senderQuery . "<br>" . mysqli_error($conn);
        }

        $recipientQuery = "INSERT INTO email (`userID`, `message`, `subject`, `is_sender`) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $recipientQuery);
        mysqli_stmt_bind_param($stmt, "sssi", $recipient, $subject, $is_sender);
        $is_sender = 0;
        mysqli_stmt_execute($stmt);
        if (mysqli_query($conn, $recipientQuery)) {
            // Refresh the page to display the updated table
            header("Refresh:0");
        } else {
            echo "Error: " . $recipientQuery . "<br>" . mysqli_error($conn);
        }
    }
}



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
        <form action="" method="post">
            <div class="input-group">
                <label for="to">To:</label>
                <select id="to" name="To">
                <option value="" disabled selected>Choose a Recipient</option>
                    <?php
                    $query = "SELECT userID, first_name, last_name FROM user";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . htmlspecialchars($row['userID']) . "'>" . htmlspecialchars($row['first_name']) . " " . htmlspecialchars($row['last_name']) . "</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="input-group">
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject">
            </div>

            <div class="input-group">
                <label for="message">Message:</label>

                <textarea id="message" name="message" rows="4" cols="50"></textarea>
            </div>

            <input type="submit" name = "submit_question" value="Submit">
            <?php

            ?>

        </form>
        <!-- Messages section -->
        <div id="messages">
            <h2>Messages</h2>
            <div class="message-box">
                <style>
                    .message-box {
                        border: 1px solid #000;
                        padding: 10px;
                        margin: 10px 0;
                        width: 80%;
                        height: 200px;
                        margin-left: 50px;
                        overflow: auto;
                    }
                    #messages h2 {
                        margin-left: 50px;
                    }
                </style>
            </div>
        </div>

        <!-- Sent section -->
        <div id="sent">
            <h2>Sent</h2>
            <div class = "message-box">
                <style>
                    .message-box {
                        border: 1px solid #000;
                        padding: 10px;
                        margin: 10px 0;
                        width: 80%;
                        height: 200px;
                        margin-left: 50px;
                        overflow: auto;
                    }
                    #sent h2 {
                        margin-left: 50px;
                    }
                </style>
            </div>
        </div>
    </body>
</main>
</html>

<?php
$activityLog = new ActivityLog(...$dbData);
$activityLog->setAction($_SESSION['user_id'], "accessed the messages page");
?>