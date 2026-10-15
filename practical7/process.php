
<?php
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit("Please submit the registration form.");
}

function clean_input($value) {
    return trim((string)$value);
}

$firstName = clean_input($_POST["firstName"] ?? "");
$lastName = clean_input($_POST["lastName"] ?? "");
$enrollment = strtoupper(clean_input($_POST["enrollment"] ?? ""));
$email = strtolower(clean_input($_POST["email"] ?? ""));
$mobile = clean_input($_POST["mobile"] ?? "");
$dob = clean_input($_POST["dob"] ?? "");
$gender = clean_input($_POST["gender"] ?? "");
$course = clean_input($_POST["course"] ?? "");
$year = clean_input($_POST["year"] ?? "");
$password = $_POST["password"] ?? "";
$confirmPassword = $_POST["confirmPassword"] ?? "";
$terms = $_POST["terms"] ?? "";

$errors = [];

// Required-field validation
$required = [
    "First name" => $firstName,
    "Last name" => $lastName,
    "Enrollment" => $enrollment,
    "Email" => $email,
    "Mobile" => $mobile,
    "Date of birth" => $dob,
    "Gender" => $gender,
    "Course" => $course,
    "Year" => $year,
    "Password" => $password,
    "Confirm password" => $confirmPassword
];

foreach ($required as $field => $value) {
    if ($value === "") {
        $errors[] = "$field is required.";
    }
}

// Format validation
if ($email !== "" &&
    !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Please enter a valid email address.";
}

if ($enrollment !== "" &&
    !preg_match('/^[0-9]{2}[A-Z]{2}[0-9]{3}$/', $enrollment)) {
    $errors[] = "Enrollment must match the format 25CS073.";
}

if ($mobile !== "" &&
    !preg_match('/^[0-9]{10}$/', $mobile)) {
    $errors[] = "Mobile number must contain 10 digits.";
}

if ($year !== "" &&
    (!ctype_digit($year) || (int)$year < 1 || (int)$year > 6)) {
    $errors[] = "Please enter a valid academic year.";
}

$date = DateTime::createFromFormat('!Y-m-d', $dob);
if ($dob !== "" &&
    (!$date || $date->format('Y-m-d') !== $dob)) {
    $errors[] = "Please enter a valid date of birth.";
}

if ($password !== "" && strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters long.";
}

if ($password !== $confirmPassword) {
    $errors[] = "Passwords do not match.";
}

if (!in_array($terms, ["1", "on", "yes"], true)) {
    $errors[] = "You must accept the terms and conditions.";
}

// Show validation errors
if (!empty($errors)) {
    http_response_code(400);
    echo "<h2>Registration unsuccessful</h2><ul>";

    foreach ($errors as $error) {
        echo "<li>" . htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "</li>";
    }

    echo "</ul><p><a href='Register.html'>Go back to registration</a></p>";
    exit;
}

// Check for duplicate email or enrollment
$stmt = $conn->prepare(
    "SELECT id FROM users WHERE email = ? OR enrollment = ? LIMIT 1"
);
$stmt->bind_param("ss", $email, $enrollment);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    http_response_code(409);
    exit(
        "Email or enrollment number is already registered. " .
        "<a href='Register.html'>Go back</a>"
    );
}
$stmt->close();

// Hash the password before storing it
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert using a prepared statement
$stmt = $conn->prepare(
    "INSERT INTO users
    (first_name, last_name, enrollment, email, mobile,
     dob, gender, course, year, password_hash)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
);

$academicYear = (int)$year;

$stmt->bind_param(
    "ssssssssis",
    $firstName,
    $lastName,
    $enrollment,
    $email,
    $mobile,
    $dob,
    $gender,
    $course,
    $academicYear,
    $hashedPassword
);

try {
    $stmt->execute();

    echo "<h2>Registration Successful!</h2>";
    echo "<p>Your details have been saved securely.</p>";
    echo "<p><a href='Register.html'>Register another user</a></p>";

} catch (mysqli_sql_exception $e) {
    if ($e->getCode() === 1062) {
        http_response_code(409);
        echo "Email or enrollment number is already registered.";
    } else {
        error_log("Registration insert failed: " . $e->getMessage());
        http_response_code(500);
        echo "Registration could not be completed. Please try again.";
    }
} finally {
    $stmt->close();
    $conn->close();
}
?>
