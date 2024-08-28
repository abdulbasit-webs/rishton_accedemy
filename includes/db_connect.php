<?php
// Database connection settings
$servername = "localhost"; // The server you are connecting to (usually localhost for local development)
$username = "root"; // The default username for XAMPP is root
$password = ""; // The default password for XAMPP is blank (no password)
$dbname = "rishton"; // Replace this with your actual database name

// Create the connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Connection successful
?>
