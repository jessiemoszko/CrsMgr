<?php

require 'session.php';
$pageTitle = "FAQ";
include 'header.php';
include 'sidebar.php';

// Post a question
if (isset($_POST['submit_question'])) {
    $content = $_POST['content'];
    $userID = $_POST['userID'];

    $query = "INSERT INTO FAQ (question, userID) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "si", $content, $userID);
    mysqli_stmt_execute($stmt);
}

// Post a reply


/*
// Fetch replies for a question
if (isset($_GET['question_id'])) {
    $question_id = $_GET['question_id'];
    $query = "SELECT * FROM replies WHERE question_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $question_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $replies = mysqli_num_rows($result) > 0 ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];
} */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <title>FAQ</title>

</head>

<body>
    <main>
        <form action="FAQ.php" method="post" class="question-form">
            <label for="content">Question:</label><br>
            <textarea id="content" name="content" rows="4" cols="50"></textarea><br>
            <input type="hidden" id="userID" name="userID" value="<?php echo $_SESSION['userID']; ?>">
            <input type="submit" name="submit_question" value="Submit Question">
        </form>
        <?php
        // Fetch questions
        $query = "SELECT FAQ.question, user.first_name, user.last_name FROM FAQ INNER JOIN user ON FAQ.userID = user.userID";
        $result = mysqli_query($conn, $query);
        $questions = mysqli_num_rows($result) > 0 ? mysqli_fetch_all($result, MYSQLI_ASSOC) : [];


        // Check if there are any questions
        if (empty($questions)) {
            echo "<p>No questions.</p>";
        } else {
            // Display questions
            foreach ($questions as $question) {
                echo "<div class='question'>";
                echo "<h2>" . htmlspecialchars($question['question']) . "</h2>";
                echo "<p>Posted by: " . htmlspecialchars($question['first_name']) . " " . htmlspecialchars($question['last_name']) . "</p>";
                echo "<button type='button' class='btn btn-info btn-lg' data-toggle='modal' data-target='#myModal'>Reply</button>";
                // modal
                echo "<div class='modal fade' id='myModal' role='dialog'>";
                echo "<div class='modal-dialog'>";
                echo "<div class='modal-header'>";
                echo "<button type='button' class='close' data-dismiss='modal'>&times;</button>";
                echo "<h4 class='modal-title'> {$question['question']} </h4>";
                echo "</div>";
                echo "<div class='modal-body'>";
                echo "<form action='FAQ.php' method='post' class='reply-form'>";
                echo "<label for='content'>Reply:</label><br>";
                echo "<textarea id='content' name='content' rows='4' cols='50'></textarea><br>";
                echo "<input type='hidden' id='userID' name='userID' value='<?php echo {$_SESSION['userID']}; ?>'>";
                echo "<input type='submit' name='reply' value='Submit reply'>";
                echo "</form>";
                echo "</div>";
                echo "<div class='modal-footer'>";
                echo "<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>";
                if (isset($_POST1['submit_reply'])) {
                    $response = $_POST1['response'];
                    $userID = $_POST1['userID'];

                    $query = "INSERT INTO FAQResponse (Response, userID) VALUES (?, ?)";
                    $stmt = mysqli_prepare($conn, $query);
                    mysqli_stmt_bind_param($stmt, "si", $response, $userID);
                    mysqli_stmt_execute($stmt);
                }
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
        }
        ?>
</body>
</html>

<?php
// $activityLog = new ActivityLog(...$dbData);
// $activityLog->setAction($_SESSION['user_id'], "accessed the home page");
?>