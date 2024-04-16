<?php
require 'Database/DB.php';

$userID = $_GET['userID'];

$sql = "DELETE FROM student_groups WHERE userID = $userID";

if ($conn->query($sql) === TRUE) {
    echo "Student deleted successfully";
} else {
    echo "Error: " . $conn->error;
}

// Redirect back to your table page
header('Location: groups.php');
?>
