<?php
require_once 'config.php'; // Include the database configuration file

// Create connection
$conn = new mysqli("localhost", "root", "", "driveasy");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);// Output error message if connection fails
}
?>