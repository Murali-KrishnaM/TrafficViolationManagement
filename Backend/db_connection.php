<?php
$host = "localhost";  // Change if needed
$username = "root";   // Change if you have a different DB user
$password = "";       // Change if you set a password
$database = "traffic_violation_db"; // Replace with your actual database name

// Create a connection
$conn = new mysqli($host, $username, $password, $database);

// Check for errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
