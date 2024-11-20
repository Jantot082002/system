<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Check if 'id' parameter is set in the URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $itemId = $_GET['id'];

    // Prepare the DELETE statement
    $stmt = $conn->prepare("DELETE FROM purchase_items WHERE id = ?");
    $stmt->bind_param("i", $itemId);

    // Execute the query and check for errors
    if ($stmt->execute()) {
        // Redirect back to the page displaying purchased items with a success message
        header("Location: purchase.php?message=Item+deleted+successfully"); // Adjust the redirect URL as necessary
    } else {
        // Redirect back with an error message if the deletion fails
        header("Location:purchase.php?error=Failed+to+delete+item");
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Redirect back with an error message if 'id' is not set
    header("Location: purchase.php?error=Invalid+request");
}
exit();
?>