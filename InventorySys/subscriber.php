<?php
// subscribe.php

// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email from the form
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    // Validate the email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Invalid email format
        echo "<script>alert('Invalid email address.'); window.location.href = 'login.php';</script>";
        exit;
    }

    // Prepare SQL query to check if email already exists
    $checkQuery = "SELECT id FROM subscribers WHERE email = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Email already subscribed
        echo "<script>alert('You are already subscribed.'); window.location.href = 'login.php';</script>";
    } else {
        // Insert the email into the subscribers table
        $insertQuery = "INSERT INTO subscribers (email, subscribed_at) VALUES (?, NOW())";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
            // Successful subscription
            echo "<script>alert('Thank you for subscribing!'); window.location.href = 'login.php';</script>";
        } else {
            // Error handling
            echo "<script>alert('There was an error. Please try again later.'); window.location.href = 'login.php';</script>";
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: login.php");
    exit;
}
?>