<?php
session_start();

require_once "db.php";
require_once "includes/audit.php";

if (!isset($_SESSION["user_id"]) ||
    ($_SESSION["role"] ?? "") !== "admin") {
    http_response_code(403);
    exit("Access denied. Administrator access is required.");
}

/* Session inactivity timeout: 15 minutes */
if (time() - ($_SESSION["last_activity"] ?? time()) > 900) {
    $userId = (int)$_SESSION["user_id"];
    logAction($conn, $userId, "SESSION_TIMEOUT", "Session expired");
    $_SESSION = [];
    session_destroy();
    header("Location: login.php?error=1");
    exit;
}
$_SESSION["last_activity"] = time();

$totalUsers = (int)$conn->query(
    "SELECT COUNT(*) AS total FROM users"
)->fetch_assoc()["total"];

$totalStudents = (int)$conn->query(
    "SELECT COUNT(*) AS total FROM students"
)->fetch_assoc()["total"];

$totalEvents = (int)$conn->query(
    "SELECT COUNT(*) AS total FROM events"
)->fetch_assoc()["total"];

$totalRegistrations = (int)$conn->query(
    "SELECT COUNT(*) AS total FROM registrations"
)->fetch_assoc()["total"];

$latest = $conn->query(
    "SELECT s.first_name, s.last_name, s.enrollment,
            e.name AS event_name, r.registration_date
     FROM registrations r
     JOIN students s ON r.student_id = s.id
     JOIN events e ON r.event_id = e.id
     ORDER BY r.registration_date DESC
     LIMIT 5"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Practical 14</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "includes/menu.php"; ?>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Admin Dashboard</h1>
                <p>Welcome, <?= htmlspecialchars($_SESSION["first_name"], ENT_QUOTES, "UTF-8") ?>!</p>
            </div>
            <span class="role-badge">Administrator</span>
        </header>

        <section class="stats-grid">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p><?= $totalUsers ?></p>
            </div>

            <div class="stat-card">
                <h3>Total Students</h3>
                <p><?= $totalStudents ?></p>
            </div>

            <div class="stat-card">
                <h3>Total Events</h3>
                <p><?= $totalEvents ?></p>
            </div>

            <div class="stat-card">
                <h3>Registrations</h3>
                <p><?= $totalRegistrations ?></p>
            </div>
        </section>

        <section class="table-card">
            <h2>Latest Event Registrations</h2>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Enrollment</th>
                            <th>Event</th>
                            <th>Registration Date</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($latest->num_rows > 0): ?>
                        <?php while ($row = $latest->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?= htmlspecialchars(
                                        $row["first_name"] . " " . $row["last_name"],
                                        ENT_QUOTES,
                                        "UTF-8"
                                    ) ?>
                                </td>
                                <td><?= htmlspecialchars($row["enrollment"] ?? "", ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($row["event_name"], ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($row["registration_date"], ENT_QUOTES, "UTF-8") ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No registrations found yet.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <p><a href="audit_logs.php">View audit logs →</a></p>
        </section>
    </main>
</body>
</html>