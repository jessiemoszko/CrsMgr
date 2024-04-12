<?php
	require 'Database/DB.php';
	$id=$_GET['userID'];
	$query=mysqli_query($conn,"select * from `user` where userID='$id'");
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
		<label>Firstname:</label><input type="text" value="<?php echo $row['first_name']; ?>" name="firstname">
		<label>Lastname:</label><input type="text" value="<?php echo $row['last_name']; ?>" name="lastname">
		<input type="submit" name="submit">
		<a href="groups.php">Back</a>
	</form>
</body>
</html>