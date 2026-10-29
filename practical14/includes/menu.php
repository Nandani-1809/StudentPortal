<?php
$role = $_SESSION["role"] ?? "";

if ($role === "admin") {
    $menuItems = [
        ["Dashboard", "admin_dashboard.php"],
        ["Audit Logs", "audit_logs.php"]
    ];
} else {
    $menuItems = [
        ["Dashboard", "student_dashboard.php"]
    ];
}
?>

<aside class="sidebar">
    <h2>Student Hub</h2>

    <p class="user-role">
        <?= htmlspecialchars(strtoupper($role), ENT_QUOTES, "UTF-8") ?>
    </p>

    <nav>
        <?php foreach ($menuItems as $item): ?>
            <a href="<?= htmlspecialchars($item[1], ENT_QUOTES, "UTF-8") ?>">
                <?= htmlspecialchars($item[0], ENT_QUOTES, "UTF-8") ?>
            </a>
        <?php endforeach; ?>

        <a href="logout.php">Logout</a>
    </nav>
</aside>