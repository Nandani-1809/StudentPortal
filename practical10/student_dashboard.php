
<?php
require_once 'auth_check.php';

if ($_SESSION['role'] !== 'student') {
    http_response_code(403);
    exit("Unauthorized Access: Student role required.");
}

$name = htmlspecialchars(
    $_SESSION['first_name'] . ' ' . $_SESSION['last_name'],
    ENT_QUOTES,
    'UTF-8'
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="dashboard">
        <h1>Student Dashboard</h1>
        <p>Welcome, <?php echo $name; ?>!</p>
        <p>You are logged in as a student.</p>

        <ul>
            <li>View assignments and attendance</li>
            <li>Check examination results</li>
            <li>View college announcements</li>
        </ul>

        <a class="logout-link" href="logout.php">Logout</a>
    </main>
</body>
</html>
