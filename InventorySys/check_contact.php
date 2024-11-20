<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed: " . $conn->connect_error]));
}

// Read the input
$input = file_get_contents('php://input');
error_log("Received input: " . $input); // Log input for debugging

$data = json_decode($input, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    die(json_encode(["error" => "Invalid JSON input: " . json_last_error_msg()]));
}

if (isset($data['contact'])) {
    $contact = $data['contact'];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM suppliers WHERE SupplierContact = ?");
    $stmt->bind_param("s", $contact);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();

    echo json_encode(["exists" => $count > 0]);
    $stmt->close();
} else {
    echo json_encode(["error" => "Missing contact parameter."]);
}

$conn->close();
