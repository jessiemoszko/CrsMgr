<?php

// Function to extract initials from a name
function extractInitials($name)
{
    // Split the name into individual words
    $words = explode(" ", $name);
    $initials = "";
    // Iterate over each word to extract the first letter
    foreach ($words as $word) {
        // Append the first letter to the initials string
        $initials .= strtoupper(substr($word, 0, 1));
    }
    return $initials;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Karla:ital,wght@0,200..800;1,200..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="header.css">
    <title>Course Manager</title>
</head>

<body>
    <header class="header">
        <div class="header-text"><?php echo $pageTitle?></div>
        <div class="user" onclick="toggleDropdown()">
            <div class="initials"><?php $initials = extractInitials($name);
                                    echo $initials; ?></div>
            <div class="dropdown" id="dropdown">
                <a href="logout.php">Logout</a>
            </div>
        </div>
    </header>

    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown");
            dropdown.classList.toggle("show");
        }
    </script>

</body>