<?php
session_start(); // Always start the session at the beginning

include('db.php'); // Database connection

// Initialize error message variable
$error_message = '';

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and collect user input
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind the email parameter
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify password
            if (password_verify($password, $row['password'])) {
                // Set session variables for user login
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['user_role'] = $row['role'];
                $_SESSION['is_admin'] = $row['role'] == 'admin'; // Set is_admin as true if role is admin

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error_message = "Invalid password. Please try again.";
            }
        } else {
            $error_message = "No user found with this email.";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        $error_message = "Error preparing the SQL query.";
    }
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Event Management System</title>
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
    <div style="padding-top: 180px;" class="container mt-5">
        <h2 class="text-center">Login</h2>

        <!-- Display error message if any -->
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $error_message; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Login form -->
        <form action="" method="POST" class="mx-auto" style="max-width: 400px;">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <!-- Registration link -->
        <div class="text-center mt-3">
            <a href="signup.php" class="btn btn-link">Still not registered? Sign up here.</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
