<?php
require 'session.php';
$pageTitle = "Grades";
require 'header.php';
require 'sidebar.php';

$sql = "SELECT
c.course_id, c.course_code,
g.grade_item, g.grade, g.weight,
u.userID, u.first_name, u.last_name
FROM grades g
JOIN courses c ON g.course_id = c.course_id
JOIN user u ON g.userID = u.userID";

$sqlResult = mysqli_query($conn, $sql);

if (!$sqlResult) {
    die("Error fetching data: " . mysqli_error($conn));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        // Handle deletion of grade item
        $delete_id = mysqli_real_escape_string($conn, $_POST['delete_id']);
        $delete_sql = "DELETE FROM grades WHERE grade_item = '$delete_id'";
        if (mysqli_query($conn, $delete_sql)) {
            // Redirect or provide feedback
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error deleting grade: " . mysqli_error($conn);
        }
    } else if (isset($_POST['gradeItem']) && isset($_POST['grade']) && isset($_POST['userID']) && isset($_POST['courseCode']) && isset($_POST['weight'])) {
        $gradeItem = mysqli_real_escape_string($conn, $_POST['gradeItem']);
        $grade = mysqli_real_escape_string($conn, $_POST['grade']);
        $userID = mysqli_real_escape_string($conn, $_POST['userID']);
        $courseCode = mysqli_real_escape_string($conn, $_POST['courseCode']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);

        // Update the grades record in the database
        $update_sql = "UPDATE grades SET grade = '$grade', userID = '$userID', course_id = (SELECT course_id FROM courses WHERE course_code = '$courseCode'), weight = '$weight' WHERE grade_item = '$gradeItem'";

        if (mysqli_query($conn, $update_sql)) {
            // Redirect after successful update
            header('Location: ' . $_SERVER['PHP_SELF']);
            exit;
        } else {
            echo "Error updating grades: " . mysqli_error($conn);
        }
    } else if (isset($_POST['addGrade'])) {
        // Handle adding a new grade
        $courseCode = mysqli_real_escape_string($conn, $_POST['courseCode']);
        $userID = mysqli_real_escape_string($conn, $_POST['userID']);
        $gradeItem = mysqli_real_escape_string($conn, $_POST['gradeItem']);
        $grade = mysqli_real_escape_string($conn, $_POST['grade']);
        $weight = mysqli_real_escape_string($conn, $_POST['weight']);

        $courseQuery = "SELECT course_id FROM courses WHERE course_code = '$courseCode'";
        $courseResult = mysqli_query($conn, $courseQuery);

        if ($courseResult) {
            $course = mysqli_fetch_assoc($courseResult);
            $courseID = $course['course_id'];

            $insertQuery = "INSERT INTO grades (course_id, userID, grade_item, grade, weight) VALUES ('$courseID', '$userID', '$gradeItem', '$grade', '$weight')";
            if (mysqli_query($conn, $insertQuery)) {
                // Redirect after successful insertion
                header('Location: ' . $_SERVER['PHP_SELF']);
                exit;
            } else {
                echo "Error inserting new grade: " . mysqli_error($conn);
            }
        } else {
            echo "Error fetching course ID: " . mysqli_error($conn);
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
    <title>Grades</title>
    <script>
        /* ADD GRADE MODAL*/

        // Function to open Add Grade modal
        document.getElementById('openAddGradeModal').onclick = function() {
            document.getElementById('addGradeModal').style.display = 'block';
        };


        // Close modal when user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                document.getElementById('addGradeModal').style.display = 'none';
            }
        };


        function openEditModal(gradeItem, grade, userID, courseCode, weight) {
            // Display the modal
            document.getElementById('editGradeModal').style.display = 'block';

            // Populate the form fields
            document.getElementById('gradeItem').value = gradeItem;
            document.getElementById('grade').value = grade;
            document.getElementById('userID').value = userID;
            document.getElementById('courseCode').value = courseCode;
            document.getElementById('weight').value = weight;
        }
 
        // Close the modal when the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == modal) {
                document.getElementById('editGradeModal').style.display = 'none';
            }
        };
    </script>
</head>

