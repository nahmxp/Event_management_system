<?php
session_start();
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit();
}

// Check if event ID is provided
if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']);

    // Fetch event details
    $event_query = $conn->query("SELECT * FROM events WHERE id = $event_id");
    if ($event_query->num_rows > 0) {
        $event = $event_query->fetch_assoc();

        // Fetch attendees for this event
        $attendees_query = $conn->query("SELECT name, email FROM attendees WHERE event_id = $event_id");
        $attendees = [];
        while ($attendee = $attendees_query->fetch_assoc()) {
            $attendees[] = $attendee;
        }

        // Return the event details and attendees as JSON
        echo json_encode(['status' => 'success', 'event' => $event, 'attendees' => $attendees]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Event not found']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Event ID not provided']);
}
exit();
?>
