<?php
if (isset($_GET['SupplierID'])) {
    $SupplierID = $_GET['SupplierID'];
    
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch products based on the supplier ID
    $sql = "SELECT id, product_name FROM products WHERE SupplierID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $SupplierID);
    $stmt->execute();
    $result = $stmt->get_result();

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $stmt->close();
    $conn->close();

    // Return the products as JSON
    echo json_encode($products);
}
?>
