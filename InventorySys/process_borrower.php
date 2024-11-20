<?php
// process_borrower.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrowerId = $_POST['borrowerId'];
    $productId = $_POST['productId'];
    $quantity = $_POST['quantity'];
    $borrowDate = $_POST['borrowDate'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Sanitize input
    $borrowerId = $conn->real_escape_string($borrowerId);
    $productId = $conn->real_escape_string($productId);
    $quantity = $conn->real_escape_string($quantity);
    $borrowDate = $conn->real_escape_string($borrowDate);

    // Check if the borrower ID exists in the borrowers table and fetch the type
    $sql = "SELECT id, type FROM borrowers WHERE student_id = '$borrowerId' OR employee_id = '$borrowerId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "<script>alert('Invalid borrower ID.'); window.location.href='borrow_item.php';</script>";
        $conn->close();
        exit();
    }

    // Get borrower type and correct borrower ID
    $borrowerRow = $result->fetch_assoc();
    $actualBorrowerId = $borrowerRow['id'];
    $borrowerType = $borrowerRow['type'];

    // Check if the product ID exists and fetch the current quantity
    $sql = "SELECT quantity FROM products WHERE id = '$productId'";
    $result = $conn->query($sql);

    if ($result->num_rows == 0) {
        echo "<script>alert('Invalid product ID.'); window.location.href='borrow_item.php';</script>";
        $conn->close();
        exit();
    }

    $productRow = $result->fetch_assoc();
    $currentQuantity = $productRow['quantity'];

    // Check if enough quantity is available
    if ($currentQuantity < $quantity) {
        echo "<script>alert('Not enough quantity available.'); window.location.href='borrow_item.php';</script>";
        $conn->close();
        exit();
    }

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Insert borrow record into the database
        $sql = "INSERT INTO borrow_records (borrower_id, borrower_type, product_id, quantity, borrow_date)
                VALUES ('$actualBorrowerId', '$borrowerType', '$productId', '$quantity', '$borrowDate')";
        if (!$conn->query($sql)) {
            throw new Exception("Error inserting borrow record: " . $conn->error);
        }

        // Deduct the quantity from the products table
        $sql = "UPDATE products SET quantity = quantity - '$quantity' WHERE id = '$productId'";
        if (!$conn->query($sql)) {
            throw new Exception("Error updating product quantity: " . $conn->error);
        }

        // Commit the transaction
        $conn->commit();
        echo "<script>alert('Record added successfully'); window.location.href='borrow_item.php';</script>";

    } catch (Exception $e) {
        // Rollback the transaction in case of error
        $conn->rollback();
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.location.href='borrow_item.php';</script>";
    }

    $conn->close();
}
?>