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
    $course_name = sanitize($link, $_POST['course_name']);
    $exam_name = sanitize($link, $_POST['exam_name']);
    $college_name = sanitize($link, $_POST['college_name']);
    $college_department = sanitize($link, $_POST['college_department']);
    $college_rank = sanitize($link, $_POST['college_rank']);
    $college_state = sanitize($link, $_POST['college_state']);
    $college_website = sanitize($link, $_POST['college_website']);
    $college_category = sanitize($link, $_POST['college_category']);

    $query = "INSERT INTO colleges (course_name, exam_name, name, department, rank, state, website, category) 
              VALUES ('$course_name', '$exam_name', '$college_name', '$college_department', '$college_rank', '$college_state', '$college_website', '$college_category')";
    
    if (mysqli_query($link, $query)) {
        echo "College added successfully.";
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }

    mysqli_close($link);
}
?>
