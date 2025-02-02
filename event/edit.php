<?php
// Include the database connection
include('../db.php');

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// Fetch event details for editing
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $result = $conn->query("SELECT * FROM events WHERE id = $event_id");

    // Check if event exists
    if ($result->num_rows > 0) {
        $event = $result->fetch_assoc();
    } else {
        // Redirect to dashboard if the event doesn't exist
        header("Location: ../dashboard.php");
        exit();
    }
} else {
    // If no event ID is provided, redirect to the dashboard
    header("Location: ../dashboard.php");
    exit();
}
?>

<?php include '../header.php'; ?>

<div class="container mt-4">
    <h2>Edit Event</h2>

    <!-- Dashboard Button -->
    <a href="../dashboard.php" class="btn btn-secondary mb-3">Back to Dashboard</a>

    <!-- Success/Error Alert -->
    <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            Event updated successfully!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Failed to update the event. Please try again.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Form to update event details -->
    <form method="POST" action="update.php?id=<?= $event_id ?>">
        <div class="mb-3">
            <label class="form-label">Event Name</label>
            <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($event['name']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" required><?= htmlspecialchars($event['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" class="form-control" name="date" value="<?= htmlspecialchars($event['date']) ?>" required>
        </div>

        <!-- Event Time input -->
        <div class="mb-3">
            <label class="form-label">Event Time</label>
            <input type="time" class="form-control" name="time" value="<?= htmlspecialchars($event['event_time']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Capacity</label>
            <input type="number" class="form-control" name="capacity" value="<?= htmlspecialchars($event['capacity']) ?>" required>
        </div>

        <!-- Event Type Select Dropdown -->
        <div class="mb-3">
            <label class="form-label">Event Type</label>
            <select class="form-control" name="event_type" required>
                <option value="Wedding" <?= $event['event_type'] == 'Wedding' ? 'selected' : '' ?>>Wedding</option>
                <option value="Conference" <?= $event['event_type'] == 'Conference' ? 'selected' : '' ?>>Conference</option>
                <option value="Birthday party" <?= $event['event_type'] == 'Birthday party' ? 'selected' : '' ?>>Birthday party</option>
                <option value="Networking event" <?= $event['event_type'] == 'Networking event' ? 'selected' : '' ?>>Networking event</option>
                <option value="Product launch" <?= $event['event_type'] == 'Product launch' ? 'selected' : '' ?>>Product launch</option>
                <option value="Concert" <?= $event['event_type'] == 'Concert' ? 'selected' : '' ?>>Concert</option>
                <option value="Reunion" <?= $event['event_type'] == 'Reunion' ? 'selected' : '' ?>>Reunion</option>
                <option value="Trade show" <?= $event['event_type'] == 'Trade show' ? 'selected' : '' ?>>Trade show</option>
            </select>
        </div>

        <button type="submit" name="update" class="btn btn-primary">Update Event</button>
    </form>
</div>

