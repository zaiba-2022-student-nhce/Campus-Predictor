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
    $college_id = sanitize($link, $_POST['college_id']);
    $college_name = sanitize($link, $_POST['college_name']);
    $college_website = sanitize($link, $_POST['college_website']);
    $college_state = sanitize($link, $_POST['college_state']);
    $college_rank = sanitize($link, $_POST['college_rank']);
    $college_department = sanitize($link, $_POST['college_department']);
    $college_category = sanitize($link, $_POST['college_category']);
    $course_name = sanitize($link, $_POST['course_name']);
    $exam_name = sanitize($link, $_POST['exam_name']);

    // Update college details in the database
    $query = "UPDATE colleges SET 
                name='$college_name', 
                website='$college_website', 
                state='$college_state', 
                rank='$college_rank', 
                department='$college_department', 
                category='$college_category', 
                course_name='$course_name', 
                exam_name='$exam_name' 
              WHERE id=$college_id";

    if (mysqli_query($link, $query)) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Error updating college: " . mysqli_error($link);
    }
}

// Fetch college details for editing
if (isset($_GET['id'])) {
    $college_id = sanitize($link, $_GET['id']);
    $query_college = "SELECT * FROM colleges WHERE id=$college_id";
    $result_college = mysqli_query($link, $query_college);

    if (mysqli_num_rows($result_college) == 1) {
        $row = mysqli_fetch_assoc($result_college);
        $college_name = $row['name'];
        $college_website = $row['website'];
        $college_state = $row['state'];
        $college_rank = $row['rank'];
        $college_department = $row['department'];
        $college_category = $row['category'];
        $course_name = $row['course_name'];
        $exam_name = $row['exam_name'];
    } else {
        echo "College not found.";
        exit();
    }
} else {
    echo "College ID not specified.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit College</title>
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
        <h2>Edit College</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="college_id" value="<?php echo $college_id; ?>">
            <div class="form-group">
                <label>Name</label>
                <input type="text" class="form-control" name="college_name" value="<?php echo $college_name; ?>" required>
            </div>
            <div class="form-group">
                <label>Website</label>
                <input type="text" class="form-control" name="college_website" value="<?php echo $college_website; ?>">
            </div>
            <div class="form-group">
                <label>State</label>
                <input type="text" class="form-control" name="college_state" value="<?php echo $college_state; ?>">
            </div>
            <div class="form-group">
                <label>Rank</label>
                <input type="text" class="form-control" name="college_rank" value="<?php echo $college_rank; ?>">
            </div>
            <div class="form-group">
                <label>Department</label>
                <input type="text" class="form-control" name="college_department" value="<?php echo $college_department; ?>">
            </div>
            <div class="form-group">
                <label>Category</label>
                <input type="text" class="form-control" name="college_category" value="<?php echo $college_category; ?>">
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
            <div class="form-group">
                <label>Entrance Exam</label>
                <select class="form-control" name="exam_name">
                    <?php
                    $query_exams = "SELECT name FROM entrance_exams";
                    $result_exams = mysqli_query($link, $query_exams);
                    while ($exam = mysqli_fetch_assoc($result_exams)) {
                        $selected = ($exam['name'] == $exam_name) ? "selected" : "";
                        echo "<option value='".$exam['name']."' $selected>".$exam['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update College</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
