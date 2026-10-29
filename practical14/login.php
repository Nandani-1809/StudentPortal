<?php
session_start();

if (isset($_SESSION["user_id"])) {
    if (($_SESSION["role"] ?? "") === "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: student_dashboard.php");
    }
    exit;
}

$error = isset($_GET["error"]);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practical 14 | Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <h1>Student Hub</h1>
        <p>Admin Dashboard and Role-Based Access</p>

        <?php if ($error): ?>
            <p class="error">Invalid email or password.</p>
        <?php endif; ?>

        <form action="authenticate.php" method="POST">
            <label for="email">Email address</label>
            <input id="email" type="email" name="email" required>

            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>

            <button type="submit">Sign In</button>
        </form>
    </div>
</body>
</html>