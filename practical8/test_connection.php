<?php
$host = "localhost";
$dbname = "practical8";
$username = "root";
$password = "";
try {
    $conn = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<h2>Database Connection Successful</h2>";
    $stmt = $conn->query("SELECT * FROM students LIMIT 1");
    $student = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($student) {
        echo "<h3>Student Found:</h3>";
        echo "<pre>";
        print_r($student);
        echo "</pre>";
    } else {
        echo "No student found. Please insert a student record.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
