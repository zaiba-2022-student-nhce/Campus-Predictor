<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['course_id'])) {
    // Include database connection file
    $link = mysqli_connect("localhost", "root", "", "test_db");
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Function to sanitize input data
    function sanitize($link, $data) {
        return mysqli_real_escape_string($link, htmlspecialchars(strip_tags($data)));
    }

    // Sanitize the input
    $course_id = sanitize($link, $_POST['course_id']);

    // Fetch the course name based on course_id
    $query_course_name = "SELECT name FROM courses WHERE id = '$course_id'";
    $result_course_name = mysqli_query($link, $query_course_name);
    if ($result_course_name && mysqli_num_rows($result_course_name) > 0) {
        $row = mysqli_fetch_assoc($result_course_name);
        $course_name = sanitize($link, $row['name']);

        // Delete the rows in the colleges table that reference this course
        $query_delete_colleges = "DELETE FROM colleges WHERE course_name = '$course_name'";
        mysqli_query($link, $query_delete_colleges);

        // Perform delete operation on courses table
        $query_delete_course = "DELETE FROM courses WHERE id = '$course_id'";
        $result_delete_course = mysqli_query($link, $query_delete_course);

        if ($result_delete_course) {
            // Successful deletion
            header("Location: admin.php"); // Redirect back to admin panel
            exit();
        } else {
            // Error handling
            echo "Error deleting course: " . mysqli_error($link);
        }
    } else {
        echo "Course not found.";
    }

    mysqli_close($link);
} else {
    // Invalid request handling
    echo "Invalid request.";
}
?>
