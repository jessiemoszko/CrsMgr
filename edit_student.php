<?php
    require 'Database/DB.php';
	$userID=$_GET['id'];
 
	$groupID=$_POST['groupID'];
 
	mysqli_query($conn,"update `user` set groupID='$groupID' where userID='$userID'");
	header('Location: groups.php');
