<?php
// Practical 13: JSON API for Create, Read, Update and Delete (CRUD).
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $status, array $payload): void {
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function read_json_body(): array {
    $raw = file_get_contents('php://input');
    $data = json_decode($raw, true);
    if (!is_array($data)) {
        respond(400, ['success' => false, 'message' => 'Request body must contain valid JSON.']);
    }
    return $data;
}

function positive_id($value): int {
    $id = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
    if ($id === false) {
        respond(400, ['success' => false, 'message' => 'A valid event ID is required.']);
    }
    return (int)$id;
}

function validate_event(array $data): array {
    $name = trim((string)($data['name'] ?? ''));
    $date = trim((string)($data['date'] ?? ''));
    $venue = trim((string)($data['venue'] ?? ''));
    $category = trim((string)($data['category'] ?? ''));

    if ($name === '' || mb_strlen($name) > 150) {
        respond(422, ['success' => false, 'message' => 'Event name is required and must be at most 150 characters.']);
    }
    if ($venue === '' || mb_strlen($venue) > 150) {
        respond(422, ['success' => false, 'message' => 'Venue is required and must be at most 150 characters.']);
    }
    if ($category === '' || mb_strlen($category) > 60) {
        respond(422, ['success' => false, 'message' => 'Category is required and must be at most 60 characters.']);
    }

    $parsedDate = DateTime::createFromFormat('!Y-m-d', $date);
    if (!$parsedDate || $parsedDate->format('Y-m-d') !== $date) {
        respond(422, ['success' => false, 'message' => 'Enter a valid event date.']);
    }

    return [$name, $date, $venue, $category];
}

try {
    // Prefer a Practical 13-specific connection file when merged into a larger portal.
    // In the standalone package, db.php is used automatically.
    $connectionFile = __DIR__ . '/practical13_db.php';
    if (!is_file($connectionFile)) {
        $connectionFile = __DIR__ . '/db.php';
    }
    require $connectionFile;

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

    if ($method === 'GET') {
        $sql = 'SELECT id, name, DATE_FORMAT(event_date, "%Y-%m-%d") AS date, venue, category FROM events ORDER BY event_date ASC, id ASC';
        $result = $conn->query($sql);
        $events = [];
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        respond(200, ['success' => true, 'data' => $events]);
    }

    if ($method !== 'POST') {
        header('Allow: GET, POST');
        respond(405, ['success' => false, 'message' => 'Use GET to read events or POST to change events.']);
    }

    $data = read_json_body();
    $action = strtolower(trim((string)($data['action'] ?? '')));

    if ($action === 'create') {
        [$name, $date, $venue, $category] = validate_event($data);
        $statement = $conn->prepare('INSERT INTO events (name, event_date, venue, category) VALUES (?, ?, ?, ?)');
        $statement->bind_param('ssss', $name, $date, $venue, $category);
        $statement->execute();
        $newId = $statement->insert_id;
        $statement->close();
        respond(201, [
            'success' => true,
            'message' => 'Event added successfully.',
            'data' => ['id' => $newId, 'name' => $name, 'date' => $date, 'venue' => $venue, 'category' => $category]
        ]);
    }

    if ($action === 'update') {
        $id = positive_id($data['id'] ?? null);
        [$name, $date, $venue, $category] = validate_event($data);
        $statement = $conn->prepare('UPDATE events SET name = ?, event_date = ?, venue = ?, category = ? WHERE id = ?');
        $statement->bind_param('ssssi', $name, $date, $venue, $category, $id);
        $statement->execute();
        $updated = $statement->affected_rows;
        $statement->close();

        // affected_rows can be zero when the submitted values are unchanged, so check existence.
        $check = $conn->prepare('SELECT id FROM events WHERE id = ?');
        $check->bind_param('i', $id);
        $check->execute();
        $exists = $check->get_result()->num_rows > 0;
        $check->close();
        if (!$exists) {
            respond(404, ['success' => false, 'message' => 'Event not found. It may have already been deleted.']);
        }
        respond(200, [
            'success' => true,
            'message' => $updated > 0 ? 'Event updated successfully.' : 'No changes were needed.',
            'data' => ['id' => $id, 'name' => $name, 'date' => $date, 'venue' => $venue, 'category' => $category]
        ]);
    }

    if ($action === 'delete') {
        $id = positive_id($data['id'] ?? null);
        $statement = $conn->prepare('DELETE FROM events WHERE id = ?');
        $statement->bind_param('i', $id);
        $statement->execute();
        $deleted = $statement->affected_rows;
        $statement->close();
        if ($deleted === 0) {
            respond(404, ['success' => false, 'message' => 'Event not found. It may have already been deleted.']);
        }
        respond(200, ['success' => true, 'message' => 'Event deleted successfully.']);
    }

    respond(400, ['success' => false, 'message' => 'Unknown action. Use create, update or delete.']);
} catch (Throwable $error) {
    error_log('Practical 13 API error: ' . $error->getMessage());
    respond(500, ['success' => false, 'message' => 'Server/database error. Check db.php settings and make sure schema.sql has been imported.']);
}
