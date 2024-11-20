<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
    // Get form input values
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } else {
        // Prepare SQL statement to retrieve user information based only on username
        $stmt = $conn->prepare("SELECT * FROM registration WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $row['password'])) {
                // Insert login attempt into the database
                $stmt_insert_login = $conn->prepare("INSERT INTO login_attempts (username, login_time) VALUES (?, NOW())");
                $stmt_insert_login->bind_param("s", $username);
                $stmt_insert_login->execute();

                // Check if role matches
                if ($row['role'] == $role) {
                    // Set session variables
                    $_SESSION['username'] = $username;
                    $_SESSION['role'] = $role;
                    // Redirect to dashboard
                    header("Location: Dashboard.php");
                    exit();
                } else {
                    echo '<script>alert("Invalid role for this user!");</script>';
                }
            } else {
                echo '<script>alert("Invalid username or password!");</script>';
            }
        } else {
            echo '<script>alert("Invalid username or password!");</script>';
        }
        // Close statement and connection
        $stmt->close();
        $conn->close();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
      body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    background-image: url(bg.png);
    background-size: cover; /* Cover the entire viewport */
}

.navbar {
    background-color: #50B498; /* Teal color for navbar background */
    margin-top: -12px;

}

.navbar-brand {
    font-weight: bold; 
    font-family: 'Arial', sans-serif; 
    font-size: 24px; 
    font-style: oblique; 
    text-align: center; 
    letter-spacing: 1px; 
    line-height: 1.2; 
    text-transform: uppercase; 
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); 
    color: #ffffff; 
    background-color: #50B498;
    padding: 10px; 
    white-space: nowrap; /* Prevent text wrapping */
}

/* Adjust the form container */
.form-container {
    max-width: 400px; /* Limit the width of the form */
    width: 100%;
    margin: 20px auto; /* Center the form horizontally */
    transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
}

.form-container.collapsed {
    transform: scale(0.8);
    opacity: 0.5;
}

.form-container form {
    padding: 20px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: rgba(249, 249, 249, 0.8); /* Transparent background color */
    transition: height 0.5s ease-in-out;

}

.form-container h2 {
    text-align: center;
    color: #333;
    font-size: 36px;
   
}

.form-container .form-group {
    margin-bottom: 15px;
}

.form-container input[type="submit"] {
    width: 100%;
    padding: 10px;
    border: none;
    border-radius: 5px;
    background-color: #30A995; /* Background color */
    color: white; /* Text color */
    cursor: pointer;
}

.form-container input[type="submit"]:hover {
    background-color: #228B22; /* Hover color */
}

.form-container p {
    text-align: center;
    margin-top: 10px;
}

.form-container p a {
    color: #30A995; /* Link color */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .navbar-brand {
        font-size: 18px; /* Adjust font size */
        padding: 8px; /* Adjust padding */
    }

    .navbar-toggler {
        font-size: 16px; /* Adjust font size */
    }

    .form-container {
        padding: 15px; /* Adjust padding */
        margin: 10px; /* Adjust margin */
    }

    .form-container h2 {
        font-size: 28px; /* Adjust font size */
    }

    .form-container input[type="submit"] {
        padding: 12px; /* Adjust padding */
        font-size: 14px; /* Adjust font size */
    }
}

@media (max-width: 576px) {
    .navbar-brand {
        font-size: 16px; /* Further adjust font size */
        padding: 5px; /* Further adjust padding */
        white-space: normal; /* Allow text to wrap */
    }

    .navbar-toggler {
        font-size: 14px; /* Further adjust font size */
    }

    .form-container {
        padding: 10px; /* Further adjust padding */
        margin: 5px; /* Further adjust margin */
    }

    .form-container h2 {
        font-size: 20px; /* Further adjust font size */
    }

    .form-container input[type="submit"] {
        padding: 10px; /* Further adjust padding */
        font-size: 12px; /* Further adjust font size */
    }
}
/* Set body and html to be full height and use flexbox for layout */
html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Main content container with flex-grow to take available space */
.container {
    flex: 1; /* This makes the main content take the available space */
}

/* Footer styles adjusted */
footer {
    background-color: #343a40; /* Dark background for footer */
    color: white;
    padding: 20px 0; /* Padding for the footer */
    text-align: center;
    width: 100%;
    margin-top: 48px;
}

