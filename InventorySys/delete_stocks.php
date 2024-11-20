<?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the ID is provided
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();

// Redirect back to the main page or display a message
header("Location: stock.php"); // Replace with the URL of your main page
exit();
?>