<?php
	require 'Database/DB.php';
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
		<label>Group Name:</label><input type="text" value="<?php echo $row['groupID']; ?>" name="groupID">
		<input type="submit" name="submit">
		<a href="groups.php">Back</a>
	</form>
</body>
</html>
