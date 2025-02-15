<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Redirect to login page if not logged in or not admin
    header("Location: login.php");
    exit();
};


// Include database connection file
$link = mysqli_connect("localhost", "root", "", "test_db");
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

// Function to sanitize input data
function sanitize($link, $data) {
    return mysqli_real_escape_string($link, htmlspecialchars(strip_tags($data)));
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $course_id = sanitize($link, $_POST['course_id']);
    $course_name = sanitize($link, $_POST['course_name']);
    $course_description = sanitize($link, $_POST['course_description']);

    // Update course details in the database
    $query = "UPDATE courses SET 
                name='$course_name', 
                description='$course_description' 
              WHERE id=$course_id";

    if (mysqli_query($link, $query)) {
        header("Location:admin.php");
        exit();
    } else {
        echo "Error updating course: " . mysqli_error($link);
    }
}

// Fetch course details for editing
if (isset($_GET['id'])) {
    $course_id = sanitize($link, $_GET['id']);
    $query_course = "SELECT * FROM courses WHERE id=$course_id";
    $result_course = mysqli_query($link, $query_course);

    if (mysqli_num_rows($result_course) == 1) {
        $row = mysqli_fetch_assoc($result_course);
        $course_name = $row['name'];
        $course_description = $row['description'];
    } else {
        echo "Course not found.";
        exit();
    }
} else {
    echo "Course ID not specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Course</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="course_id" value="<?php echo $course_id; ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="course_name" value="<?php echo $course_name; ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="course_description" value="<?php echo $course_description; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update Course</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
