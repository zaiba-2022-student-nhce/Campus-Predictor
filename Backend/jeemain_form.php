<?php
// Include database connection script
include_once 'db_connection.php';

// Start session if not already started
session_start();

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Define variables and initialize with empty values
$jee_rank = $category = "";
$jee_rank_err = "";
$colleges = []; // Array to store fetched colleges
$colleges_found = false; // Flag to track if colleges are found

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitJEE'])) {

    // Validate JEE Main rank
    if (empty(trim($_POST["jee_rank"]))) {
        $jee_rank_err = "Please enter your JEE Main rank.";
    } else {
        $jee_rank = trim($_POST["jee_rank"]);
    }

    // Get category
    if (!empty($_POST["category"])) {
        $category = trim($_POST["category"]);
    }

    // Check input errors before querying the database
    if (empty($jee_rank_err)) {

        // Include database connection file
        $link = mysqli_connect("localhost", "root", "", "test_db");

        // Check connection
        if ($link === false) {
            die("ERROR: Could not connect. " . mysqli_connect_error());
        }

        // Prepare a select statement with category and rank filter
        $sql = "SELECT name, department, rank, state, website, category 
                FROM colleges 
                WHERE exam_name = 'JEE Mains' 
                AND rank >= ? 
                AND category = ? 
                ORDER BY rank ASC";

        if ($stmt = mysqli_prepare($link, $sql)) {

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "is", $param_jee_rank, $param_category);

            // Set parameters
            $param_jee_rank = $jee_rank;
            $param_category = $category;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                $result = mysqli_stmt_get_result($stmt);

                // Check if there are any results
                if (mysqli_num_rows($result) > 0) {
                    // Fetching all rows into array for later use
                    while ($row = mysqli_fetch_assoc($result)) {
                        $colleges[] = $row;
                    }
                    $colleges_found = true; // Set flag to true since colleges are found
                } else {
                    // No need to echo here
                }
            } else {
                echo "ERROR: Could not execute query: $sql. " . mysqli_error($link);
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        // Close connection
        mysqli_close($link);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Home.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="jagran_logo1.jpg">
    <link href="https://fonts.googleapis.com/css?family=Quicksand&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>JEE Main 2025 College Predictor</title>
        
     <style>
       /* Your existing CSS styles */
/*body {
    background-image: url('b6.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-attachment: fixed;
    background-position: center;
}*/

.section-title {
    text-align: center;
    background-color: #003366; /* Background color for section titles */
    color: white; /* Text color for section titles */
    padding: 7px; /* Padding around the text */
    border-radius: 10px; /* Rounded corners */
    margin-bottom: 20px; /* Spacing at the bottom */
}

.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: rgba(248, 249, 250, 0.9); /* Semi-transparent white background */
    border-radius: 40px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border: 2px solid #003366;
    transition: border-color 0.3s;
    text-align: center;
}

.form-container input[type="text"],
.form-container select {
    width: 80%;
    padding: 10px;
    margin: 10px 0;
    border: 2px solid #ddd;
    border-radius: 50px;
    text-align: center;
    box-sizing: border-box;
}

.form-container input[type="text"]:focus,
.form-container select:focus {
    outline: none;
    border-color: #007bff;
}

.form-container input[type="submit"] {
    width: 50%;
    padding: 10px;
    margin: 10px 0;
    box-sizing: border-box;
    background-color: #003366;
    color: white;
    border: none;
    border-radius: 50px;
    cursor: pointer;
}

.form-container input[type="submit"]:hover {
    background-color: #0056b3;
}

.table-container {
    max-width: 800px; /* Adjust max-width as needed */
    margin: 20px auto; /* Center align and add margin */
    padding: 20px;
    background-color: #f8f9fa; /* Plain shade background color */
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Light shadow for depth */
    overflow-x: auto; /* Enable horizontal scroll if needed */
}

.table-container table {
    width: 100%;
    border-collapse: collapse;
    background-color: transparent; /* Transparent background for the table */
}

.table-container table thead {
    background-color: #003366; /* Blue background for table header */
    color: #003366; /* Text color for table header */
}

.table-container table th,
.table-container table td {
    padding: 10px;
    text-align: center;
    border: 1px solid #ddd; /* Light gray border for table cells */
}

.table-container table tbody tr:nth-child(even) {
    background-color: #f0f0f0; /* Alternate row background color */
}

.table-container table tbody tr:hover {
    background-color: #e9ecef; /* Hover background color */
}

    </style>
</head>
<body style="background-image:url(b6.jpg)">
<nav class="navbar sticky-top navbar-expand-sm navbar-light" style="background-color:#003366;">
    <a class="navbar-brand" href="login.php">
        <h3 style="color:white;"> <i class="fa fa-graduation-cap" aria-hidden="true"></i>CampusPredictor</h3>
    </a>
    <!-- Links -->
    <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="home.php" style="color: white;">
                    Home <i class="fa fa-home" aria-hidden="true" style="font-size: 24px;"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="practice.php" style="color:white;">About Us <i class="fa fa-info-circle" aria-hidden="true" style="font-size: 20px;" ></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php" style="color: white;">Not <?php if(isset($_SESSION['username'])) { echo htmlspecialchars($_SESSION['username']); } ?>? Logout <i class="fa fa-sign-out" aria-hidden="true" style="font-size: 20px;" ></i></a>
            </li>
        </ul>
</nav>

<div class="background">
    <div  class="section-title">
        <h4>JEE Main 2025 College Predictor <i class="fa fa-flask" aria-hidden="true"></i></h4>
    </div>
    <div class="form-container">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input class="ip" type="text" name="jee_rank" placeholder="JEE Main Ranking" value="<?php echo htmlspecialchars($jee_rank); ?>" required>
            <span class="help-block"><?php echo $jee_rank_err; ?></span>
            
            <select name="category">
                <option value="">Select Category</option>
                <option value="General">General</option>
                <option value="ST">ST</option>
                <option value="SC">SC</option>
                <option value="OBC">OBC</option>
            </select>
            <br><br>
            <input class="button" type="submit" name="submitJEE" value="SUBMIT">
        </form>
    </div>
</div>

<?php
// Displaying table of colleges based on JEE Main rank and category if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submitJEE'])) {
    if ($colleges_found) {
        echo '<div class="table-container">';
        echo '<table>';
        echo '<thead><tr><th>College Name</th><th>Department</th><th>Rank</th><th>State</th><th>Website</th><th>Category</th></tr></thead>';
        echo '<tbody>';
        foreach ($colleges as $college) {
            echo '<tr>';
            echo '<td>' . htmlspecialchars($college['name']) . '</td>';
            echo '<td>' . htmlspecialchars($college['department']) . '</td>';
            echo '<td>' . htmlspecialchars($college['rank']) . '</td>';
            echo '<td>' . htmlspecialchars($college['state']) . '</td>';
            echo '<td><a href="' . htmlspecialchars($college['website']) . '">' . htmlspecialchars($college['website']) . '</a></td>';
            echo '<td>' . htmlspecialchars($college['category']) . '</td>';
            echo '</tr>';
        }
        echo '</tbody></table></div>';
    } else {
        echo '<p style="text-align:center">No colleges found matching the JEE Main rank and category criteria.</p>';
    }
}
?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965
