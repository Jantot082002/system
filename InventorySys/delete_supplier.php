
<?php
session_start();


$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $id = intval($_GET['SupplierID']);
    $stmt = $conn->prepare("DELETE FROM suppliers WHERE SupplierID = ?");
    $stmt->bind_param("i", $SupplierID);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Supplier deleted successfully."]);
    } else {
        http_response_code(500);
        echo json_encode(["message" => "Failed to delete supplier."]);
    }

    $stmt->close();
}

$conn->close();
?>