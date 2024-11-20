<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrowerId = $_POST['id'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("DELETE FROM borrowers WHERE id = ?");
    $stmt->bind_param("i", $borrowerId);
    if ($stmt->execute()) {
        echo "Borrower deleted successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>