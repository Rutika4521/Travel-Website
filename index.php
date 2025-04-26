<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel Guide</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css?v=<?=time();?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</head>
<body class="body">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Travel Guide</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog/index.php">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog/login.php">login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="blog/submit.php">Submit</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero text-center text-white d-flex align-items-center justify-content-center">
        <div class="container">
            <h1 class="display-4 mb-4"><span style="background-color: rgba(210, 230, 139, 0.589);">Discover Your Next Adventure</span></h1>
            <p class="lead mb-4"><span style="background-color: rgba(210, 230, 139, 0.589);">Explore top destinations, find the best places to stay, and plan your perfect trip.</span></p>
            <form class="d-flex justify-content-center">
                <input class="form-control me-2" type="search" placeholder="Search destinations" aria-label="Search">
                <button class="btn btn-light" type="submit">Search</button>
            </form>
        </div>
    </header>

    <!-- Popular Destinations Section -->
    <section class="container my-5">
        <h1 class="text-center mb-4" style="font-family: cursive;"><span style="background-color: rgba(205, 244, 243, 0.589);">Popular Destinations</span></h1>
        <div id="destinationCarousel" class="carousel slide" data-ride="carousel">

            <div class="carousel-inner" id="destination-carousel-items">
                <!-- Dynamic carousel items will be inserted here -->
            </div>
            
            <!-- Controls -->
            <a class="carousel-control-prev" href="#destinationCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#destinationCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
        <div class="text-center mt-5">
            <a href="blog/submit.php" class="btn btn-primary">Submit a Blog</a>
            <a href="blog/index.php" class="nav-link">Blogs</a>

        </div>

    </section>
    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3">
        <p>&copy; 2024 Travel Guide. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>

</body>
</html>
