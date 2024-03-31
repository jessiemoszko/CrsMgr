<?php
    require 'session.php'; 
    $pageTitle='Assignments';
    include 'header.php';
    include 'sidebar.php';


    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Specify the directory where you want to save the uploaded file
        $upload_directory = "uploads/";

        // Check if file was uploaded without errors 
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
            $file_name     = $_FILES["file"]["name"];
            $file_tmp_name = $_FILES["file"]["tmp_name"];
            $file_type     = $_FILES["file"]["type"];
            $file_size     = $_FILES["file"]["size"];
            $file_error    = $_FILES["file"]["error"];

            // Construct the full path where you want to save the file
            $destination = $upload_directory . $file_name;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($file_tmp_name, $destination)) {
                echo "File uploaded successfully.<br>";
                echo "Uploaded File Name: " . $file_name . "<br>";
                echo "Type of File: " . $file_type . "<br>";
                echo "Size of File: " . $file_size . " bytes<br>";
            } else {
                echo "Error uploading file.<br>";
            }
        } else {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
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
<body >
    <div class="container">
        <table>
            <tr>
                <th>Assignment Name</th>
                <th>File</th>
                <th>Posted Date</th>
                <th>Due Date</th>
                <th>Upload</th>
            </tr>
            <tr>
                <td>Assign1</td>
                <td>File</td>
                <td>Feb 2</td>
                <td>April 7</td>
                <td>
                    <form method="post" enctype="multipart/form-data" id="f1">
                        <input type="file" name="file" />
                        <input type="submit" value="Upload File" name="submit">
                    </form>
                </td>

            </tr>
        </table>
    </div>
</body>
</main>

</html>


