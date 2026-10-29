<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"]) ||
    ($_SESSION["role"] ?? "") !== "student") {
    http_response_code(403);
    exit("Access denied. Student access is required.");
}

if (time() - ($_SESSION["last_activity"] ?? time()) > 900) {
    $_SESSION = [];
    session_destroy();
    header("Location: login.php?error=1");
    exit;
}

$_SESSION["last_activity"] = time();
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
    <?php include "includes/menu.php"; ?>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Student Dashboard</h1>
                <p>
                    Welcome,
                    <?= htmlspecialchars($_SESSION["first_name"], ENT_QUOTES, "UTF-8") ?>!
                </p>
            </div>
            <span class="role-badge">Student</span>
        </header>

        <section class="table-card">
            <h2>Welcome to Student Hub</h2>
            <p>You are logged in with the student role.</p>
            <p>Your menu is displayed according to your role.</p>
        </section>
    </main>
</body>
</html>