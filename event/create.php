<?php
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Initialize status for success or error alert
$status = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form input values
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time']; // Get the event time from the form
    $capacity = $_POST['capacity'];
    $event_type = $_POST['event_type'];  // Get the event type from the dropdown
    $created_by = $_SESSION['user_id'];

    // Combine the date and time into a single datetime value
    $event_datetime = $date . ' ' . $time;

    // Prepare the SQL statement with placeholders
    $sql = "INSERT INTO events (name, description, date, event_time, capacity, event_type, created_by) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepare and bind the parameters
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssssssi", $name, $description, $date, $time, $capacity, $event_type, $created_by);

        // Execute the prepared statement
        if ($stmt->execute()) {
            $status = 'success';
        } else {
            $status = 'error';
        }

        // Close the statement
        $stmt->close();
    } else {
        $status = 'error';
    }
}
?>

<?php include '../header.php'; ?>

<div class="container mt-5">
    <h2>Create Event</h2>

    <!-- Success/Error Alert -->
    <?php if ($status == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Event created successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif ($status == 'error'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Failed to create the event. Please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form to create event -->
    <form action="" method="POST">
        <div class="mb-3">
            <label class="form-label">Event Name</label>
            <input type="text" class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Event Date</label>
            <input type="date" class="form-control" name="date" required>
        </div>

        <!-- Event Time input -->
        <div class="mb-3">
            <label class="form-label">Event Time</label>
            <input type="time" class="form-control" name="time" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" class="form-control" name="capacity" required>
        </div>

        <!-- Event Type Select Dropdown -->
        <div class="mb-3">
            <label class="form-label">Event Type</label>
            <select class="form-control" name="event_type" required>
                <option value="Wedding">Wedding</option>
                <option value="Conference">Conference</option>
                <option value="Birthday party">Birthday party</option>
                <option value="Networking event">Networking event</option>
                <option value="Product launch">Product launch</option>
                <option value="Concert">Concert</option>
                <option value="Reunion">Reunion</option>
                <option value="Trade show">Trade show</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Event</button>
        <a href="../dashboard.php" class="btn btn-secondary">Dashboard</a> <!-- Dashboard Button -->
    </form>
</div>

