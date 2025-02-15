<?php
session_start();

// Include database connection file
$link = mysqli_connect("localhost", "root", "", "test_db");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize input data
function sanitize($link, $data) {
    return mysqli_real_escape_string($link, htmlspecialchars(strip_tags($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $college_id = sanitize($link, $_POST['college_id']);

    $query = "DELETE FROM colleges WHERE id='$college_id'";

    if (mysqli_query($link, $query)) {
        echo "College deleted successfully.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
