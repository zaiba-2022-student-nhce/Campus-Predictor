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

// Fetch entrance exams
$query_exams = "SELECT * FROM entrance_exams";
$result_exams = mysqli_query($link, $query_exams);

// Fetch colleges with associated courses and entrance exams
$query_colleges = "SELECT colleges.id AS college_id, colleges.name AS college_name, colleges.website, colleges.state, colleges.rank, 
                   colleges.department,colleges.category, courses.name AS course_name, entrance_exams.name AS exam_name 
                   FROM colleges 
                   LEFT JOIN courses ON colleges.course_name = courses.name 
                   LEFT JOIN entrance_exams ON colleges.exam_name = entrance_exams.name";
$result_colleges = mysqli_query($link, $query_colleges);

// Fetch courses
$query_courses = "SELECT * FROM courses";
$result_courses = mysqli_query($link, $query_courses);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .card {
            margin-bottom: 20px;
        }
        .card-header {
            background-color: #007bff;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .card-body {
            min-height: 150px;
        }
        .table {
            margin-top: 10px;
        }
        .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
            color: #495057;
            background-color: #fff;
            border-color: #dee2e6 #dee2e6 #fff;
        }
        .nav-tabs .nav-link {
            border: 1px solid #dee2e6;
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0.25rem;
        }
        .profile-logo {
            width: 50px; /* Adjust size as needed */
            height: 50px; /* Adjust size as needed */
            border-radius: 50%; /* Makes it round */
            margin-right: 10px;
        }
        .admin-username {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function showSection(sectionId) {
            var sections = document.getElementsByClassName('section');
            for (var i = 0; i < sections.length; i++) {
                sections[i].style.display = 'none';
            }
            document.getElementById(sectionId).style.display = 'block';
        }
    </script>
</head>
<body>
   
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Admin Profile and Logo -->
                <div class="card mt-4">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <img src="loginicon.png" alt="Profile Logo" class="profile-logo">
                            <div>
                                <h5 class="mb-0">Admin Profile</h5>
                                <span class="badge badge-primary">Username: admin</span>
                            </div>
                        </div>
                        <a href="logout.php" class="btn btn-danger">Logout</a>
                    </div>
                </div>
            </div>
        </div>

        <ul class="nav nav-tabs mt-4">
            <li class="nav-item">
                <a class="nav-link active" href="#" onclick="showSection('courses-section')">Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showSection('exams-section')">Entrance Exams</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" onclick="showSection('colleges-section')">Colleges</a>
            </li>
        </ul>

        <!-- Courses Section -->
        <div id="courses-section" class="section" style="display: block;">
            <div class="card mt-4">
                <div class="card-header">
                    Courses
                </div>
                <div class="card-body">
                    <!-- Add Course Form -->
                    <form action="add_course.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="course_name" placeholder="Course Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="course_description" placeholder="Description">
                        </div>
                        <button type="submit" class="btn btn-primary">Add Course</button>
                    </form>
                    <!-- Courses Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result_courses)) : ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['description']; ?></td>
                                        <td>
                                            <a href="edit_course_form.php?id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                                            <form action="delete_course.php" method="post" style="display: inline-block;">
                                                <input type="hidden" name="course_id" value="<?= $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Entrance Exams Section -->
        <div id="exams-section" class="section" style="display: none;">
            <div class="card mt-4">
                <div class="card-header">
                    Entrance Exams
                </div>
                <div class="card-body">
                    <!-- Add Exam Form -->
                    <form action="add_exam.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="exam_name" placeholder="Exam Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="exam_description" placeholder="Description">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="course_name">
                                <?php
                                $query_courses_dropdown = "SELECT name FROM courses";
                                $result_courses_dropdown = mysqli_query($link, $query_courses_dropdown);
                                while ($course = mysqli_fetch_assoc($result_courses_dropdown)) {
                                    echo "<option value='".$course['name']."'>".$course['name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Exam</button>
                    </form>
                    <!-- Exams Table -->
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result_exams)) : ?>
                                    <tr>
                                        <td><?= $row['id']; ?></td>
                                        <td><?= $row['course_name']; ?></td>
                                        <td><?= $row['name']; ?></td>
                                        <td><?= $row['description']; ?></td>
                                        <td>
                                            <a href="edit_exam_form.php?id=<?= $row['id']; ?>" class="btn btn-primary">Edit</a>
                                            <form action="delete_exam.php" method="post" style="display: inline-block;">
                                                <input type="hidden" name="exam_id" value="<?= $row['id']; ?>">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this exam?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Colleges Section -->
        <div id="colleges-section" class="section" style="display: none;">
            <div class="card mt-4">
                <div class="card-header">
                    Colleges
                </div>
                <div class="card-body">
                    <!-- Add College Form -->
                    <form action="add_college.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="college_name" placeholder="College Name" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="college_website" placeholder="Website">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="college_state" placeholder="State">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="college_rank" placeholder="Rank">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="college_department" placeholder="Department">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="college_category" placeholder="Category">
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="course_name">
                                <?php
                                $query_courses_dropdown = "SELECT name FROM courses";
                                $result_courses_dropdown = mysqli_query($link, $query_courses_dropdown);
                                while ($course = mysqli_fetch_assoc($result_courses_dropdown)) {
                                    echo "<option value='".$course['name']."'>".$course['name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" name="exam_name">
                                <?php
                                $query_exams_dropdown = "SELECT name FROM entrance_exams";
                                $result_exams_dropdown = mysqli_query($link, $query_exams_dropdown);
                                while ($exam = mysqli_fetch_assoc($result_exams_dropdown)) {
                                    echo "<option value='".$exam['name']."'>".$exam['name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add College</button>
                    </form>
                    <!-- Colleges Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Website</th>
                                    <th>State</th>
                                    <th>Rank</th>
                                    <th>Department</th>
                                    <th>Category</th>
                                    <th>Course</th>
                                    <th>Entrance Exam</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = mysqli_fetch_assoc($result_colleges)) : ?>
                                    <tr>
                                        <td><?= $row['college_id']; ?></td>
                                        <td><?= $row['college_name']; ?></td>
                                        <td><?= $row['website']; ?></td>
                                        <td><?= $row['state']; ?></td>
                                        <td><?= $row['rank']; ?></td>
                                        <td><?= $row['department']; ?></td>
                                        <td><?= $row['category']; ?></td>
                                        <td><?= $row['course_name']; ?></td>
                                        <td><?= $row['exam_name']; ?></td>
                                        <td>
                                            <a href="edit_college_form.php?id=<?= $row['college_id']; ?>" class="btn btn-primary">Edit</a>
                                            <form action="delete_college.php" method="post" style="display: inline-block;">
                                                <input type="hidden" name="college_id" value="<?= $row['college_id']; ?>">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this college?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
         
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
