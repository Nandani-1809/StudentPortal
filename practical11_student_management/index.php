<?php
require_once 'db.php';

function h($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$message = trim($_GET['msg'] ?? '');
$error = trim($_GET['error'] ?? '');
$formError = '';

// CREATE: add one student using a prepared statement.
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $enrollment = trim($_POST['enrollment'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dobInput = trim($_POST['dob'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $year = filter_var($_POST['year'] ?? null, FILTER_VALIDATE_INT);
    $dob = $dobInput !== '' ? $dobInput : null;

    if ($firstName === '' || $lastName === '' || $enrollment === '' || $email === '' || $course === '' || !$year) {
        $formError = 'Please fill in all required fields and select a valid study year.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formError = 'Please enter a valid email address.';
    } elseif ($year < 1 || $year > 6) {
        $formError = 'Study year must be between 1 and 6.';
    } else {
        try {
            $stmt = $conn->prepare(
                'INSERT INTO students (first_name, last_name, enrollment, email, dob, gender, course, year, status)
                 VALUES (?, ?, ?, ?, ?, ?, ?, ?, \'active\')'
            );
            $stmt->bind_param('sssssssi', $firstName, $lastName, $enrollment, $email, $dob, $gender, $course, $year);
            $stmt->execute();
            $stmt->close();
            header('Location: index.php?msg=' . rawurlencode('Student added successfully.'));
            exit;
        } catch (mysqli_sql_exception $e) {
            if ((int)$e->getCode() === 1062) {
                $formError = 'That enrollment number or email already exists. Please use a unique value.';
            } else {
                $formError = 'Student could not be added. Please check your input and try again.';
            }
        }
    }
}

// READ: search by name, email or course; also filter by course/status.
$search = trim($_GET['search'] ?? '');
$courseFilter = trim($_GET['course'] ?? '');
$statusFilter = trim($_GET['status'] ?? '');
$like = '%' . $search . '%';

$sql = "SELECT id, first_name, last_name, enrollment, email, dob, gender, course, year, status
        FROM students
        WHERE (CONCAT(first_name, ' ', last_name) LIKE ?
               OR first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR course LIKE ?)
          AND (? = '' OR course = ?)
          AND (? = '' OR status = ?)
        ORDER BY id DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sssssssss', $like, $like, $like, $like, $like, $courseFilter, $courseFilter, $statusFilter, $statusFilter);
$stmt->execute();
$students = $stmt->get_result();

$courseResult = $conn->query('SELECT DISTINCT course FROM students ORDER BY course');
$courses = [];
while ($courseRow = $courseResult->fetch_assoc()) {
    $courses[] = $courseRow['course'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practical 11 | Student Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <header class="page-header">
        <div>
            <p class="eyebrow">PHP · MySQLi · XAMPP</p>
            <h1>Student Management</h1>
            <p class="subtitle">Add, view, edit, search, filter and deactivate student records.</p>
        </div>
    </header>

    <?php if ($message !== ''): ?><div class="alert success" role="status"><?= h($message) ?></div><?php endif; ?>
    <?php if ($error !== ''): ?><div class="alert error" role="alert"><?= h($error) ?></div><?php endif; ?>
    <?php if ($formError !== ''): ?><div class="alert error" role="alert"><?= h($formError) ?></div><?php endif; ?>

    <section class="panel">
        <h2>Add a student</h2>
        <form method="post" action="index.php" class="student-form">
            <label>First name *<input type="text" name="first_name" maxlength="100" required value="<?= h($_POST['first_name'] ?? '') ?>"></label>
            <label>Last name *<input type="text" name="last_name" maxlength="100" required value="<?= h($_POST['last_name'] ?? '') ?>"></label>
            <label>Enrollment number *<input type="text" name="enrollment" maxlength="30" required value="<?= h($_POST['enrollment'] ?? '') ?>"></label>
            <label>Email address *<input type="email" name="email" maxlength="150" required value="<?= h($_POST['email'] ?? '') ?>"></label>
            <label>Date of birth<input type="date" name="dob" value="<?= h($_POST['dob'] ?? '') ?>"></label>
            <label>Gender
                <select name="gender">
                    <option value="">Select gender</option>
                    <?php foreach (['Female', 'Male', 'Other', 'Prefer not to say'] as $g): ?>
                        <option value="<?= h($g) ?>" <?= (($_POST['gender'] ?? '') === $g) ? 'selected' : '' ?>><?= h($g) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Course *
                <select name="course" required>
                    <option value="">Select course</option>
                    <?php foreach (['Computer Science', 'Information Technology', 'Computer Engineering', 'Mechanical Engineering', 'Electrical Engineering'] as $c): ?>
                        <option value="<?= h($c) ?>" <?= (($_POST['course'] ?? '') === $c) ? 'selected' : '' ?>><?= h($c) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Study year *
                <select name="year" required>
                    <option value="">Select year</option>
                    <?php for ($y = 1; $y <= 6; $y++): ?>
                        <option value="<?= $y ?>" <?= ((string)($_POST['year'] ?? '') === (string)$y) ? 'selected' : '' ?>>Year <?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </label>
            <div class="form-actions"><button type="submit" name="add_student" class="button primary">Add student</button></div>
        </form>
    </section>

    <section class="panel">
        <div class="section-heading">
            <div><h2>Student records</h2><p class="muted">Inactive records remain in the database for soft-delete verification.</p></div>
            <a class="button secondary" href="export.php?<?= h(http_build_query(['search' => $search, 'course' => $courseFilter, 'status' => $statusFilter])) ?>">Export CSV</a>
        </div>

        <form class="filter-form" method="get" action="index.php">
            <label class="search-field">Search name, email or course
                <input type="search" name="search" placeholder="e.g. Asha or example@email.com" value="<?= h($search) ?>">
            </label>
            <label>Course
                <select name="course">
                    <option value="">All courses</option>
                    <?php foreach ($courses as $c): ?>
                        <option value="<?= h($c) ?>" <?= $courseFilter === $c ? 'selected' : '' ?>><?= h($c) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Status
                <select name="status">
                    <option value="">All statuses</option>
                    <option value="active" <?= $statusFilter === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $statusFilter === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                </select>
            </label>
            <button type="submit" class="button primary">Search / Filter</button>
            <a class="button secondary" href="index.php">Reset</a>
        </form>

        <div class="table-wrap">
            <table>
                <thead><tr><th>ID</th><th>Student</th><th>Enrollment</th><th>Email</th><th>Course</th><th>Year</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                <?php if ($students->num_rows === 0): ?>
                    <tr><td colspan="8" class="empty">No matching student records found.</td></tr>
                <?php else: ?>
                    <?php while ($row = $students->fetch_assoc()): ?>
                        <tr>
                            <td><?= (int)$row['id'] ?></td>
                            <td><?= h($row['first_name'] . ' ' . $row['last_name']) ?></td>
                            <td><?= h($row['enrollment']) ?></td>
                            <td><?= h($row['email']) ?></td>
                            <td><?= h($row['course']) ?></td>
                            <td><?= (int)$row['year'] ?></td>
                            <td><span class="status <?= $row['status'] === 'active' ? 'active' : 'inactive' ?>"><?= h(ucfirst($row['status'])) ?></span></td>
                            <td class="actions">
                                <a class="button small secondary" href="edit.php?id=<?= (int)$row['id'] ?>">Edit</a>
                                <?php if ($row['status'] === 'active'): ?>
                                    <form action="delete.php" method="post" onsubmit="return confirm('Are you sure you want to mark this student as inactive? The record will not be permanently deleted.');">
                                        <input type="hidden" name="id" value="<?= (int)$row['id'] ?>">
                                        <button class="button small danger" type="submit">Delete</button>
                                    </form>
                                <?php else: ?>
                                    <span class="muted">Already inactive</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>
    <footer>Practical 11 · Student Management CRUD with Search and Filter</footer>
</div>
</body>
</html>
