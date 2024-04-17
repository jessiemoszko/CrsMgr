<?php
	require 'session.php';
	$id=$_GET['userID'];
	$query=mysqli_query($conn,"select * from `student_groups` where userID='$id'");
	$row=mysqli_fetch_array($query);
?>
<!DOCTYPE html>
<html>
<head>
<title>Basic MySQLi Commands</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
	<h2>Edit</h2>
	<form method="POST" action="edit_student.php?id=<?php echo $id; ?>">
		<label>Group Name:</label><input type="text" value="<?php echo $row['groupID']; ?>" name="groupID"><br>
		<input type="submit" name="submit">
		<a href="groups.php" class="back_button">Back</a>
	</form>
</body>

<style>

input[type="text"] {
	width: 50px;
}

.back_button {
   font-family: 'Karla', sans-serif;
   background-color:  #29333F; 
   border: none;
   color: white;
   padding: 5px 10px 5px 10px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 16px;
   margin: 15px 2px;
   cursor: pointer;
   border-radius: 10px
   
}

</style>
</html>