/* Ensuring footer stays at the bottom */
.footer-content {
    flex-shrink: 0; /* Prevents footer from shrinking */
}

.footer-links a {
    color: white; /* Footer link color */
    text-decoration: none; /* Remove underline */
}

.footer-links a:hover {
    text-decoration: underline; /* Add underline on hover */
}

.footer-social-icons a {
    margin-right: 10px; /* Space between social icons */
    color: white; /* Social icons color */
}

/* Footer specific media queries for better responsiveness */
@media (max-width: 768px) {
    footer {
        padding: 15px 0; /* Adjust padding on smaller screens */
        margin-top: 107px;
    }
}
/* Footer Animation Styles */
.footer {
    opacity: 0;
    animation: fadeIn 1s forwards;
}

.footer-section {
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 1s forwards;
}

/* Add subtle parallax effect on scroll */
.footer {
    background-attachment: fixed;
    background-size: cover;
    background-position: center;
}

/* Footer Links */
.footer-link {
    transition: color 0.3s ease, text-shadow 0.3s ease;
}

.footer-link:hover {
    color: #50B498;
    text-decoration: underline;
    text-shadow: 0 0 10px rgba(80, 180, 148, 0.5);
}

/* Footer Icons */
.footer-icon {
    transition: transform 0.3s ease, color 0.3s ease;
}

.footer-icon:hover {
    transform: scale(1.3) rotate(15deg); /* Add rotation for more dynamic effect */
    color: #50B498;
}

/* Footer Buttons */
.footer-button {
    transition: background-color 0.3s ease, border-color 0.3s ease, transform 0.3s ease;
}

.footer-button:hover {
    background-color: #40a88c;
    border-color: #40a88c;
    transform: scale(1.05); /* Slightly enlarge button on hover */
}

/* Footer Input Field */
.footer-input {
    border-radius: 0;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}

.footer-input:focus {
    border-color: #50B498;
    box-shadow: 0 0 5px rgba(80, 180, 148, 0.3); /* Add shadow effect on focus */
}

/* Keyframes for Animations */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Scroll Animation (AOS) */
[data-aos="fade-up"] {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

[data-aos="fade-up"].aos-animate {
    opacity: 1;
    transform: translateY(0);
}

/* Add a slight bounce effect on scroll */
[data-aos="bounce"] {
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

[data-aos="bounce"].aos-animate {
    opacity: 1;
    transform: translateY(0);
    animation: bounce 1s;
}

/* Keyframes for Bounce Animation */
@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-30px);
    }
    60% {
        transform: translateY(-15px);
    }
}
@media (max-width: 576px) {
    .footer {
        padding: 2rem 1rem;
    }
    .footer-section h5 {
        font-size: 1.25rem;
    }
    .footer-section p {
        font-size: 0.875rem;
    }
    .footer-button {
        width: 100%;
    }
}
.custom-button {
    background-color: #4CAF50; /* Green background */
    border: none; /* Remove border */
    color: white; /* White text */
    padding: 10px 20px; /* Smaller padding */
    text-align: center; /* Center text */
    text-decoration: none; /* Remove underline */
    display: inline-block; /* Inline-block */
    font-size: 14px; /* Smaller font size */
    margin: 2px 1px; /* Smaller margin */
    cursor: pointer; /* Pointer cursor on hover */
    border-radius: 4px; /* Rounded corners */
    width: 180px;
    height: 150px;
    margin-top: 200px;
}

.custom-button:hover {
    background-color: #45a049; /* Darker green on hover */
}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-md navbar-dark" style="background-color: #50B498; ">
    <a class="navbar-brand mx-auto" href="#">
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
<main>
    <!-- Login Form -->
    <div class="container form-container collapsed" id="loginForm">    
        <form action="login.php" method="post">
            <h2>Login</h2>
            
            <div class="form-group position-relative">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control pr-4" placeholder="Username" required>
                <i class="fas fa-user position-absolute icon-right" style="right: 10px; top: 70%; transform: translateY(-40%);"></i>
            </div>
            
            <div class="form-group position-relative">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control pr-4" placeholder="Password" required>
                <i class="fas fa-lock position-absolute icon-right" style="right: 10px; top: 55%; transform: translateY(-50%);"></i>
                <input type="checkbox" id="chk" onclick="togglePassword()"> Show password
            </div>
            
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
            <button type="submit" class="btn btn-block" style="background-color: #50B498; color: white;">Login</button>
            <p class="text-center mt-3">Don't have an account? <a href="registration.php">Register here</a>.</p>
        </form>
    </div>
