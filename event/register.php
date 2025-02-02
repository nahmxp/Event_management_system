<?php
session_start();
require_once '../db.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Get event ID from query parameter
$event_id = $_GET['id'];

// Fetch event details
$event = $conn->query("SELECT * FROM events WHERE id = $event_id")->fetch_assoc();
$attendees_count = $conn->query("SELECT COUNT(*) AS total FROM attendees WHERE event_id = $event_id")->fetch_assoc()['total'];

// Check if event capacity is reached
if ($attendees_count >= $event['capacity']) {
    die("Registration is full for this event.");
}

// Handle registration
if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Insert new attendee into the database
    $conn->query("INSERT INTO attendees (event_id, name, email) VALUES ($event_id, '$name', '$email')");

    // Redirect back to the dashboard after successful registration
    header("Location: ../dashboard.php?registered=1");
    exit();
}
?>

<?php include '../header.php'; ?>

<div class="container mt-4">
    <h2>Register for <?= $event['name'] ?></h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" required>
        </div>
        <button type="submit" name="register" class="btn btn-success">Register</button>
    </form>
</div>


