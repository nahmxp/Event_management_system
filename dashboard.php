<?php
session_start(); // Always start the session at the beginning

include('db.php'); // Database connection

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Retrieve user session data
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_role = $_SESSION['user_role'];
$is_admin = $_SESSION['is_admin']; // User role information (admin or regular user)

// Fetch events from the database
$events = $conn->query("SELECT * FROM events ORDER BY date DESC");

?>

<?php include('header.php'); ?>

<!-- Carousel Section -->
<div id="carouselExample" class="carousel slide" data-bs-ride="carousel" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: -1; opacity: 0.2;">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/27.jpg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="assets/logo.png" class="d-block w-100" alt="Image 3">
            </div>
        </div>
    </div>

    <!-- Content Section -->

<div class="container mt-4">
    <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
    <p>You are logged in as: <strong><?php echo ucfirst($user_role); ?></strong></p>

    <!-- Success/Error Alerts -->
    <?php if (isset($_GET['deleted'])): ?>
        <div class="alert alert-<?php echo $_GET['deleted'] == 1 ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
            <?php echo $_GET['deleted'] == 1 ? 'Event deleted successfully!' : 'Failed to delete the event. Please try again.'; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Create Event and Logout Buttons -->
    <a href="event/create.php" class="btn btn-primary mb-3">Create Event</a>
    <a href="logout.php" class="btn btn-danger mb-3">Logout</a>

    <!-- Event List Section -->
    <h3 class="mt-4">Event List</h3>
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Event Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Event Type</th>
                <th>Capacity</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($events->num_rows > 0): ?>
                <?php $count = 1; ?>
                <?php while ($event = $events->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><?php echo htmlspecialchars($event['name']); ?></td>
                        <td><?php echo htmlspecialchars($event['description']); ?></td>
                        <td><?php echo htmlspecialchars($event['date']); ?></td>
                        <td><?php echo htmlspecialchars($event['event_time']); ?></td>
                        <td><?php echo htmlspecialchars($event['event_type']); ?></td>
                        <td><?php echo htmlspecialchars($event['capacity']); ?></td>
                        <td>
                            <a href="event/edit.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="event/delete.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this event?')">Delete</a>
                            <a href="event/register.php?id=<?= $event['id'] ?>" class="btn btn-sm btn-info">Register</a>

                            <!-- Admin only download button for CSV report -->
                            <?php if ($user_role == 'admin'): ?>
                                <a href="csv.php?event_id=<?= $event['id'] ?>" class="btn btn-sm btn-dark">Download Report</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No events available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

