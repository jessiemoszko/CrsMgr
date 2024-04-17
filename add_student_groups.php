  <?php
    require 'session.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userID = $_POST['userID'];
        $groupID = $_POST['groupID'];
        $query = mysqli_query($conn, "SELECT * FROM `user` WHERE userID='$userID'");
        if(mysqli_num_rows($query) > 0){
            $check_query = mysqli_query($conn, "SELECT * FROM `student_groups` WHERE userID='$userID'");
            if(mysqli_num_rows($check_query) == 0){
            $insert_query = mysqli_query($conn, "INSERT INTO `student_groups` (userID, groupID) VALUES ('$userID', '$groupID')");
            }
        }
    header('Location: groups.php');
} 
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Student</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Add User to Group</h2>
    <form method="POST" action="add_student_groups.php">
        <label>User ID:</label><input type="text" name="userID"><br>
        <label>Group ID:</label><input type="text" name="groupID"><br>
        <input type="submit" name="submit">
        <a href="groups.php" class="back_button">Back</a>
    </form>
    </form>
</body>

<style>

input[type="text"] {
	width: 75px;
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
