<?php
// Assuming $conn is your database connection
$userID = $_POST['userID'];

$sql = "DELETE FROM user WHERE userID = $userID";

if ($conn->query($sql) === TRUE) {
    echo "Student deleted successfully";
} else {
    echo "Error: " . $conn->error;
}

// Redirect back to your table page
header('Location: your_table_page.php');
?>
