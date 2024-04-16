<?php
require 'session.php';
$pageTitle = "Student Groups";
include 'header.php';
include 'sidebar.php';

$query = "SELECT u.`userID`, u.`first_name`, u.`last_name`, u.`email`, g.`group_name`
FROM `student_groups` s
JOIN `user` u ON s.`userID` = u.`userID`
JOIN `group_info` g ON s.`groupID` = g.`groupID`
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
        <div class="card-header"><a class="btn btn-primary" href="add_student.php">Add New Group</a></div>
        <div class="card-body">
      <table class="table table-bordered text-center">
          <tr class="bg-dark text-white">
            <td>User ID</td>
            <td>First Name </td>
            <td>Last Name</td>
            <td>Email</td>
            <td>Group ID</td>
            <td>Edit<t/td>
            <td>Delete</td>
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
<td>
  <?php if (isProfessor()) { ?>
    <button type="button" class="btn btn-primary" ondblclick="editGroupID(<?php echo $row['userID']; ?>)"><?php echo $row['group_name']; ?></button>
  <?php } else { ?>
    <?php echo $row['group_name']; ?>
  <?php } ?>
  </td>
  <td>
  <?php if (isProfessor()) { ?>
    <form action="delete_student_groups.php" method="POST">
      <input type="hidden" name="userID" value="<?php echo $row['userID']; ?>">
      <button type="submit" class="btn btn-danger">Delete</button>
    </form>
  <?php } ?>
</td>
</tr>
<?php
} // Add this closing brace
?>
</table>
</div>
</div>
</div>
</div>

</body>
</html>
