<?php
session_start();

// Check if user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['username'] !== 'admin') {
    // Redirect to login page if not logged in or not admin
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form data
    $exam_id = sanitize($link, $_POST['exam_id']);
    $exam_name = sanitize($link, $_POST['exam_name']);
    $exam_description = sanitize($link, $_POST['exam_description']);
    $course_name = sanitize($link, $_POST['course_name']);

    // Update exam details in the database
    $query = "UPDATE entrance_exams SET 
                name='$exam_name', 
                description='$exam_description', 
                course_name='$course_name' 
              WHERE id=$exam_id";

    if (mysqli_query($link, $query)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error updating exam: " . mysqli_error($link);
    }
}

// Fetch exam details for editing
if (isset($_GET['id'])) {
    $exam_id = sanitize($link, $_GET['id']);
    $query_exam = "SELECT * FROM entrance_exams WHERE id=$exam_id";
    $result_exam = mysqli_query($link, $query_exam);

    if (mysqli_num_rows($result_exam) == 1) {
        $row = mysqli_fetch_assoc($result_exam);
        $exam_name = $row['name'];
        $exam_description = $row['description'];
        $course_name = $row['course_name'];
    } else {
        echo "Exam not found.";
        exit();
    }
} else {
    echo "Exam ID not specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Entrance Exam</title>
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
        <h2>Edit Entrance Exam</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="exam_name" value="<?php echo $exam_name; ?>" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" name="exam_description" value="<?php echo $exam_description; ?>">
            </div>
            <div class="form-group">
                <label>Course</label>
                <select class="form-control" name="course_name">
                    <?php
                    $query_courses = "SELECT name FROM courses";
                    $result_courses = mysqli_query($link, $query_courses);
                    while ($course = mysqli_fetch_assoc($result_courses)) {
                        $selected = ($course['name'] == $course_name) ? "selected" : "";
                        echo "<option value='".$course['name']."' $selected>".$course['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Exam</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
