<?php
// Include the database connection
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Check if form is submitted
if (isset($_POST['update'])) {
    // Get the event ID from the URL
    $event_id = $_GET['id'];

    // Collect and sanitize form data
    $name = $conn->real_escape_string($_POST['name']);
    $description = $conn->real_escape_string($_POST['description']);
    $date = $_POST['date'];
    $event_time = $_POST['time'];
    $capacity = (int)$_POST['capacity'];
    $event_type = $conn->real_escape_string($_POST['event_type']);

    // Prepare the SQL query to update the event details
    $sql = "UPDATE events SET name = ?, description = ?, date = ?, event_time = ?, capacity = ?, event_type = ? WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters and execute the query
        $stmt->bind_param("ssssisi", $name, $description, $date, $event_time, $capacity, $event_type, $event_id);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect with success status
            header("Location: edit.php?id=$event_id&status=success");
            exit();
        } else {
            // Redirect with error status if the update fails
            header("Location: edit.php?id=$event_id&status=error");
            exit();
        }
    } else {
        // Redirect with error status if preparing the statement fails
        header("Location: edit.php?id=$event_id&status=error");
        exit();
    }
}
