<?php
header('Content-Type: application/json; charset=utf-8');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die(json_encode(['error' => 'Connection Failed: ' . $conn->connect_error]));
}

// Get the product ID from the query string
$productId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $product = $result->fetch_assoc();
    echo json_encode($product);
} else {
    echo json_encode(['error' => 'Product not found.']);
}

$conn->close();
?>
