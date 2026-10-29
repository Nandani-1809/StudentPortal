
<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = isset($_GET['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Hub Portal | Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="site-header">
    <img src="studenthublogo.png" alt="Student Hub Logo"
         width="110" height="110">
    <h1>STUDENT HUB PORTAL</h1>
    <p>Connecting Students Through Technology</p>

    <nav>
        <a href="Home.html">Home</a>
        <a href="AboutUs.html">About Us</a>
        <a href="Events.html">Events</a>
        <a href="FAQ.html">FAQ</a>
        <a href="Contact.html">Contact</a>
        <a href="login.php"><b>Login</b></a>
        <a href="Register.html">Register</a>
        <a href="Profile.html">Profile</a>
    </nav>
</header>

<section class="intro">
    <h2>Student Login</h2>
    <p>
        Login to access your dashboard, profile, assignments,
        results and latest college updates.
    </p>
</section>

<section class="login-section">
    <form action="authenticate.php" method="POST">
        <table class="login-table" cellpadding="15">
            <tr>
                <td colspan="2" class="center">
                    <img src="images/login.png" alt="Login"
                         width="120" height="120">
                </td>
            </tr>

            <?php if ($error): ?>
            <tr>
                <td colspan="2">
                    <p class="error-message">
                        Invalid email or password. Please try again.
                    </p>
                </td>
            </tr>
            <?php endif; ?>

            <tr>
                <td><label for="email"><b>Email ID</b></label></td>
                <td>
                    <input type="email" id="email" name="email"
                           placeholder="Enter Email Address"
                           autocomplete="username" required>
                </td>
            </tr>

            <tr>
                <td><label for="password"><b>Password</b></label></td>
                <td>
                    <input type="password" id="password" name="password"
                           placeholder="Enter Password"
                           autocomplete="current-password" required>
                </td>
            </tr>

            <tr>
                <td colspan="2" class="center">
                    <button type="submit">Login</button>
                    <button type="reset" class="clear-button">Clear</button>
                </td>
            </tr>
        </table>
    </form>
</section>

<section class="help-section">
    <h2>Need Help?</h2>
    <div class="help-grid">
        <div>
            <h3>Forgot Password?</h3>
            <p>Contact the administrator to reset your password.</p>
        </div>
        <div>
            <h3>New Student?</h3>
            <p>Create your account by visiting the Register page.</p>
            <a href="Register.html">Register Now</a>
        </div>
        <div>
            <h3>Support</h3>
            <p>Email: support@studenthub.com</p>
            <p>Phone: +91 98765 43210</p>
        </div>
    </div>
</section>

<section class="benefits">
    <h2>Benefits of Logging In</h2>
    <ul>
        <li>Access your personal dashboard.</li>
        <li>View assignments and attendance.</li>
        <li>Check examination results.</li>
        <li>Register for college events.</li>
        <li>Receive important announcements.</li>
        <li>Update your student profile.</li>
    </ul>
</section>

<footer>
    <h3>Student Hub Portal</h3>
    <p>
        <a href="Home.html">Home</a> |
        <a href="AboutUs.html">About Us</a> |
        <a href="Events.html">Events</a> |
        <a href="FAQ.html">FAQ</a> |
        <a href="Contact.html">Contact</a>
    </p>
    <p>&copy; 2026 Student Hub Portal | All Rights Reserved</p>
</footer>

</body>
</html>
