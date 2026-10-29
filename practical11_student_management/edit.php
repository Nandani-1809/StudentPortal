<?php
require_once 'db.php';

function h($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    header('Location: index.php?error=' . rawurlencode('Invalid student ID.'));
    exit;
}

$select = $conn->prepare('SELECT id, first_name, last_name, enrollment, email, dob, gender, course, year, status FROM students WHERE id = ?');
$select->bind_param('i', $id);
$select->execute();
$student = $select->get_result()->fetch_assoc();
$select->close();

if (!$student) {
    header('Location: index.php?error=' . rawurlencode('Student record was not found.'));
    exit;
}

$formError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_student'])) {
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $enrollment = trim($_POST['enrollment'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dobInput = trim($_POST['dob'] ?? '');
    $dob = $dobInput !== '' ? $dobInput : null;
    $gender = trim($_POST['gender'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $year = filter_var($_POST['year'] ?? null, FILTER_VALIDATE_INT);

    if ($firstName === '' || $lastName === '' || $enrollment === '' || $email === '' || $course === '' || !$year) {
        $formError = 'Please fill in all required fields and select a valid study year.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $formError = 'Please enter a valid email address.';
    } elseif ($year < 1 || $year > 6) {
        $formError = 'Study year must be between 1 and 6.';
    } else {
        try {
            $update = $conn->prepare(
                'UPDATE students SET first_name = ?, last_name = ?, enrollment = ?, email = ?, dob = ?, gender = ?, course = ?, year = ? WHERE id = ?'
            );
            $update->bind_param('sssssssii', $firstName, $lastName, $enrollment, $email, $dob, $gender, $course, $year, $id);
            $update->execute();
            $update->close();
            header('Location: index.php?msg=' . rawurlencode('Student details updated successfully.'));
            exit;
        } catch (mysqli_sql_exception $e) {
            if ((int)$e->getCode() === 1062) {
                $formError = 'That enrollment number or email already belongs to another student.';
            } else {
                $formError = 'Student details could not be updated. Please try again.';
            }
        }
    }

    // Redisplay submitted values if validation or update fails.
    $student['first_name'] = $firstName;
    $student['last_name'] = $lastName;
    $student['enrollment'] = $enrollment;
    $student['email'] = $email;
    $student['dob'] = $dob;
    $student['gender'] = $gender;
    $student['course'] = $course;
    $student['year'] = $year ?: '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student | Practical 11</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container narrow">
    <header class="page-header"><div><p class="eyebrow">Practical 11</p><h1>Edit student</h1><p class="subtitle">Update details for student ID <?= (int)$student['id'] ?>.</p></div></header>
    <?php if ($formError !== ''): ?><div class="alert error" role="alert"><?= h($formError) ?></div><?php endif; ?>
    <section class="panel">
        <form method="post" action="edit.php" class="student-form">
            <input type="hidden" name="id" value="<?= (int)$student['id'] ?>">
            <label>First name *<input type="text" name="first_name" required maxlength="100" value="<?= h($student['first_name']) ?>"></label>
            <label>Last name *<input type="text" name="last_name" required maxlength="100" value="<?= h($student['last_name']) ?>"></label>
            <label>Enrollment number *<input type="text" name="enrollment" required maxlength="30" value="<?= h($student['enrollment']) ?>"></label>
            <label>Email address *<input type="email" name="email" required maxlength="150" value="<?= h($student['email']) ?>"></label>
            <label>Date of birth<input type="date" name="dob" value="<?= h($student['dob']) ?>"></label>
            <label>Gender
                <select name="gender">
                    <option value="">Select gender</option>
                    <?php foreach (['Female', 'Male', 'Other', 'Prefer not to say'] as $g): ?>
                        <option value="<?= h($g) ?>" <?= $student['gender'] === $g ? 'selected' : '' ?>><?= h($g) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Course *
                <select name="course" required>
                    <?php foreach (['Computer Science', 'Information Technology', 'Computer Engineering', 'Mechanical Engineering', 'Electrical Engineering'] as $c): ?>
                        <option value="<?= h($c) ?>" <?= $student['course'] === $c ? 'selected' : '' ?>><?= h($c) ?></option>
                    <?php endforeach; ?>
                </select>
            </label>
            <label>Study year *
                <select name="year" required>
                    <?php for ($y = 1; $y <= 6; $y++): ?>
                        <option value="<?= $y ?>" <?= (int)$student['year'] === $y ? 'selected' : '' ?>>Year <?= $y ?></option>
                    <?php endfor; ?>
                </select>
            </label>
            <div class="form-actions"><button type="submit" name="update_student" class="button primary">Save changes</button><a class="button secondary" href="index.php">Cancel</a></div>
        </form>
        <p class="muted">Status: <strong><?= h(ucfirst($student['status'])) ?></strong>. Use Delete on the main list to mark an active record inactive.</p>
    </section>
</div>
</body>
</html>
