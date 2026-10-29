
<?php
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $enrollment = trim($_POST['enrollment'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (
        $first_name === '' ||
        $last_name === '' ||
        $enrollment === '' ||
        $email === '' ||
        $password === ''
    ) {
        $message = 'Please fill in all fields.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = 'Please enter a valid email address.';
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users
            (first_name, last_name, enrollment, email, password_hash, role)
            VALUES (?, ?, ?, ?, ?, 'student')";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "sssss",
            $first_name,
            $last_name,
            $enrollment,
            $email,
            $password_hash
        );

        if ($stmt->execute()) {
            $message = 'Student registered successfully! You can now log in.';
        } else {
            $message = 'Registration failed. The email or enrollment may already exist.';
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px 15px;
        }
        .container {
            max-width: 420px;
            margin: 30px auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 15px #0001;
        }
        h2 { text-align: center; color: #2563eb; }
        input {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            margin: 7px 0 14px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 5px;
            background: #2563eb;
            color: white;
            cursor: pointer;
        }
        .message { margin-bottom: 15px; }
        a { display: block; text-align: center; margin-top: 15px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Student Registration</h2>

        <?php if ($message !== ''): ?>
            <p class="message">
                <?= htmlspecialchars($message) ?>
            </p>
        <?php endif; ?>

        <form method="POST">
            <label>First Name</label>
            <input type="text" name="first_name" required>

            <label>Last Name</label>
            <input type="text" name="last_name" required>

            <label>Enrollment Number</label>
            <input type="text" name="enrollment" required>

            <label>Email</label>
            <input type="email" name="email" required>

            <label>Password</label>
            <input type="password" name="password" minlength="8" required>

            <button type="submit">Register as Student</button>
        </form>

        <a href="login.php">Already registered? Sign in</a>
    </div>
</body>
</html>
