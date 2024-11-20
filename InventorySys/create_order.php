<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $supplier_id = $_POST['supplier_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];
    $delivery_duration = $_POST['delivery_duration'];

    $stmt = $conn->prepare("INSERT INTO orders (supplier_id, product_name, quantity, order_date, status, delivery_duration) VALUES (?, ?, ?, NOW(), 'Pending', ?)");
    $stmt->bind_param("isii", $supplier_id, $product_name, $quantity, $delivery_duration);

    if ($stmt->execute()) {
        // Redirect with success status
        header("Location: order.php?status=success");
    } else {
        // Redirect with error status
        header("Location: order.php?status=error");
    }

    $stmt->close();
    $conn->close();
}
?>