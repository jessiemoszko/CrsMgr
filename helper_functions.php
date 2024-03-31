<?php

$errors = array();
$success = array();

// show errors
function display_error($errors)
{
    if (!empty($errors)) {
        echo '<div class="error" id="notification" onclick="this.remove()">';
        foreach ($errors as $error) {
            echo $error . '<br>';
        }
        echo '</div>';
    }
}

// show success
function display_success($success)
{
    if (!empty($success)) {
        echo '<div class="success" id="notification" onclick="this.remove()">';
        foreach ($success as $success) {
            echo $success . '<br>';
        }
        echo '</div>';
    }
}

// return table array
function get_table_array($conn, $table)
{
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    return $result;
}

function get_records_where($conn, $table, $key, $value)
{
    $query = "SELECT * FROM $table WHERE $key='$value'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    return $result;
}

?>