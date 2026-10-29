<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php?error=' . rawurlencode('Please use the Delete button on a student record.'));
    exit;
}

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
if (!$id || $id < 1) {
    header('Location: index.php?error=' . rawurlencode('Invalid student ID.'));
    exit;
}

try {
    // Soft delete: preserve the row and update only its status.
    $stmt = $conn->prepare("UPDATE students SET status = 'inactive' WHERE id = ? AND status = 'active'");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $changed = $stmt->affected_rows;
    $stmt->close();

    if ($changed === 1) {
        header('Location: index.php?msg=' . rawurlencode('Student status changed to inactive. Record was not permanently deleted.'));
    } else {
        header('Location: index.php?error=' . rawurlencode('Student was not found or is already inactive.'));
    }
    exit;
} catch (mysqli_sql_exception $e) {
    header('Location: index.php?error=' . rawurlencode('Could not update student status. Please try again.'));
    exit;
}
