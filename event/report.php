<?php
session_start();
require_once '../db.php';

// Only admin can download reports
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] != 1) {
    header("Location: ../dashboard.php");
    exit();
}

$event_id = $_GET['id'];
$attendees = $conn->query("SELECT name, email FROM attendees WHERE event_id = $event_id");

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="attendees_event_' . $event_id . '.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, ['Name', 'Email']);

while ($row = $attendees->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
