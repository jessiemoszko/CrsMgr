<?php
require 'Database/DB.php';
$pageTitle = "Student Groups";
# include 'header.php';
#include 'sidebar.php';

$query = "SELECT * FROM user";
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
    <div class = "row mt-5">
    <div class="col">
      <div class="card mt-5">
        <div class="card-header"><h2>Group 1</h2></div>
        <div class="card-body">
      <table class="table table-bordered text-center">
          <tr class="bg-dark text-white">
            <td>User ID</td>
            <td>First Name </td>
            <td>Last Name</td>
            <td>Email</td>
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
<td><a href="#" class="btn btn-primary">Edit</a></td>
<td><a href="#" class="btn btn-danger">Delete</a></td>

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
