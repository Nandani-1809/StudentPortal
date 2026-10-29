<?php
require_once "db.php";

$message = "";

$result = $conn->query(
    "SELECT COUNT(*) AS total FROM users WHERE role = 'admin'"
);
$adminExists = (int)$result->fetch_assoc()["total"] > 0;

if ($_SERVER["REQUEST_METHOD"] === "POST" && !$adminExists) {
    $firstName = trim($_POST["first_name"] ?? "");
    $lastName  = trim($_POST["last_name"] ?? "");
    $email     = trim($_POST["email"] ?? "");
    $password  = $_POST["password"] ?? "";

    if ($firstName === "" || $lastName === "") {
        $message = "Enter your first and last name.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Enter a valid email address.";
    } elseif (strlen($password) < 8) {
        $message = "Password must contain at least 8 characters.";
    } else {
        $stmt = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );
        $stmt->bind_param("s", $email);
        $stmt->execute();

        if ($stmt->get_result()->num_rows > 0) {
            $message = "This email already exists. Use another email.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $role = "admin";

            $stmt = $conn->prepare(
                "INSERT INTO users
                (first_name, last_name, email, password_hash, role)
                VALUES (?, ?, ?, ?, ?)"
            );
            $stmt->bind_param(
                "sssss",
                $firstName,
                $lastName,
                $email,
                $hash,
                $role
            );
            $stmt->execute();

            $message = "Administrator created successfully. Now log in.";
            $adminExists = true;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-page">
    <div class="login-card">
        <h1>Create Administrator</h1>

        <p class="message">
            <?= htmlspecialchars($message, ENT_QUOTES, "UTF-8") ?>
        </p>

        <?php if ($adminExists): ?>
            <p>An administrator account already exists.</p>
            <a class="btn" href="login.php">Go to Login</a>
        <?php else: ?>
            <form method="POST">
                <label>First name</label>
                <input type="text" name="first_name" required>

                <label>Last name</label>
                <input type="text" name="last_name" required>

                <label>Email</label>
                <input type="email" name="email" required>

                <label>Password (minimum 8 characters)</label>
                <input type="password" name="password"
                       minlength="8" required>

                <button type="submit">Create Admin</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>