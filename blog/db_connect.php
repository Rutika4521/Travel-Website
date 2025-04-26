<?php
// Database connection settings
$servername = "localhost"; // Typically 'localhost'
$username = "root";        // Your MySQL username, default is 'root'
$password = "";            // Your MySQL password, default is empty for XAMPP
$dbname = "blog_posts";    // Name of your database

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
