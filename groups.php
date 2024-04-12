<?php
require 'Database/DB.php';
$pageTitle = "Student Groups";
include 'header.php';
include 'sidebar.php';

$query = "SELECT * FROM user WHERE groupID = 1 OR groupID = 2";
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
        <div class="card-header"><a class="btn btn-primary" href="add_student.php">Add New Student</a></div>
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
<td> <?php echo $row['userID']?></td>
<td><?php echo $row['first_name']?></td>
<td><?php echo $row['last_name']?></td>
<td><?php echo $row['email']?></td>
<td><?php echo $row['groupID']?></td>
<td><a class="btn btn-primary" href="edit_student_form.php?userID=<?php echo $row['userID']; ?>">Edit</a></td>
<td><a class="btn btn-danger" href="delete_student.php?userID=<?php echo $row['userID']; ?>">Delete</a></td>


          </tr>
          <?php
          }
          ?>
         </table>
</div>
</div>
        </div>
      </div>
    </div>
     
</div>

</body>
</html>
