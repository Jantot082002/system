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

// Fetch supplier names and contact information
$sql = "SELECT SupplierName, SupplierContact FROM suppliers";
$result = $conn->query($sql);

$suppliers = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $suppliers[] = [
            'SupplierName' => $row['SupplierName'],
            'SupplierContact' => $row['SupplierContact']
        ];
    }
}

// Return JSON
header('Content-Type: application/json');
echo json_encode($suppliers);

$conn->close();
?>