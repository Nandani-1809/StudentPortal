<?php
session_start();

require_once "db.php";
require_once "includes/audit.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$stmt = $conn->prepare(
    "SELECT id, first_name, last_name, email,
            password_hash, role
     FROM users
     WHERE email = ?"
);
$stmt->bind_param("s", $email);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user || !password_verify($password, $user["password_hash"])) {
    logAction($conn, null, "LOGIN_FAILED", "Failed login attempt");
    header("Location: login.php?error=1");
    exit;
}

session_regenerate_id(true);

$_SESSION["user_id"] = (int)$user["id"];
$_SESSION["first_name"] = $user["first_name"];
$_SESSION["last_name"] = $user["last_name"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];
$_SESSION["last_activity"] = time();

logAction(
    $conn,
    (int)$user["id"],
    "LOGIN_SUCCESS",
    "User logged in"
);

if ($user["role"] === "admin") {
    header("Location: admin_dashboard.php");
} else {
    header("Location: student_dashboard.php");
}
exit;
?>