<?php
require 'session.php';
$pageTitle = "Course Material";
require 'header.php';
require 'sidebar.php';

// Fetch data from the database
$query = "SELECT material_ID, Title, `Post Date`, `Uploaded File` FROM course_material";
$result = mysqli_query($conn, $query);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form is deleting a row
    if (isset($_POST['delete_id'])) {
        $deleteID = $_POST['delete_id'];
        $deleteQuery = "DELETE FROM course_material WHERE material_ID = '$deleteID'";
        if (mysqli_query($conn, $deleteQuery)) {
            // Refresh the page to reflect the updated data
            header("Refresh:0");
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        // Retrieve form data for adding a new row
        $title = $_POST['title'];
        $postDate = $_POST['post_date'];
        
        // Handle file upload
        $uploadedFile = ''; // Initialize empty string
        if ($_FILES['file']['name']) {
            $targetDir = "uploads/"; // Specify the target directory where files will be uploaded
            $targetFile = $targetDir . basename($_FILES["file"]["name"]); // Specify the path of the uploaded file
            
            // Upload the file
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                $uploadedFile = $targetFile; // Set the uploaded file path
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    
        // Insert new row into the database
        $insertQuery = "INSERT INTO course_material (Title, `Post Date`, `Uploaded File`) VALUES ('$title', '$postDate', '$uploadedFile')";
        if (mysqli_query($conn, $insertQuery)) {
            // Refresh the page to display the updated table
            header("Refresh:0");
        } else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="course_material.css">
    <title>Course Material</title>
</head>

<body>
    <main>
        <div class="container">
       
            <h1>Lecture Notes</h1>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Post Date</th>
                    <th>Uploaded File</th>
                    <?php if (isProfessor()) {echo "<th>Action</th>";}?>
                </tr>
                <?php
                // Loop through the fetched data and display in table rows
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['Post Date'] . "</td>";
                    $fileName = basename($row['Uploaded File']);
                    echo "<td><a href='" . $row['Uploaded File'] . "' target='_blank'>" . $fileName . "</a></td>";
                    if (isProfessor()) {
                    echo "<td>";
                    // Form for deleting a row
                    echo "<form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                    echo "<input type='hidden' name='delete_id' value='" . $row['material_ID'] . "'>";
                    echo "<input type='submit' value='Delete'>";
                    echo "</form>";
                    echo "</td>";
                    echo "</tr>";
                }
                }
                ?>
            </table>

            <?php if (isProfessor()) { ?>

            <h3>Add New Material</h3>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <label for="title">Title:</label>
                <input type="text" id="title" name="title" required><br><br>
                
                <label for="post_date">Post Date:</label>
                <input type="date" id="post_date" name="post_date" required><br><br>
                
                <label for="file">Upload File:</label>
                <input type="file" id="file" name="file" required><br><br>
                
                <input type="submit" value="Add New Material" class="button">
            </form>

            <?php } ?>
        </div>

    </main>
    <script>

    </script>


</body>

</html>
