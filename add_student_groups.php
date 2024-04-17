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
        <label>User ID:</label><input type="text" name="userID">
        <label>Group ID:</label><input type="text" name="groupID">
        <input type="submit" name="submit">
        <a href="groups.php" class="back_button">Back</a>
    </form>
    </form>
</body>
</html>
