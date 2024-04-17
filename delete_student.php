<?php
require 'session.php';

$userID = $_GET['userID'];

$sql = "DELETE FROM student_groups WHERE userID='$userID'";

if ($conn->query($sql) === TRUE) {
    echo "Student deleted successfully";
} else {
    echo "Error: " . $conn->error;
}

header('Location: groups.php');
?>
