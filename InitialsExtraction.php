<?php

// Function to extract initials from a name
function extractInitials($name)
{
    $words = explode(" ", $name);
    $initials = "";

    foreach ($words as $word) {
        $initials .= strtoupper(substr($word, 0, 1));
    }

    return $initials;
}

?>
