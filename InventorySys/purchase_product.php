<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idnumber = $_POST['idnumber'];
    $productName = $_POST['purchaseProductName'];
    $quantity = $_POST['purchaseQuantity'];
    $purchaseDate = $_POST['purchaseDate'];
    $discount = $_POST['discount'];
    $paymentMethod = $_POST['paymentMethod'];

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Fetch product ID and unit price from products table
    $sql = "SELECT id, price, quantity FROM products WHERE product_name = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $productName);
    $stmt->execute();
    $stmt->bind_result($productId, $unitPrice, $currentQuantity);
    $stmt->fetch();
    $stmt->close();

    if ($productId) {
        if ($quantity > $currentQuantity) {
            // Quantity to purchase exceeds available stock
            echo "<script>alert('Insufficient stock available!'); window.location.href='purchase_form.php';</script>";
        } else {
            // Generate a unique purchase code
            $purchaseCode = 'PUR-' . $productId . '-' . time() . '-' . rand(1000, 9999);

            // Calculate total price
            $totalPrice = ($unitPrice * $quantity) * (1 - $discount / 100);

            // Insert purchase details into purchase_items table
            $sql = "INSERT INTO purchase_items (idnumber, purchase_code, product_id, product_name, quantity, unit_price, total_price, discount, payment_method, purchase_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssisiddsss', $idnumber, $purchaseCode, $productId, $productName, $quantity, $unitPrice, $totalPrice, $discount, $paymentMethod, $purchaseDate);

            if ($stmt->execute()) {
                $purchaseId = $conn->insert_id; // Get the last inserted ID

                // Check if purchaseId is valid
                if ($purchaseId > 0) {
                    // Update product quantity in the products table
                    $sql = "UPDATE products SET quantity = quantity - ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('ii', $quantity, $productId);
                    $stmt->execute();
                    $stmt->close();

                    // Redirect to the invoice page with the purchase ID
                    header("Location: invoice.php?id=" . $purchaseId);
                    exit();
                } else {
                    // Log or display an error if $purchaseId is invalid
                    echo "<script>alert('Error: Invalid purchase ID.'); window.location.href='purchase.php';</script>";
                }
            } else {
                // Error alert
                echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='purchase.php';</script>";
            }

            $stmt->close();
        }
    } else {
        // Product not found alert
        echo "<script>alert('Product not found!'); window.location.href='purchase.php';</script>";
    }

    $conn->close();
}
?>