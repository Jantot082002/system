<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryName = $_POST['categoryName'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Prepare and execute SQL statement
    $stmt = $conn->prepare("INSERT INTO categories (category_name) VALUES (?)");
    $stmt->bind_param("s", $categoryName);

    if ($stmt->execute()) {
        header('Location: Categories.php'); // Redirect to Categories.php
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>