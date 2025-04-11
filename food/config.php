<?php
// config.php - Global Configuration File

// Database Credentials
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'food_waste_management');

// Site Settings
define('SITE_NAME', 'Food Waste Management');
define('ADMIN_EMAIL', 'admin@example.com');

// Establish Database Connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}
?>
