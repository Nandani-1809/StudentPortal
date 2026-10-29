
<?php
require_once 'auth_check.php';

if ($_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit;
}

if ($_SESSION['role'] === 'student') {
    header("Location: student_dashboard.php");
    exit;
}

http_response_code(403);
exit("Unauthorized Access");
?>
