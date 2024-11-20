<?php
// delete_user.php

$conn = new mysqli('localhost', 'root', '', 'inventoryproj');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user ID is provided
    if (isset($_POST['user_id'])) {
        $user_id = intval($_POST['user_id']);

        // Prepare and execute the delete statement
        $stmt = $conn->prepare("DELETE FROM registration WHERE id = ?");
        $stmt->bind_param("i", $user_id);

        if ($stmt->execute()) {
            // Redirect or display a success message
            header("Location: Manage_users.php?message=User deleted successfully");
            exit();
        } else {
            // Handle error
            echo "Error deleting user: " . $stmt->error;
        }
        
        $stmt->close();
    }
}

$conn->close();
?>
