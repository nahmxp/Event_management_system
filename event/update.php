<?php
session_start();
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check if event ID is provided
if (isset($_GET['id']) && isset($_POST['update'])) {
    $event_id = $_GET['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $date = $_POST['date'];
    $capacity = (int)$_POST['capacity'];

    // Update query
    $update_query = "UPDATE events SET name='$name', description='$description', date='$date', capacity='$capacity' WHERE id=$event_id";

    if ($conn->query($update_query) === TRUE) {
        // Redirect back to edit page with success flag
        header("Location: edit.php?id=$event_id&status=success");
    } else {
        // Redirect back with error flag
        header("Location: edit.php?id=$event_id&status=error");
    }
    exit();
} else {
    header("Location: ../dashboard.php");
    exit();
}
