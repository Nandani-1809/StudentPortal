
<?php
session_set_cookie_params([
    'httponly' => true,
    'secure' => false, // Local XAMPP uses HTTP; use true on HTTPS.
    'samesite' => 'Lax'
]);

ini_set('session.use_strict_mode', '1');
session_start();

require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
    header("Location: login.php?error=1");
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, first_name, last_name, email, password_hash, role
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

$stmt->close();
$conn->close();

if (!$user || !password_verify($password, $user['password_hash'])) {
    header("Location: login.php?error=1");
    exit;
}

if (!in_array($user['role'], ['student', 'admin'], true)) {
    header("Location: login.php?error=1");
    exit;
}

// Replace the old session ID after successful authentication.
session_regenerate_id(true);

$_SESSION['user_id'] = $user['id'];
$_SESSION['first_name'] = $user['first_name'];
$_SESSION['last_name'] = $user['last_name'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];
$_SESSION['last_activity'] = time();

header("Location: dashboard.php");
exit;
?>
