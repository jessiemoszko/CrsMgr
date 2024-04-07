<?php
require 'session.php';
$pageTitle = 'Assignments';
require 'header.php';
require 'sidebar.php';
require 'course_selector.php';


// Fetch assignment information specific to selected course
$assignmentQuery = "SELECT * FROM assignments WHERE `course_id` = $course_id";
$assignmentResult = mysqli_query($conn, $assignmentQuery);


// For adding assignment
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Add new assignment file instructions
    if (isset($_POST["title"]) && isset($_POST['post_date'])) {
        // Add new record
        $title = $_POST['title'];
        $weight = $_POST['weight'];
        $maxMark = $_POST['max_mark'];
        $postDate = $_POST['post_date'];
        $dueDate = $_POST['due_date'];

        // Handle file upload
        $uploadedFile = '';
        if ($_FILES['file']['name']) {
            $targetDir = "uploads/uploaded_assignments/";
            $targetFile = $targetDir . basename($_FILES["file"]["name"]);

            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFile)) {
                $uploadedFile = $targetFile;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        // Update record in sql database
        $insertQuery = "INSERT INTO assignments (Title, `Weight`, `Max Mark`, `Post Date`, `Due Date`, `assign_instructions`, `course_id`) VALUES ('$title', '$weight', '$maxMark', '$postDate', '$dueDate', '$uploadedFile', '$course_id')";

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
    <link rel="stylesheet" href="style.css">
    <title>Assignment Upload</title>
</head>
<main>

    <body>
        <div class="container">
            <h1 class="page-title"><?php echo $course['course_code'] . " - " . $course['course_name'] ?></h1>
            <table>
                <tr>
                    <th>Assignment Name</th>
                    <th>File</th>
                    <th>Weight</th>
                    <th>Max Mark</th>
                    <th>Posted Date</th>
                    <th>Due Date</th>
                    <th>Upload</th>
                </tr>

                <!-- Table of Assignments -->

                <?php
                while ($row = mysqli_fetch_assoc($assignmentResult)) {
                    echo "<tr>";
                    echo "<td>" . $row['Title'] . '</td>';
                    $fileName = basename($row['assign_instructions']);
                    echo "<td><a href='" . $row['assign_instructions'] . "' target='_blank'>" . $fileName . "</a></td>";
                    echo '<td>' . $row['Weight'] . '</td>';
                    echo '<td>' . $row['Max Mark'] . '</td>';
                    echo '<td>' . $row['Post Date'] . '</td>';
                    echo '<td>' . $row['Due Date'] . '</td>';
                    echo "</tr>";
                }
                ?>
            </table>
            <!-- Button to trigger modal -->
            <div class="new_assign">
            <button class="new-assign" id="openModalBtn">Add New Assignment</button>
            </div>

            <!-- Modal -->
            <div id="uploadModal" class="editModal">
                <div class="editModalContent">
                    <span class="close">&times;</span>
                    <h2>Add New Assignment</h2>
                    <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
                        <label for="title">Title:</label>
                        <input type="text" id="title" name="title" required><br><br>
                        <label for="weight">Weight:</label>
                        <input type="number" id="weight" name="weight" required><br><br>
                        <label for="max_mark">Max Mark:</label>
                        <input type="number" id="max_mark" name="max_mark" required><br><br>
                        <label for="post_date">Post Date:</label>
                        <input type="date" id="post_date" name="post_date" required><br><br>
                        <label for="due_date">Due Date:</label>
                        <input type="date" id="due_date" name="due_date" required><br><br>
                        <label for="file">Upload File:</label>
                        <input type="file" id="file" name="file" required><br><br>
                        <input type="submit" value="Add New Material" class="button">
                    </form>
                </div>
            </div>

        </div>



        <!-- <div id="uploadModal" class="editModal">
            <div class="editModalContent">
                <span class="close">&times;</span>
                <h2>Upload Assignment</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="file">
                    <input type="submit" value="Upload" name="submit">
                </form>
            </div>
        </div> -->

        <script>
            var modal = document.getElementById("uploadModal");
            var openModalBtn = document.getElementById("openModalBtn");
            var closeModalBtn = document.querySelector(".close");

            // Function to open modal
            openModalBtn.onclick = function() {
                modal.style.display = "block";
            };

            // Function to close modal
            closeModalBtn.onclick = function() {
                modal.style.display = "none";
            };

            // Close modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };
        </script>

    </body>
</main>

</html>