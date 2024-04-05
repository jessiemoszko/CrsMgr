<?php
require 'session.php';
$pageTitle = "Course Material";
require 'header.php';
require 'sidebar.php';

// Fetch data from the database
$lectureQuery = "SELECT material_ID, Title, `Post Date`, `Uploaded File`, `TYPE` FROM course_material WHERE `TYPE` = 'lecture'";
$lectureResult = mysqli_query($conn, $lectureQuery);

$tutorialQuery = "SELECT material_ID, Title, `Post Date`, `Uploaded File`, `TYPE` FROM course_material WHERE `TYPE` = 'tutorial'";
$tutorialResult = mysqli_query($conn, $tutorialQuery);


// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete_id'])) {
        // Delete record
        $deleteID = $_POST['delete_id'];
        $deleteQuery = "DELETE FROM course_material WHERE material_ID = '$deleteID'";
        if (mysqli_query($conn, $deleteQuery)) {
            // Refresh the page to reflect the updated data
            header("Refresh:0");
        } else {
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['edit_material_id'])) {
        // Update record
        $editID = $_POST['edit_material_id'];
        $editTitle = $_POST['edit_title'];
        $editPostDate = $_POST['edit_post_date'];

        // Check if a new file is uploaded
        $uploadedFile = $_FILES['edit_file']['name'] ? $_FILES['edit_file']['name'] : $_POST['old_file'];

        // Handle file upload
        if ($_FILES['edit_file']['name']) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["edit_file"]["name"]);
            if (move_uploaded_file($_FILES["edit_file"]["tmp_name"], $targetFile)) {
                $uploadedFile = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        $updateQuery = "UPDATE course_material SET Title = '$editTitle', `Post Date` = '$editPostDate', `Uploaded File` = '$uploadedFile' WHERE material_ID = '$editID'";
        if (mysqli_query($conn, $updateQuery)) {
            // Refresh the page to display the updated table
            header("Refresh:0");
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    } elseif (isset($_POST['title']) && isset($_POST['post_date'])) {
        // Add new record
        $title = $_POST['title'];
        $postDate = $_POST['post_date'];
        $type = $_POST['type'];

        // Handle file upload
        $uploadedFile = '';
        if ($_FILES['file']['name']) {
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["file"]["name"]);

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                $uploadedFile = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }

        // Update record in sql database
        $insertQuery = "INSERT INTO course_material (Title, `Post Date`, `Uploaded File`, `TYPE`) VALUES ('$title', '$postDate', '$uploadedFile', '$type')";
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
    <script>
        // Function to open the edit modal and populate the form fields
        function openEditModal(materialID, title, postDate, uploadedFile) {
            document.getElementById('edit_material_id').value = materialID;
            document.getElementById('edit_title').value = title;
            document.getElementById('edit_post_date').value = postDate;
            document.getElementById('old_file').value = uploadedFile;
            document.getElementById('editModal').style.display = 'block';
        }

        // Function to close the edit modal
        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
        }
    </script>
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
                    <?php if (isProfessor()) {
                        echo "<th>Delete</th>";
                        echo "<th>Edit</th>";
                    } ?>
                </tr>
                <?php
                while ($row = mysqli_fetch_assoc($lectureResult)) {
                    echo "<tr>";
                    echo "<td>" . $row['Title'] . "</td>";
                    echo "<td>" . $row['Post Date'] . "</td>";
                    $fileName = basename($row['Uploaded File']);
                    echo "<td><a href='" . $row['Uploaded File'] . "' target='_blank'>" . $fileName . "</a></td>";
                    if (isProfessor()) {
                        echo "<td>";
                        echo "<form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                        echo "<input type='hidden' name='delete_id' value='" . $row['material_ID'] . "'>";
                        echo "<input type='submit' value='Delete'>";
                        echo "</form>";
                        echo "</td>";
                        echo "<td>";
                        echo "<button onclick=\"openEditModal('" . $row['material_ID'] . "', '" . $row['Title'] . "', '" . $row['Post Date'] . "', '" . $row['Uploaded File'] . "')\">Edit</button>";
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
            <!-- Add New Course Material -->
            <?php if (isProfessor()) { ?>
                <h3>Add New Material</h3>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                    <label for="title">Title:</label>
                    <input type="text" id="title" name="title" required><br><br>
                    <label for="post_date">Post Date:</label>
                    <input type="date" id="post_date" name="post_date" required><br><br>
                    <label for="type">Type:</label>
                    <select id="type" name="type">
                        <option value="lecture">Lecture</option>
                        <option value="tutorial">Tutorial</option>
                    </select><br><br>
                    <label for="file">Upload File:</label>
                    <input type="file" id="file" name="file" required><br><br>
                    <input type="submit" value="Add New Material" class="button">
                </form>
            <?php } ?>

            <div>
                <h1>Tutorial</h1>
                <table>
                    <tr>
                        <th>Title</th>
                        <th>Post Date</th>
                        <th>Uploaded File</th>
                        <?php if (isProfessor()) {
                            echo "<th>Delete</th>";
                            echo "<th>Edit</th>";
                        } ?>
                    </tr>
                    <?php
                    while ($row = mysqli_fetch_assoc($tutorialResult)) {
                        echo "<tr>";
                        echo "<td>" . $row['Title'] . "</td>";
                        echo "<td>" . $row['Post Date'] . "</td>";
                        $fileName = basename($row['Uploaded File']);
                        echo "<td><a href='" . $row['Uploaded File'] . "' target='_blank'>" . $fileName . "</a></td>";
                        if (isProfessor()) {
                            echo "<td>";
                            echo "<form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                            echo "<input type='hidden' name='delete_id' value='" . $row['material_ID'] . "'>";
                            echo "<input type='submit' value='Delete'>";
                            echo "</form>";
                            echo "</td>";
                            echo "<td>";
                            echo "<button onclick=\"openEditModal('" . $row['material_ID'] . "', '" . $row['Title'] . "', '" . $row['Post Date'] . "', '" . $row['Uploaded File'] . "')\">Edit</button>";
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </table>
            </div>


        </div>
    </main>

    <div id="editModal" class="editModal">
        <div class="editModalContent">
            <span onclick="closeEditModal()" style="cursor: pointer; float: right;">&times;</span>
            <h2>Edit Material</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                <input type="hidden" id="edit_material_id" name="edit_material_id">
                <input type="hidden" id="old_file" name="old_file">
                <label for="edit_title">Title:</label>
                <input type="text" id="edit_title" name="edit_title" required><br><br>
                <label for="edit_post_date">Post Date:</label>
                <input type="date" id="edit_post_date" name="edit_post_date" required><br><br>
                <label for="edit_file">Replace File:</label>
                <input type="file" id="edit_file" name="edit_file"><br><br>
                <input type="submit" value="Save Changes" class="button">
            </form>
        </div>
    </div>



</body>

</html>