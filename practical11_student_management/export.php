<?php
require_once 'db.php';

// Accept the same filters as index.php so the exported list matches the screen.
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
$result = $stmt->get_result();

// Prevent spreadsheet formula execution for text cells beginning with formula characters.
function csvSafe($value): string {
    $value = (string)($value ?? '');
    if (preg_match('/^\s*[=+@\-]/u', $value)) {
        return "'" . $value;
    }
    return $value;
}

$filename = 'student_records_' . date('Y-m-d_H-i-s') . '.csv';
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

$output = fopen('php://output', 'w');
// UTF-8 BOM helps Excel recognise UTF-8 text correctly.
fwrite($output, "\xEF\xBB\xBF");
fputcsv($output, ['ID', 'First Name', 'Last Name', 'Enrollment', 'Email', 'Date of Birth', 'Gender', 'Course', 'Year', 'Status']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        (int)$row['id'],
        csvSafe($row['first_name']),
        csvSafe($row['last_name']),
        csvSafe($row['enrollment']),
        csvSafe($row['email']),
        csvSafe($row['dob']),
        csvSafe($row['gender']),
        csvSafe($row['course']),
        (int)$row['year'],
        csvSafe($row['status'])
    ]);
}

fclose($output);
$stmt->close();
exit;
