<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"]) ||
    ($_SESSION["role"] ?? "") !== "admin") {
    http_response_code(403);
    exit("Access denied. Administrator access is required.");
}

if (time() - ($_SESSION["last_activity"] ?? time()) > 900) {
    $_SESSION = [];
    session_destroy();
    header("Location: login.php?error=1");
    exit;
}

$_SESSION["last_activity"] = time();

$logs = $conn->query(
    "SELECT a.id, a.user_id, a.action, a.details,
            a.ip_address, a.created_at,
            u.email
     FROM audit_logs a
     LEFT JOIN users u ON a.user_id = u.id
     ORDER BY a.created_at DESC
     LIMIT 100"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Logs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include "includes/menu.php"; ?>

    <main class="main-content">
        <header class="topbar">
            <div>
                <h1>Audit Logs</h1>
                <p>Recent recorded system actions</p>
            </div>
        </header>

        <section class="table-card">
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User</th>
                            <th>Action</th>
                            <th>Details</th>
                            <th>IP Address</th>
                            <th>Date and Time</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($logs->num_rows > 0): ?>
                        <?php while ($log = $logs->fetch_assoc()): ?>
                            <tr>
                                <td><?= (int)$log["id"] ?></td>
                                <td><?= htmlspecialchars($log["email"] ?? "Unknown", ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($log["action"], ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($log["details"] ?? "", ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($log["ip_address"] ?? "", ENT_QUOTES, "UTF-8") ?></td>
                                <td><?= htmlspecialchars($log["created_at"], ENT_QUOTES, "UTF-8") ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No audit records yet.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>