</main>

<!-- Enhanced Footer Section -->
<footer class="bg-dark text-white py-5 footer">
    <div class="container">
        <div class="row text-center text-md-left">
            <!-- About Section -->
            <div class="col-md-3 mb-4 footer-section" data-aos="fade-up">
                <h5>About Us</h5>
                <p>
                    CBIT Inventory Management System provides robust solutions to manage your inventory efficiently. Our goal is to streamline operations and help you maintain optimal inventory levels for business success.
                </p>
            </div>

            <!-- Quick Links Section -->
            <div class="col-md-2 mb-4 footer-section" data-aos="fade-up" data-aos-delay="100">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-white footer-link">Home</a></li>
                    <li><a href="about_us.php" class="text-white footer-link">About Us</a></li>
                    <li><a href="contact_us.php" class="text-white footer-link">Contact Us</a></li>
                    <li><a href="faq.php" class="text-white footer-link">FAQ</a></li>
                    <li><a href="support.php" class="text-white footer-link">Support</a></li>
                </ul>
            </div>

            <!-- Customer Support Section -->
            <div class="col-md-3 mb-4 footer-section" data-aos="fade-up" data-aos-delay="200">
                <h5>Customer Support</h5>
                <p>
                    Need assistance? Our support team is here to help you 24/7. Reach out through our support page or directly contact us via phone or email.
                </p>
                <p>
                    <i class="fas fa-headset"></i> 24/7 Customer Support<br>
                    <i class="fas fa-phone-alt"></i> 09121604132<br>
                    <i class="fas fa-envelope"></i> <a href="mailto:support@inventorysystem.com" class="text-white footer-link">nimrodbanayag1@gmail.com</a>
                </p>
            </div>

            <!-- Social Media Links -->
            <div class="col-md-3 mb-4 footer-section" data-aos="fade-up" data-aos-delay="300">
                <h5>Follow Us</h5>
                <a href="https://facebook.com" class="text-white mr-3 footer-icon" target="_blank" data-aos="zoom-in" data-aos-delay="400">
                    <i class="fab fa-facebook fa-2x"></i>
                </a>
                <a href="https://twitter.com" class="text-white mr-3 footer-icon" target="_blank" data-aos="zoom-in" data-aos-delay="500">
                    <i class="fab fa-twitter fa-2x"></i>
                </a>
                <a href="https://instagram.com" class="text-white mr-3 footer-icon" target="_blank" data-aos="zoom-in" data-aos-delay="600">
                    <i class="fab fa-instagram fa-2x"></i>
                </a>
                <a href="https://linkedin.com" class="text-white footer-icon" target="_blank" data-aos="zoom-in" data-aos-delay="700">
                    <i class="fab fa-linkedin fa-2x"></i>
                </a>
            </div>
        </div>

        <!-- Additional Sections -->
        <div class="row mt-5">
            <!-- Recent Blog Posts Section -->
            <div class="col-md-4 mb-4 footer-section" data-aos="fade-up" data-aos-delay="800">
                <h5>Recent Blog Posts</h5>
                <ul class="list-unstyled">
                    <li><a href="blog_post1.php" class="text-white footer-link">How to Optimize Your Inventory Management</a></li>
                    <li><a href="blog_post2.php" class="text-white footer-link">Top 5 Features to Look for in an Inventory System</a></li>
                    <li><a href="blog_post3.php" class="text-white footer-link">Understanding Inventory Metrics: What You Need to Know</a></li>
                </ul>
            </div>

            <!-- Testimonials Section -->
            <div class="col-md-4 mb-4 footer-section" data-aos="fade-up" data-aos-delay="900">
                <h5>Testimonials</h5>
                <blockquote class="blockquote">
                    <p class="mb-0">"CBIT Inventory Management System has transformed the way we manage our inventory. It's user-friendly and efficient!"</p>
                    <footer class="blockquote-footer">Jane Doe, <cite title="Source Title">CEO of Tech Solutions</cite></footer>
                </blockquote>
                <blockquote class="blockquote">
                    <p class="mb-0">"The support team is exceptional. They resolved our queries quickly and helped us get the most out of the system."</p>
                    <footer class="blockquote-footer">John Smith, <cite title="Source Title">Operations Manager</cite></footer>
                </blockquote>
            </div>

            <!-- Contact Us Section -->
            <div class="col-md-4 mb-4 footer-section" data-aos="fade-up" data-aos-delay="1000">
                <h5>Contact Us</h5>
                <p>
                    Have questions or need further assistance? Reach out to us via the contact form on our website or through the following methods:
                </p>
                <p>
                    <i class="fas fa-map-marker-alt"></i> Brgy. De Oro Butuan City, 8600 Agusan del Norte Philippines.<br>
                    <i class="fas fa-phone-alt"></i> 09121604132<br>
                    <i class="fas fa-envelope"></i> <a href="nimrodbanayag1.com" class="text-white footer-link">nimrodbanayag1@gmail.com</a>
                </p>
                <a href="contact_us.php" class="btn btn-primary footer-button" style="background-color: #50B498; border-color: #50B498;">Contact Form</a>
            </div>
        </div>

        <!-- Newsletter Section -->
        <div class="row mt-5 justify-content-center">
            <div class="col-md-8 text-center footer-section" data-aos="fade-up" data-aos-delay="1100">
                <h5>Stay Updated with Our Newsletter</h5>
                <p>Subscribe to receive the latest updates, offers, and tips directly in your inbox. We promise not to spam you!</p>
                <form action="subscriber.php" method="post" class="form-inline justify-content-center">
                    <div class="input-group mb-3" style="max-width: 500px; width: 100%;">
                        <input type="email" name="email" class="form-control footer-input" placeholder="Enter your email address" aria-label="Recipient's email" aria-describedby="subscribeButton" required>
                        <div class="input-group-append">
                            <button class="btn btn-primary footer-button" type="submit" id="subscribeButton" style="background-color: #50B498; border-color: #50B498;">Subscribe</button>
                        </div>
                    </div>
                </form>
                <small class="text-muted">By subscribing, you agree to our <a href="privacy_policy.php" class="text-white">Privacy Policy</a>.</small>
            </div>
        </div>

        <!-- Operating Hours Section -->
        <div class="row mt-5">
            <div class="col-md-3 text-center text-md-left footer-section" data-aos="fade-up" data-aos-delay="1200">
                <h5>Operating Hours</h5>
                <p>Our team is available to assist you during the following hours:</p>
                <ul class="list-unstyled">
                    <li>Monday - Friday: 8:00 AM - 6:00 PM</li>
                    <li>Saturday: 9:00 AM - 12:00 NN</li>
                    <li>Sunday: Closed</li>
                </ul>
            </div>

            <!-- Location Map Section -->
            <div class="col-md-3 text-center text-md-left footer-section" data-aos="fade-up" data-aos-delay="1300">
                <h5>Our Location</h5>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3153.0914845230324!2d144.964873315317!3d-37.807998979751796!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f13d37f%3A0x5045675218ce6e0!2s123%20Main%20Street%2C%20Melbourne%20VIC%203000%2C%20Australia!5e0!3m2!1sen!2sus!4v1618706782945!5m2!1sen!2sus"
                    width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- Bottom Footer -->
        <div class="row mt-4">
            <div class="col-md-12 text-center footer-section" data-aos="fade-up" data-aos-delay="1400">
                <p>&copy; 2024 CBIT Inventory Management System. All rights reserved.</p>
                <p>
                    <a href="privacy_policy.php" class="text-white footer-link">Privacy Policy</a> |
                    <a href="terms_of_service.php" class="text-white footer-link">Terms of Service</a> |
                    <a href="sitemap.php" class="text-white footer-link">Sitemap</a>
                </p>
            </div>
        </div>
    </div>

</footer>

<!-- FontAwesome for Social Media Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
    const formContainer = document.getElementById('loginForm');

    formContainer.addEventListener('click', function() {
        formContainer.classList.remove('collapsed');
        formContainer.classList.add('expanded');
    });

    document.addEventListener('click', function(event) {
        if (!formContainer.contains(event.target)) {
            formContainer.classList.add('collapsed');
            formContainer.classList.remove('expanded');
        }
    });
</script>
<script>

    const password =document.getElementById("password");
    const chk =document.getElementById("chk");

    chk.onchange = function(e) {
        password.type = chk.checked? "text" : "password";
    };
</script>

  
</body>
</html>