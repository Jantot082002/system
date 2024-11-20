<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $order_id = intval($_POST['order_id']);
    $received_date = $_POST['received_date'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Update the order to mark it as received
    $sql = "UPDATE orders SET received_date = ?, status = 'Received' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param('si', $received_date, $order_id);

    if ($stmt->execute()) {
        // Redirect after successful execution
        header("Location: order.php");
        exit();
    } else {
        // Print the SQL error message for debugging
        die("Error: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
?>