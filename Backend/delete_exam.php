<?php
session_start();

if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['exam_id'])) {
    $exam_id = $_POST['exam_id'];

    // Include database connection file
    $link = mysqli_connect("localhost", "root", "", "test_db");
    if (!$link) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize the input
    $exam_id = mysqli_real_escape_string($link, $exam_id);

    // Perform delete operation
    $query_delete_exam = "DELETE FROM entrance_exams WHERE id = '$exam_id'";
    $result_delete_exam = mysqli_query($link, $query_delete_exam);

    if ($result_delete_exam) {
        // Successful deletion
        header("Location: admin.php"); // Redirect back to admin panel
        exit();
    } else {
        // Error handling
        echo "Error deleting exam: " . mysqli_error($link);
    }

    mysqli_close($link);
} else {
    // Invalid request handling
    echo "Invalid request.";
}
?>
