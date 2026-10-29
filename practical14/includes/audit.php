<?php
function logAction(
    mysqli $conn,
    ?int $userId,
    string $action,
    string $details = ""
): void {
    $ip = $_SERVER["REMOTE_ADDR"] ?? "unknown";

    $stmt = $conn->prepare(
        "INSERT INTO audit_logs
        (user_id, action, details, ip_address)
        VALUES (?, ?, ?, ?)"
    );

    $stmt->bind_param("isss", $userId, $action, $details, $ip);
    $stmt->execute();
}
?>