<body>
    <main>
        <div class="container">
            <table id="gradesTable">
                <thead>
                    <tr>
                        <?php if (isProfessor() || isTA() || isAdmin()) {
                            echo "<th onclick='sortTable(0)'>User Id <span>&#x25B2;</span></th>";
                            echo "<th onclick='sortTable(1)'>Name <span>&#x25B2;</span></th>";
                        } ?>
                        <th onclick='sortTable(2)'>Course <span>&#x25B2;</span></th>
                        <th onclick='sortTable(3)'>Grade Item <span>&#x25B2;</span></th>
                        <th onclick='sortTable(4)'>Grade <span>&#x25B2;</span></th>
                        <th onclick='sortTable(5)'>Weight <span>&#x25B2;</span></th>
                        <?php if (isProfessor() || isTA() || isAdmin()) {
                            echo "<th>Delete</th>";
                            echo "<th>Edit</th>";
                        } ?>
                    </tr>
                </thead>
                <tbody>
                    <!-- Fetch and display existing data from the database -->
                    <?php
                    while ($row = mysqli_fetch_assoc($sqlResult)) {
                        echo "<tr>";
                        if (isProfessor() || isTA() || isAdmin()) {
                            echo "<td>{$row['userID']}</td>";
                            echo "<td>{$row['first_name']} {$row['last_name']}</td>";
                        }
                        echo "<td>{$row['course_code']}</td>";
                        echo "<td>{$row['grade_item']}</td>";
                        echo "<td>{$row['grade']}</td>";
                        echo "<td>{$row['weight']}</td>";
                        if (isProfessor() || isTA() || isAdmin()) {
                            echo "<td>";
                            echo "<form method='POST' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>";
                            echo "<input type='hidden' name='delete_id' value='" . $row['grade_item'] . "'>";
                            echo "<input type='submit' value='Delete'>";
                            echo "</form>";
                            echo "</td>";
                            echo "<td>";
                            echo "<button onclick=\"openEditModal('{$row['grade_item']}', '{$row['grade']}', '{$row['userID']}', '{$row['course_code']}', '{$row['weight']}')\">Edit</button>";
                            echo "</td>";
                        }
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>


            <!-- Add Grade button -->
            <?php if (isProfessor() || isTA() || isAdmin()) { ?>
                <button id="openAddGradeModal" class="modal-button">Add Grade</button>
            <?php } ?>
        </div>
    </main>


    <!-- Edit Grade Modal -->
    <div id="editGradeModal" class="editModal">
        <div class="editModalContent">
            <span class="close" onclick="closeEditModal()">&times;</span>
            <h2>Edit Grade</h2>
            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                <label for="userID" class="form-label">User ID:</label>
                <input type="text" id="userID" name="userID" required>
                <label for="courseCode" class="form-label">Course Code:</label>
                <input type="text" id="courseCode" name="courseCode" required>
                <label for="gradeItem" class="form-label">Grade Item:</label>
                <input type="text" id="gradeItem" name="gradeItem">
                <label for="grade" class="form-label">Grade:</label>
                <input type="number" id="grade" name="grade" required>
                <label for="weight" class="form-label">Weight:</label>
                <input type="number" id="weight" name="weight" required>
                <button type="submit" class="modal-button">Save</button>
            </form>

        </div>
    </div>
</body>

<!-- Add Grade Modal -->
<div id="addGradeModal" class="editModal">
    <div class="editModalContent">
        <span class="close">&times;</span>
        <h2>Add Grade</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
            <label for="courseCode">Course Code:</label>
            <input type="text" id="courseCode" name="courseCode" required>
            <label for="userID">User ID:</label>
            <input type="text" id="userID" name="userID" required>
            <label for="gradeItem">Grade Item:</label>
            <input type="text" id="gradeItem" name="gradeItem" required>
            <label for="grade">Grade:</label>
            <input type="number" id="grade" name="grade" required>
            <label for="weight">Weight:</label>
            <input type="number" id="weight" name="weight" required>
            <button type="submit" name="addGrade" class="modal-button">Add</button>
        </form>
    </div>
</div>

<script>
    /* SORT COLUMNSL*/
    let sortOrder = [true, true, true, true, true, true]; // Track sort order for each column

    function sortTable(columnIndex) {
        const table = document.getElementById("gradesTable");
        const rows = Array.from(table.querySelectorAll("tbody tr"));
        const header = table.querySelectorAll("th")[columnIndex];

        // Toggle sort order
        sortOrder[columnIndex] = !sortOrder[columnIndex];

        // Sort rows based on the selected column
        rows.sort((a, b) => {
            const cellA = a.querySelectorAll("td")[columnIndex].innerText;
            const cellB = b.querySelectorAll("td")[columnIndex].innerText;

            if (cellA < cellB) {
                return sortOrder[columnIndex] ? -1 : 1;
            } else if (cellA > cellB) {
                return sortOrder[columnIndex] ? 1 : -1;
            } else {
                return 0;
            }
        });

        // Append sorted rows to the table
        const tbody = table.querySelector("tbody");
        rows.forEach(row => tbody.appendChild(row));

        // Update the sorting icon
        const icon = header.querySelector("span");
        icon.innerHTML = sortOrder[columnIndex] ? "&#x25B2;" : "&#x25BC;";


    }
</script>

</html>