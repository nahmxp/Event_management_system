<?php
// Start the session only if it's not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Management System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Brand redirects to the dashboard -->
            <a class="navbar-brand" href="/Event_management_system/dashboard.php">EMS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <!-- Display username if logged in -->
                        <li class="nav-item">
                            <span class="nav-link text-light">Welcome, <?= htmlspecialchars($_SESSION['user_name']) ?></span>
                        </li>
                        <!-- Logout button with correct path -->
                        <li class="nav-item">
                            <a class="nav-link btn btn-danger text-white px-3 ms-2" href="/Event_management_system/logout.php">Logout</a>
                        </li>
                    <?php else: ?>
                        <!-- If not logged in, show login button -->
                        <li class="nav-item">
                            <a class="nav-link btn btn-success text-white px-3 ms-2" href="/Event_management_system/login.php">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main content starts here -->
    <div class="container mt-4">