<?php
if (isset($_GET['id'])) {
    $borrowerId = $_GET['id'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM borrowers WHERE id = ?");
    $stmt->bind_param("i", $borrowerId);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    echo json_encode($data);

    $stmt->close();
    $conn->close();
}
?>