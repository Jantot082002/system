<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            /* Removed the background image */
            background-color: #f8f9fa; /* Light background color */
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

<!-- Contact Us Section -->
<div class="container">
    <h1>Contact Us</h1>
    <p>If you have any questions or need further information, feel free to reach out to us using the contact details below or through the contact form.</p>
    <div class="row">
        <div class="col-md-6">
            <h4>Contact Information</h4>
            <p>Email: <a href="nimrodbanayag1@gmail.com">nimrodbanayag1@gmail.com</a></p>
            <p>Phone: 09121604132</p>
            <p>Address: Brgy. De Oro Butuan city, 8600 Agusan Del Norte Philippines.</p>
        </div>
        
    </div>
</div>


</footer>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


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
</body>
</html>