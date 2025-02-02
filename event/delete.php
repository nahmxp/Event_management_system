<?php
session_start();
require_once '../db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check if the event ID is provided
if (isset($_GET['id'])) {
    $event_id = intval($_GET['id']); // Ensure the ID is an integer to prevent SQL injection

    // Delete the event
    if ($conn->query("DELETE FROM events WHERE id = $event_id") === TRUE) {
        header("Location: ../dashboard.php?deleted=1"); // Redirect with success message
        exit();
    } else {
        header("Location: ../dashboard.php?deleted=0"); // Redirect with failure message
        exit();
    }
} else {
    header("Location: ../dashboard.php"); // If no ID provided, just redirect back
    exit();
}
