<?php
// Database connection script
$host = "localhost";
$username = "root";
$password = "";
$database = "test_db";

$link = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
