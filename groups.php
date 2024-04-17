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
  <link rel="stylesheet" href="groups.css">
  <title>Student Groups</title>
</head>


<body>

  <div class="container">
    <div class = "row mt-5">
    <div class="col">
      <div class="card mt-5">
      <?php if (isProfessor() || isAdmin() || isTA()) { ?>
      <div class="card-header"><a class="btn btn-primary" href="add_student_groups.php">Add Student</a></div>
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
</div>
</div>
</div>

</body>
</html>
