<?php
    require 'session.php';
	$userID=$_GET['id'];
 
	$groupID=$_POST['groupID'];
 
	mysqli_query($conn,"update `student_groups` set groupID='$groupID' where userID='$userID'");
	header('Location: groups.php');
