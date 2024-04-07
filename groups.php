<?php
require 'session.php';
$pageTitle = "Student Groups";
require 'header.php';
require 'sidebar.php';

$sql = "SELECT userID, first_name, last_name, email FROM user WHERE groupID = 1";
$result = $conn->query($sql);

//if query result has more than 0 rows as result 
if ($result->num_rows > 0) {
    // Output data of each row --> this has to go in the html file 
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["userID"]. "</td>";
        echo "<td>" . $row["first_name"]. "</td>";
        echo "<td>" . $row["last_name"]. "</td>";
        echo "<td>" . $row["email"]. "</td>";
        echo "<td><form action='delete_student.php' method='post'>
              <input type='hidden' name='userID' value='" . $row["userID"] . "'>
              <input type='submit' value='Delete'>
          </form>
          
          <form action="add_student.php" method="post">
          <input type="text" name="userID" placeholder="StudentID">
    <input type="text" name="firstName" placeholder="First Name">
    <input type="text" name="lastName" placeholder="Last Name">
    <input type="email" name="email" placeholder="Email">
    <input type="submit" value="Add Student">

</form>
          
          </td>";
    echo "</tr>";
    
    }
} else {
    echo "<tr><td colspan='4'>No results found</td></tr>";
}


?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Student Groups</title>
    <link rel="stylesheet" href="groups.css" />
  </head>
  <body>
    <div id="group-container">
      <!-- Group 1 -->
      <div class="group">
        <div class="group-name">
          <h2>Group 1 <button class="del-group-btn">Delete Group</button></h2>
        </div>
        <table>
          <tr>
            <th>Student ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
          </tr>
          <!-- Rows for students -->
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </table>
      </div>

      <div class="group-name">
        <h2>Group 2 <button class="del-group-btn">Delete Group</button></h2>
      </div>
      <table>
        <tr>
          <th>Student ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
        </tr>
        <!-- Rows for students -->
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
      </table>
    </div>

    <div>
      <div class="group-name">
        <h2>Group 3 <button class="del-group-btn">Delete Group</button></h2>
      </div>
      <table>
        <tr>
          <th>Student ID</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Email</th>
        </tr>
        <!-- Rows for students -->
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <!-- Additional rows can be added here -->
      </table>
    </div>

    <button class="add-group-btn">+ Add Group</button>

    <script>
      // JavaScript for adding/deleting rows and groups will go here
    </script>
  </body>
</html>




<?php

$conn->close();

?>
