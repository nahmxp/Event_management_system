<?php
include('../db.php');

$query = isset($_GET['query']) ? $conn->real_escape_string($_GET['query']) : '';

if ($query) {
    $result = $conn->query("SELECT id, name, event_type,  description FROM events WHERE name LIKE '%$query%' OR description LIKE '%$query%' OR event_type LIKE '%$query%' LIMIT 10");

    $events = [];
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    echo json_encode($events);
} else {
    echo json_encode([]);
}
?>
