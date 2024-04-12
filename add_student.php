<?php
require 'Database/DB.php';
$firstName = $_POST['first_name'];
$lastName = $_POST['last_name'];
$email = $_POST['email'];
// Assume $groupID is the ID of the group to which you're adding the student

$sql = "INSERT INTO user (first_name, last_name, email, groupID) VALUES ('$firstName', '$lastName', '$email', $groupID)";

if ($conn->query($sql) === TRUE) {
    echo "New student added successfully";
} else {
    echo "Error: " . $conn->error;
}

header('Location: groups.php');
?>
