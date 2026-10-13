<?ph
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    die("Invalid request method.");
}
function clean_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');

    return $data;
}


// --------------------------------------------------
// Receive and sanitize form data
// --------------------------------------------------

$name = clean_input($_POST["name"] ?? "");

$enrollment = clean_input($_POST["enrollment"] ?? "");

$email = clean_input($_POST["email"] ?? "");

$mobile = clean_input($_POST["mobile"] ?? "");

$dob = clean_input($_POST["dob"] ?? "");

$gender = clean_input($_POST["gender"] ?? "");

$department = clean_input($_POST["department"] ?? "");

$year = clean_input($_POST["year"] ?? "");

$password = $_POST["password"] ?? "";

$confirmPassword = $_POST["confirmPassword"] ?? "";

$terms = $_POST["terms"] ?? "";


// --------------------------------------------------
// Validation
// --------------------------------------------------

$errors = [];


// Name validation
if ($name === "") {

    $errors[] = "Name is required.";

} elseif (!preg_match("/^[a-zA-Z ]+$/", $name)) {

    $errors[] = "Name should contain only letters and spaces.";
}


// Enrollment validation
if ($enrollment === "") {

    $errors[] = "Enrollment number is required.";

}


// Email validation
if ($email === "") {

    $errors[] = "Email is required.";

} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    $errors[] = "Please enter a valid email address.";
}


// Mobile validation
if ($mobile === "") {

    $errors[] = "Mobile number is required.";

} elseif (!preg_match("/^[0-9]{10}$/", $mobile)) {

    $errors[] = "Mobile number must contain exactly 10 digits.";
}


// Date of birth validation
if ($dob === "") {

    $errors[] = "Date of birth is required.";

}


// Gender validation
if ($gender === "") {

    $errors[] = "Please select your gender.";

}


// Department validation
if ($department === "") {

    $errors[] = "Please select your department.";

}


// Year validation
if ($year === "") {

    $errors[] = "Please select your year.";

}


// Password validation
if ($password === "") {

    $errors[] = "Password is required.";

} elseif (strlen($password) < 6) {

    $errors[] = "Password must contain at least 6 characters.";

}


// Confirm password
if ($confirmPassword === "") {

    $errors[] = "Please confirm your password.";

} elseif ($password !== $confirmPassword) {

    $errors[] = "Passwords do not match.";

}


// Terms
if ($terms !== "accepted") {

    $errors[] = "You must accept the terms and conditions.";

}


// --------------------------------------------------
// Display validation errors
// --------------------------------------------------

if (!empty($errors)) {

    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>Registration Error</title>";

    echo "<style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 40px;
        }

        .message {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            color: #d32f2f;
        }

        li {
            margin: 10px 0;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            padding: 10px 20px;
            background: #333;
            color: white;
            border-radius: 5px;
        }

    </style>";

    echo "</head>";

    echo "<body>";

    echo "<div class='message'>";

    echo "<h2>Registration Failed</h2>";

    echo "<p>Please correct the following errors:</p>";

    echo "<ul>";

    foreach ($errors as $error) {

        echo "<li>" . htmlspecialchars($error) . "</li>";

    }

    echo "</ul>";

    echo "<a href='register.php'>Go Back to Registration</a>";

    echo "</div>";

    echo "</body>";

    echo "</html>";

    exit;
}


// --------------------------------------------------
// Password hashing
// --------------------------------------------------

// Never store the original password in the CSV file.

$hashedPassword = password_hash(
    $password,
    PASSWORD_DEFAULT
);


// --------------------------------------------------
// CSV file
// --------------------------------------------------

$file = "data.csv";


// --------------------------------------------------
// Create CSV file with headings if it doesn't exist
// --------------------------------------------------

if (!file_exists($file)) {

    $handle = fopen($file, "w");

    if ($handle === false) {

        die("Unable to create data file.");

    }

    fputcsv($handle, [
        "Name",
        "Enrollment",
        "Email",
        "Mobile",
        "DOB",
        "Gender",
        "Department",
        "Year",
        "Password"
    ]);

    fclose($handle);
}


// --------------------------------------------------
// Open CSV file for appending
// --------------------------------------------------

$handle = fopen($file, "a");


// Check if file opened successfully
if ($handle === false) {

    die("Unable to open data file.");

}


// --------------------------------------------------
// Store data
// --------------------------------------------------

fputcsv($handle, [

    $name,
    $enrollment,
    $email,
    $mobile,
    $dob,
    $gender,
    $department,
    $year,
    $hashedPassword

]);


// Close file
fclose($handle);


// --------------------------------------------------
// Success message
// --------------------------------------------------

echo "<!DOCTYPE html>";

echo "<html>";

echo "<head>";

echo "<title>Registration Successful</title>";

echo "<style>

    body {
        font-family: Arial, sans-serif;
        background: #f5f5f5;
        padding: 40px;
    }

    .success {
        max-width: 600px;
        margin: auto;
        background: white;
        padding: 40px;
        text-align: center;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    h2 {
        color: green;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        text-decoration: none;
        padding: 10px 20px;
        background: #333;
        color: white;
        border-radius: 5px;
    }

</style>";

echo "</head>";

echo "<body>";

echo "<div class='success'>";

echo "<h2>Registration Successful!</h2>";

echo "<p>Thank you, <strong>"
    . htmlspecialchars($name)
    . "</strong>.</p>";

echo "<p>Your registration has been successfully submitted.</p>";

echo "<a href='register.php'>Register Another Student</a>";

echo "</div>";

echo "</body>";

echo "</html>";

?>