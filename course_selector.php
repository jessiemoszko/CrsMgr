<?php
require 'Database/DB.php';

// Check if course ID is provided and valid
if (isset($_GET['course_id']) && is_numeric($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Store the selected course ID in the session
    $_SESSION['selected_course_id'] = $course_id;

    // Fetch content for the selected course
    $sql = "SELECT * FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

} else {
    echo "<main>";
    echo "Invalid course ID provided.";
    echo "</main>";
}

// Check if a course is selected
if (!isset($_SESSION['selected_course_id']) || !is_numeric($_SESSION['selected_course_id'])) {
    // Display a message and stop further execution
    echo "<main>";
    echo "<h1>Please select a course</h1>";
    echo "</main>";
    exit; // Stop further execution
}

$course_id = $_SESSION['selected_course_id'];

// For title at top of page
$courseQuery = "SELECT * FROM courses WHERE `course_id` = $course_id";
$courseResult = mysqli_query($conn, $courseQuery);
if (!$courseResult) {
    die("Error fetching course information: " . mysqli_error($conn));
}
$course = mysqli_fetch_assoc($courseResult);
