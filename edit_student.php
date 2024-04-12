<?php
    require 'Database/DB.php';
	$userID=$_GET['id'];
 
	$firstname=$_POST['firstname'];
	$lastname=$_POST['lastname'];
 
	mysqli_query($conn,"update `user` set first_name='$firstname', last_name='$lastname' where userID='$userID'");
	header('Location: groups.php');
?>

