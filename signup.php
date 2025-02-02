<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Secure password hashing
    $role = isset($_POST['is_admin']) ? 'admin' : 'user';

    // Prepare and bind to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $password, $role);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the login page after successful signup
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Signup - Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
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
    <div class="container mt-5">
        <h2 style="padding-top: 180px;" class="text-center">Signup</h2>
        <form action="" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin">
                <label class="form-check-label" for="is_admin">Register as Admin</label>
            </div>
            <button type="submit" class="btn btn-success w-100">Signup</button>
        </form>

        <!-- Login Instead Button -->
        <div class="mt-3">
            <p style="padding-left: 500px;">Already have an account? <a href="login.php" class="btn btn-link">Login Instead</a></>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
