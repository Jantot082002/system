

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
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
    margin-top: -8px;
}

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
    margin-bottom: 20px;
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

.navbar-brand {
    font-weight: bold; 
    font-family: 'Arial', sans-serif; 
    font-size: 24px; 
    font-style: oblique; 
    text-align: center; 
    flex: 1; 
    letter-spacing: 1px; 
    line-height: 1.2; 
    text-transform: uppercase; 
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3); 
    color: #ffffff; 
    background-color: #50B498;
}

/* Custom button styles */
.btn-custom {
    background-color: #50B498; /* Button color */
    color: white;
}

.btn-custom:hover {
    background-color:#50B499; /* Hover color */
}

/* Password field container */
.password-container {
    position: relative;
}

.password-field {
    position: relative;
}

.password-field input {
    padding-right: 30px; /* Add space for the icon */
}

.password-toggle-icon {
    position: absolute;
    right: 10px;
    top: 75%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
    color: #50B498;
    z-index: 2; /* Ensure the icon is above the input field */
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .navbar-brand {
        font-size: 20px; /* Adjust font size for medium screens */
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
        font-size: 18px; /* Further adjust font size */
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
        font-size: 22px; /* Further adjust font size */
    }

    .form-container input[type="submit"] {
        padding: 10px; /* Further adjust padding */
        font-size: 12px; /* Further adjust font size */
    }

    .password-toggle-icon {
        font-size: 16px; /* Adjust icon size for small screens */
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

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #50B498;">
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

   
    <div class="container form-container">    
        <form action="registration.php" method="post">
            <h1>Register</h1>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" class="form-control" placeholder="Username" required>
            </div>
            <div class="form-group password-container">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
                <i class="fas fa-eye password-toggle-icon" id="togglePassword"></i>
            </div>
            <div class="form-group password-container">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                <i class="fas fa-eye password-toggle-icon" id="toggleConfirmPassword"></i>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <select id="role" name="role" class="form-control" required>
                    <option value="admin">Admin</option>
                    <option value="user">User</option>
                </select>
            </div>
       <button type="submit" class="btn btn-custom btn-block" style="background-color: #50B498; color: white;">Register</button>
            <p class="text-center mt-3">Done Registering? <a href="login.php">Login here</a>.</p>
        </form>
    </div>
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
                    <i class="fas fa-map-marker-alt"></i> Brgy. De Oro Butuan City ,8600 Agusan del Norte Philippines.<br>
                    <i class="fas fa-phone-alt"></i> 09121604132<br>
                    <i class="fas fa-envelope"></i> <a href="mailto:info@inventorysystem.com" class="text-white footer-link">nimrodbanayag1@gmail.com</a>
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
        const passwordInput = document.getElementById('password');
        const confirmInput = document.getElementById('confirm_password');
        const togglePassword = document.getElementById('togglePassword');
        const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');

        togglePassword.addEventListener('click', function() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                togglePassword.classList.remove('fa-eye');
                togglePassword.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                togglePassword.classList.remove('fa-eye-slash');
                togglePassword.classList.add('fa-eye');
            }
        });

        toggleConfirmPassword.addEventListener('click', function() {
            if (confirmInput.type === 'password') {
                confirmInput.type = 'text';
                toggleConfirmPassword.classList.remove('fa-eye');
                toggleConfirmPassword.classList.add('fa-eye-slash');
            } else {
                confirmInput.type = 'password';
                toggleConfirmPassword.classList.remove('fa-eye-slash');
                toggleConfirmPassword.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>

<?php
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password']) && isset($_POST['role']) && isset($_POST['email'])) {
    // Get form input values
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];
    $email = $_POST['email'];

    // Validate password confirmation
    if ($password !== $confirm_password) {
        echo '<script>alert("Passwords do not match!");</script>';
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    } else {
        // Prepare SQL statement to check if the email or username already exists
        $stmt_check = $conn->prepare("SELECT * FROM registration WHERE email = ? OR username = ?");
        $stmt_check->bind_param("ss", $email, $username);
        $stmt_check->execute();
        $result = $stmt_check->get_result();

        if ($result->num_rows > 0) {
            echo '<script>alert("Username or Email already exists!");</script>';
        } else {
            // Check if an admin already exists
            $stmt_admin_check = $conn->prepare("SELECT * FROM registration WHERE role = 'admin'");
            $stmt_admin_check->execute();
            $admin_result = $stmt_admin_check->get_result();

            if ($role === 'admin' && $admin_result->num_rows > 0) {
                echo '<script>alert("An admin already exists!");</script>';
            } else {
                // Insert new user into the database
                $stmt_insert = $conn->prepare("INSERT INTO registration (username, password, email, role) VALUES (?, ?, ?, ?)");
                $stmt_insert->bind_param("ssss", $username, $hashed_password, $email, $role);
                if ($stmt_insert->execute()) {
                    echo '<script>alert("Registration successful!"); window.location.href = "login.php";</script>';
                } else {
                    echo '<script>alert("Registration failed!");</script>';
                }
            }

            // Close the admin check statement
            $stmt_admin_check->close();
        }

        // Close statements and connection
        $stmt_check->close();
        $stmt_insert->close();
        $conn->close();
    }
}
?>
