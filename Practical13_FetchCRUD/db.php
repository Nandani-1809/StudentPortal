<?php
// Practical 13: MySQL database connection using MySQLi.
// Import schema.sql in phpMyAdmin before opening the page.

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$username = 'root';
$password = ''; // Default XAMPP MySQL password is often blank.
$database = 'student_hub_portal';

$conn = new mysqli($host, $username, $password, $database);
$conn->set_charset('utf8mb4');
