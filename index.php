<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Management System - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css"> <!-- Custom CSS -->
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
    <div class="container text-center mt-5">
        <h1 style="padding-top: 280px;">Welcome to Event Management System</h1>
        <p>Manage your events efficiently with our platform.</p>

        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="login.php" class="btn btn-primary btn-lg" aria-label="Go to login page">Login</a>
            <a href="signup.php" class="btn btn-success btn-lg" aria-label="Go to signup page">Signup</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>