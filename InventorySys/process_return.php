<?php
// Connect to the database
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$borrowerId = $_POST['borrowerId'];
$productId = $_POST['productId'];
$quantity = $_POST['quantity'];
$returnDate = $_POST['returnDate'];

// Check if borrower exists
$checkBorrowerSql = "SELECT id FROM borrowers WHERE id = ?";
$stmt = $conn->prepare($checkBorrowerSql);
$stmt->bind_param("i", $borrowerId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Error: Borrower ID does not exist.";
    $stmt->close();
    $conn->close();
    exit();
}

// Begin transaction
$conn->begin_transaction();

try {
    // Insert the return record into borrow_records
    $sql = "INSERT INTO borrow_records (borrower_id, product_id, quantity, return_date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("siis", $borrowerId, $productId, $quantity, $returnDate);
    $stmt->execute();

    // Update the product quantity in the products table
    $updateProductSql = "UPDATE products SET quantity = quantity + ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateProductSql);
    $updateStmt->bind_param("ii", $quantity, $productId);
    $updateStmt->execute();

    // Commit transaction
    $conn->commit();

    // Redirect back to the return item page after successful update
    header("Location: return_item.php");

} catch (Exception $e) {
    // Rollback transaction if something goes wrong
    $conn->rollback();
    echo "Error: " . $e->getMessage();
}

// Close the statement and connection
$stmt->close();
$updateStmt->close();
$conn->close();
?>