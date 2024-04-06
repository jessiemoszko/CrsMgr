<?php
require 'session.php';
$pageTitle = 'Assignments';
require 'header.php';
require 'sidebar.php';

$assignmentQuery = 'SELECT `Title`, `Weight`, `Max Mark`, `Post Date`, `Due Date`, `assign_id`, `assign_instructions` FROM `assignments`';
$assignmentResult = mysqli_query($conn, $assignmentQuery);

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
        $insertQuery = "INSERT INTO assignments (Title, `Weight`, `Max Mark`, `Post Date`, `Due Date`, `assign_instructions`) VALUES ('$title', '$weight', '$maxMark', '$postDate', '$dueDate', '$uploadedFile')";

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
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assignment.css">
    <title>Assignment Upload</title>
</head>
<main>

    <body>
        <div class="container">
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

            <!-- Add Assignment -->
            
            <?php if (isProfessor()) { ?>
                <h3>Add New Assignment</h3>
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
            <?php } ?>

        </div>

        <!-- Modal -->
        <div id="uploadModal" class="editModal">
            <div class="editModalContent">
                <span class="close">&times;</span>
                <h2>Upload Assignment</h2>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <input type="file" name="file" id="file">
                    <input type="submit" value="Upload" name="submit">
                </form>
            </div>
        </div>


        <script>
            var modal = document.getElementById("uploadModal");
            var btns = document.querySelectorAll(".upload-btn");
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks the button, open the modal
            btns.forEach(function(btn) {
                btn.addEventListener("click", function() {
                    modal.style.display = "block";
                });
            });

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            };

            // When the user clicks anywhere outside of the modal, close it
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            };

            // Handle file upload
            document.querySelector('input[type="file"]').addEventListener('change', function() {
                var file = this.files[0];
                if (file) {
                    var fileName = file.name;
                    document.querySelector('.file-name').textContent = fileName;
                }
            });
        </script>
    </body>
</main>

</html>