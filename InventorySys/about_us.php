<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Remove the background image */
            background-color: #f8f9fa; /* Use a light color or your preferred background color */
            color: #333;
        }

        .navbar {
            background-color: #50B498;
        }

        .navbar-brand img {
            height: 40px;
            width: auto;
            margin-right: 10px;
        }

        .container {
            margin-top: 30px;
        }

        .footer {
            background-color: #343a40;
            color: white;
            padding: 20px 0;
            text-align: center;
        }

        .footer a {
            color: #50B498;
            text-decoration: none;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #50B498;">
    <a class="navbar-brand" href="index.php">
         CBIT INVENTORY MANAGEMENT SYSTEM
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="about_us.php">About</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="contact_us.php">Contact</a>
            </li>
        </ul>
    </div>
</nav>

<!-- About Us Section -->
<div class="container">
    <h1>About Us</h1>
    <p>Welcome to CBIT Inventory Management System. We provide a comprehensive solution for managing inventory efficiently and effectively. Our system is designed to help businesses keep track of their stock, manage orders, and generate reports with ease.</p>
    <p>Our mission is to deliver top-notch inventory management tools that simplify complex tasks and empower businesses to make informed decisions. Our team of experts is dedicated to continuous improvement and innovation to meet the evolving needs of our clients.</p>
    <p>If you have any questions or need support, please feel free to <a href="contact_us.php">contact us</a>.</p>
</div>

<!-- Footer Section -->
<footer class="footer">
    <p>&copy; 2024 Inventory Management System. All rights reserved.</p>
    <p>
        <a href="privacy_policy.php">Privacy Policy</a> | 
        <a href="terms_of_service.php">Terms of Service</a>
    </p>
    <p>
        Contact us: <a href="mailto:info@inventorysystem.com">info@inventorysystem.com</a>
    </p>
</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>