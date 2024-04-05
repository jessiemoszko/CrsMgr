<?php
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
// Assume $groupID is the ID of the group to which you're adding the student

$sql = "INSERT INTO user (first_name, last_name, email, groupID) VALUES ('$firstName', '$lastName', '$email', $groupID)";

if ($conn->query($sql) === TRUE) {
    echo "New student added successfully";
} else {
    echo "Error: " . $conn->error;
}

header('Location: your_table_page.php');
?>
