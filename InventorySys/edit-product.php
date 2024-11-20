

<?php
header('Content-Type: text/html; charset=utf-8');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch product details for editing
if (!isset($_GET['id'])) {
    echo "Product ID is missing.";
    exit;
}

$productId = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "Product not found.";
    exit;
}

// Update product if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['product_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $supplier = $_POST['supplier'];
    $warehouse = $_POST['warehouse'];
    $rowNumber = $_POST['row_number'];
    $columnNumber = $_POST['column_number'];
    $quantity = $_POST['quantity'];
    $expirationDate = $_POST['expiration_date'];

    $updateSql = "UPDATE products SET product_name = ?, category = ?, price = ?, supplier = ?, warehouse = ?, row_number = ?, column_number = ?, quantity = ?, expiration_date = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('ssdsdiiiss', $productName, $category, $price, $supplier, $warehouse, $rowNumber, $columnNumber, $quantity, $expirationDate, $productId);

    $stmt->execute();

    // Redirect back to the products page
    header('Location: products.php');
    exit;
}
?>

