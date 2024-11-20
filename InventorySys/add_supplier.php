<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "inventoryproj";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$supplierName = $_POST['supplierName'];
$supplierContact = $_POST['supplierContact'];

// Check for existing supplier contact
$sql = "SELECT COUNT(*) AS count FROM suppliers WHERE SupplierContact = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $supplierContact);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    // Contact already exists
    echo "<script>alert('Supplier contact already exists.'); window.location.href = 'Supplier.php';</script>";
} else {
    // Insert new supplier
    $sql = "INSERT INTO suppliers (SupplierName, SupplierContact) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $supplierName, $supplierContact);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Supplier added successfully.'); window.location.href = 'Supplier.php';</script>";
    } else {
        echo "<script>alert('Error adding supplier.'); window.location.href = 'Supplier.php';</script>";
    }
}

$stmt->close();
$conn->close();
?>