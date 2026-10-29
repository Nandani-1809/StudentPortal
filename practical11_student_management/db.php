<?php
// MySQLi connection for Practical 11.
// Import student_management.sql in phpMyAdmin before opening the website.
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = 'localhost';
$username = 'root';
$password = '';
$database = 'practical11';

try {
    $conn = new mysqli($host, $username, $password, $database);
    $conn->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit('Database connection failed. Check db.php and import student_management.sql in phpMyAdmin.');
}
