<?php
session_start();
include('db.php');

// Check if user is logged in and if user is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['event_id'])) {
    $event_id = $_GET['event_id'];

    // Fetch the event details
    $event_query = $conn->query("SELECT * FROM events WHERE id = $event_id");

    // Check if event exists
    if ($event_query->num_rows == 0) {
        die("No event found with the provided ID.");
    }

    $event = $event_query->fetch_assoc();

    // Fetch attendees for this event
    $attendees_query = $conn->query("SELECT * FROM attendees WHERE event_id = $event_id");

    // Check if there are attendees
    if ($attendees_query->num_rows == 0) {
        die("No attendees found for this event.");
    }

    // Define the file name for the CSV
    $filename = "event_{$event['name']}_attendees.csv";

    // Set headers to force download of the CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '"');

    // Open the output stream
    $output = fopen('php://output', 'w');

    // Add CSV header including event details
    fputcsv($output, [
        'Event Name',
        'Event Description',
        'Event Date',
        'Event Time',
        'Attendee Name',
        'Attendee Email',
        'Attendee Phone',
        'Registration Date'
    ]);

    // Loop through attendees and add event details along with attendee info
    while ($attendee = $attendees_query->fetch_assoc()) {
        fputcsv($output, [
            $event['name'],
            $event['description'],  // Add event description
            $event['date'],  // Add event date
            $event['event_time'],  // Add event time
            $attendee['name'],
            $attendee['email'],
            $attendee['phone'],
            $attendee['registration_date']
        ]);
    }

    // Close the file stream
    fclose($output);
    exit();
} else {
    echo "Event ID not provided.";
    exit();
}
