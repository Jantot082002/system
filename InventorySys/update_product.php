<?php
header('Content-Type: application/json');
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Connection Failed: ' . $conn->connect_error]);
    exit;
}

$productId = $_POST['id'] ?? null;
$productName = $_POST['product_name'] ?? null;
$productPrice = $_POST['price'] ?? null;
$productWarehouse = $_POST['warehouse'] ?? null;
$productExpiration = $_POST['expiration_date'] ?? null;

if (!$productId || !$productName || !$productPrice || !$productWarehouse) {
    echo json_encode(['success' => false, 'message' => 'Missing required fields.']);
    exit;
}

$sql = "UPDATE products SET product_name = ?, price = ?, warehouse = ?, expiration_date = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Prepare failed: ' . $conn->error]);
    exit;
}

if (!$stmt->bind_param('sdssi', $productName, $productPrice, $productWarehouse, $productExpiration, $productId)) {
    echo json_encode(['success' => false, 'message' => 'Binding parameters failed: ' . $stmt->error]);
    exit;
}

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Product updated successfully!']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to update product: ' . $stmt->error]);
}

$stmt->close();
$conn->close();

?>
