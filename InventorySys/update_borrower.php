<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrowerId = $_POST['borrowerId'];
    $borrowerName = $_POST['borrowerName'];
    $borrowerType = $_POST['borrowerType'];
    $borrowerEmail = $_POST['borrowerEmail'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $stmt = $conn->prepare("UPDATE borrowers SET name = ?, type = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssi", $borrowerName, $borrowerType, $borrowerEmail, $borrowerId);
    if ($stmt->execute()) {
        echo "Borrower updated successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>