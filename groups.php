<?php
require 'session.php';
$pageTitle = "Student Groups";
include 'header.php';
include 'sidebar.php';
require 'course_selector.php';

$query = "SELECT u.`userID`, u.`first_name`, u.`last_name`, u.`email`, g.`group_name`
FROM `student_groups` s
JOIN `user` u ON s.`userID` = u.`userID`
JOIN `group_info` g ON s.`groupID` = g.`groupID`
JOIN `user_course_section` c ON u.`userID` = c.`userID`
WHERE c.`course_id` = $course_id
ORDER BY g.`group_name`, u.`last_name`, u.`first_name`";
$result = mysqli_query($conn,$query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <title>Student Groups</title>
</head>


<body>

  <div class="container">
      <?php if (isProfessor() || isAdmin() || isTA()) { ?>
      <div class="add-student"><a class="btn btn-primary" href="add_student_groups.php">Add Student</a></div>
      <?php } ?>
        <div class="card-body">
      <table class="table table-bordered text-center">
            <tr class="bg-dark text-white">
            <td>User ID</td>
            <td>First Name </td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Group ID</td>
            <?php if (isProfessor() || isAdmin() || isTA()) { ?>
              <td>Edit</td>
              <td>Delete</td>
            <?php } ?>
            </tr>
          </tr>
          <tr>
<?php

while($row = mysqli_fetch_assoc($result)){
?>
<td><?php echo $row['userID']; ?></td>
<td><?php echo $row['first_name']; ?></td>
<td><?php echo $row['last_name']; ?></td>
<td><?php echo $row['email']; ?></td>
<td><?php echo $row['group_name']; ?></td>

  <?php if (isProfessor() || isAdmin() || isTA()) { ?>
    <td>
    <form action="edit_student_form.php" method="GET">
      <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  <?php } ?>
  </td>
  
  <?php if (isProfessor()|| isAdmin() || isTA()) { ?>
    <td>
    <form action="delete_student.php" method="GET">
      <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">
      <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    </td>
  <?php } ?>

</tr>
<?php
} 
?>
</table>
</div>

<style>
@import url('https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

.container {
    margin-top: 80px;
    margin-left: 250px;
    width: 100%;
    position: relative;
    box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.);
    border-radius: 0px;
    border-collapse: collapse;
    overflow: hidden;
}

body {
  background-color: #eff4ff;
    position: absolute;
    top: 0px;
    left: 0px;
    right: 0px;
    bottom: 0px; }

button[type=submit], .btn {
   font-family: 'Karla', sans-serif;
   background-color:  #29333F; 
   border: none;
   color: white;
   padding: 5px 10px 5px 10px;
   text-align: center;
   text-decoration: none;
   display: inline-block;
   font-size: 16px;
   margin: 4px 2px;
   cursor: pointer;
   border-radius: 10px
   
}

.add-student {
  margin-bottom:10px;
}

</style>

</body>
</html>

</style>

</body>
</html>
