<?php
require 'session.php';
$pageTitle = "Grades";
require 'header.php';
require 'sidebar.php';

// Ensure connection is established
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Query for grades
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

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_id'])) {
        // Handle deletion of grade item
        handleDeleteGrade($conn, $_POST['delete_id']);
    } elseif (isset($_POST['addGrade'])) {
        // Handle addition of new grade
        handleAddGrade($conn, $_POST);
    } elseif (isset($_POST['gradeItem'])) {
        // Handle updating an existing grade
        handleUpdateGrade($conn, $_POST);
    } else {
        echo "Invalid request.";
    }
}

// Functions to handle different actions
function handleDeleteGrade($conn, $delete_id)
{
    $delete_id = mysqli_real_escape_string($conn, $delete_id);
    $delete_sql = "DELETE FROM grades WHERE grade_item = '$delete_id'";
    if (mysqli_query($conn, $delete_sql)) {
        header("Refresh:0");
        exit;
    } else {
        echo "Error deleting grade: " . mysqli_error($conn);
    }
}

function handleAddGrade($conn, $data)
{
    // Extract and sanitize data
    $courseID = mysqli_real_escape_string($conn, $data['courseID']);
    $userID = mysqli_real_escape_string($conn, $data['userID']);
    $gradeItem = mysqli_real_escape_string($conn, $data['gradeItem']);
    $grade = mysqli_real_escape_string($conn, $data['grade']);
    $weight = mysqli_real_escape_string($conn, $data['weight']);

    // Insert query
    $insertQuery = "INSERT INTO grades (course_id, userID, grade_item, grade, weight) VALUES ('$courseID', '$userID', '$gradeItem', '$grade', '$weight')";
    if (mysqli_query($conn, $insertQuery)) {
        // Redirect after successful insertion
        header("Refresh:0");
        exit;
    } else {
        echo "Error inserting new grade: " . mysqli_error($conn);
    }
}

function handleUpdateGrade($conn, $data)
{
    // Extract and sanitize data
    $gradeItem = mysqli_real_escape_string($conn, $data['gradeItem']);
    $grade = mysqli_real_escape_string($conn, $data['grade']);
    $userID = mysqli_real_escape_string($conn, $data['userID']);
    $courseID = mysqli_real_escape_string($conn, $data['courseID']);
    $weight = mysqli_real_escape_string($conn, $data['weight']);

    // Update query
    $update_sql = "UPDATE grades SET grade = '$grade', userID = '$userID', course_id = (SELECT course_id FROM courses WHERE course_code = '$courseID'), weight = '$weight' WHERE grade_item = '$gradeItem'";
    if (mysqli_query($conn, $update_sql)) {
        // Redirect after successful update
        header('Refresh:0');
        exit;
    } else {
        echo "Error updating grades: " . mysqli_error($conn);
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
        document.addEventListener('DOMContentLoaded', function() {
            const addGradeModal = document.getElementById('addGradeModal');
            const openAddGradeModalBtn = document.getElementById('openAddGradeModal');

            if (openAddGradeModalBtn && addGradeModal) {
                openAddGradeModalBtn.onclick = function() {
                    addGradeModal.style.display = 'block';
                };
            }
            // Event listener for close button on Add Grade modal
            const addGradeModalCloseBtn = addGradeModal.querySelector('.close');
            if (addGradeModalCloseBtn) {
                addGradeModalCloseBtn.addEventListener('click', function() {
                    addGradeModal.style.display = 'none';
                });
            }

            // Event listener for close button on Edit Grade modal
            const editGradeModalCloseBtn = editGradeModal.querySelector('.close');
            if (editGradeModalCloseBtn) {
                editGradeModalCloseBtn.addEventListener('click', function() {
                    editGradeModal.style.display = 'none';
                });
            }
        });

        // Function to open Edit Grade modal
        function openEditModal(gradeItem, grade, userID, courseID, weight) {
            const editGradeModal = document.getElementById('editGradeModal');
            if (editGradeModal) {
                // Display the modal
                editGradeModal.style.display = 'block';

                // Populate the form fields
                document.getElementById('gradeItem').value = gradeItem;
                document.getElementById('grade').value = grade;
                document.getElementById('userID').value = userID;
                document.getElementById('courseID').value = courseID;
                document.getElementById('weight').value = weight;
            }
        }
    </script>
</head>

<body>
    <main>
        <div class="container">
            <table id="gradesTable">
                <thead>

                    <!-- Display table headings -->

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
                <button class="new-assign" id="openAddGradeModal">Add Grade</button>
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
                <label for="courseID" class="form-label">Course Code:</label>
                <input type="text" id="courseID" name="courseID" required>
                <label for="gradeItem" class="form-label">Grade Item:</label>
                <input type="text" id="gradeItem" name="gradeItem">
                <label for="grade" class="form-label">Grade:</label>
                <input type="number" id="grade" name="grade" required>
                <label for="weight" class="form-label">Weight:</label>
                
                <input type="number" id="weight" name="weight" required>

                <div>
                <input type="submit" class="modal-button"></input>
                </div>
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
            <label for="courseID" class="form-label">Course Code:</label>
            <input type="text" id="courseID" name="courseID" required>
            <label for="userID" class="form-label">User ID:</label>
            <input type="text" id="userID" name="userID" required>
            <label for="gradeItem" class="form-label">Grade Item:</label>
            <input type="text" id="gradeItem" name="gradeItem" required>
            <label for="grade" class="form-label">Grade:</label>
            <input type="number" id="grade" name="grade" required>
            <label for="weight" class="form-label">Weight:</label>
           
            <input type="number" id="weight" name="weight" required>
            <div>
            <input type="submit" name="addGrade" class="modal-button"></input>
            </div>
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