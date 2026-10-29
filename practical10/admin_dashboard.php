
<?php
require_once 'auth_check.php';

if ($_SESSION['role'] !== 'admin') {
    http_response_code(403);
    exit("Unauthorized Access: Admin role required.");
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
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main class="dashboard">
        <h1>Admin Dashboard</h1>
        <p>Welcome, <?php echo $name; ?>!</p>
        <p>You are logged in as an administrator.</p>

        <ul>
            <li>View registered users</li>
            <li>Review student information</li>
            <li>Manage portal announcements</li>
        </ul>

        <a class="logout-link" href="logout.php">Logout</a>
    </main>
</body>
</html>
