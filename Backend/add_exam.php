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

// Check if the form data is set and not empty
if (isset($_POST['exam_name']) && isset($_POST['exam_description']) && isset($_POST['course_name'])) {
    // Sanitize and fetch form data
    $exam_name = sanitize($link, $_POST['exam_name']);
    $exam_description = sanitize($link, $_POST['exam_description']);
    $course_name = sanitize($link, $_POST['course_name']);

    // Insert exam data into the database
    $query = "INSERT INTO entrance_exams (name, description, course_name) VALUES ('$exam_name', '$exam_description', '$course_name')";

    if (mysqli_query($link, $query)) {
        echo "Exam added successfully.";
    } else {
        echo "Error: " . mysqli_error($link);
    }
} else {
    echo "Error: All fields are required.";
}

// Close the database connection
mysqli_close($link);
?>
