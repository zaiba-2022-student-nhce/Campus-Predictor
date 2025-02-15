<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Include database connection file
$link = mysqli_connect("localhost", "root", "", "test_db");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize input data
function sanitize($link, $data) {
    return mysqli_real_escape_string($link, htmlspecialchars(strip_tags($data)));
}

// Sanitize and fetch form data
$course_name = sanitize($link, $_POST['course_name']);
$course_description = sanitize($link, $_POST['course_description']);

// Insert course data into the database
$query = "INSERT INTO courses (name, description) VALUES ('$course_name', '$course_description')";

if (mysqli_query($link, $query)) {
    echo "Course added successfully.";
} else {
    echo "Error: " . mysqli_error($link);
}

// Close the database connection
mysqli_close($link);
?>
