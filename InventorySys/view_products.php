<?php

session_start(); // Start the session to access user role
header('Content-Type: text/html; charset=utf-8');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Get the selected warehouse from the query string
$warehouseFilter = isset($_GET['warehouse']) ? $_GET['warehouse'] : '';

// Fetch all products (excluding expired ones), ordered by created_at (FIFO)
$sql = "SELECT * FROM products WHERE expiration_date >= CURDATE()"; // Only non-expired products
if (!empty($warehouseFilter)) {
    $sql .= " AND warehouse = ?";
}
$sql .= " ORDER BY created_at ASC"; // FIFO order
$stmt = $conn->prepare($sql);
if (!empty($warehouseFilter)) {
    $stmt->bind_param('s', $warehouseFilter);
}
$stmt->execute();
$result = $stmt->get_result();

// Fetch expired products based on expiration date
$expiredSql = "SELECT * FROM products WHERE expiration_date < CURDATE()";
if (!empty($warehouseFilter)) {
    $expiredSql .= " AND warehouse = ?";
}
$expiredSql .= " ORDER BY expiration_date ASC"; // FIFO order for expired products
$expiredStmt = $conn->prepare($expiredSql);
if (!empty($warehouseFilter)) {
    $expiredStmt->bind_param('s', $warehouseFilter);
}
$expiredStmt->execute();
$expiredResult = $expiredStmt->get_result();


echo '<h2>Products</h2>';
if ($result->num_rows > 0) {
    echo '<div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Supplier</th>
                        <th>Warehouse</th>
                        <th>Row</th>
                        <th>Column</th>
                        <th>Current Quantity</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Expiration Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>';
    while ($row = $result->fetch_assoc()) {
        // Determine color based on current quantity
        $quantity = $row['quantity'];
        if ($quantity > 50) {
            $statusColor = 'green';
            $statusText = 'In Stock';
        } elseif ($quantity > 1) {
            $statusColor = 'orange';
            $statusText = 'Low Stock';
        } else {
            $statusColor = 'red';
            $statusText = 'Out of Stock';
        }

        echo '<tr>
                <td>' . htmlspecialchars($row['product_name']) . '</td>
                <td>' . htmlspecialchars($row['category']) . '</td>
                <td>' . htmlspecialchars($row['price']) . '</td>
                <td>' . htmlspecialchars($row['supplier']) . '</td>
                <td>' . htmlspecialchars($row['warehouse']) . '</td>
                <td>' . htmlspecialchars($row['row_number']) . '</td>
                <td>' . htmlspecialchars($row['column_number']) . '</td>
                <td>' . htmlspecialchars($row['quantity']) . '</td>
                <td style="color: ' . $statusColor . ';">' . $statusText . '</td>
                <td>' . htmlspecialchars($row['created_at']) . '</td>
                <td>' . htmlspecialchars($row['expiration_date']) . '</td>
                <td>';

        // Check if the user is an admin before showing action buttons
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
            echo '<button class="btn btn-sm" style="background-color: #4b9a7f; color:white;" onclick="openEditModal(' . htmlspecialchars($row['id']) . ', \'' . htmlspecialchars($row['product_name']) . '\', \'' . htmlspecialchars($row['category']) . '\', \'' . htmlspecialchars($row['price']) . '\', \'' . htmlspecialchars($row['supplier']) . '\', \'' . htmlspecialchars($row['warehouse']) . '\', ' . htmlspecialchars($row['row_number']) . ', ' . htmlspecialchars($row['column_number']) . ', ' . htmlspecialchars($row['quantity']) . ', \'' . htmlspecialchars($row['expiration_date']) . '\')">Edit</button>
                  <button class="btn btn-danger btn-sm" onclick="deleteProduct(' . $row['id'] . ')">Delete</button>';
        } else {
            echo 'No actions available';
        }

        echo '</td>
            </tr>';
    }
    echo '  </tbody>
         </table>
         </div>';
} else {
    echo '<p>No products found.</p>';
}
echo '<form method="post" action="generate_pdf.php">
        <button type="submit" name="generate_pdf" class="btn"  style="background-color: #50B498; color: white; ">Generate PDF</button>
      </form>';

echo '<h2>Expired Products</h2>';
if ($expiredResult->num_rows > 0) {
    echo '<div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Unit Price</th>
                        <th>Supplier</th>
                        <th>Warehouse</th>
                        <th>Row</th>
                        <th>Column</th>
                        <th>Current Quantity</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Expiration Date</th>
                    </tr>
                </thead>
                <tbody>';
    while ($row = $expiredResult->fetch_assoc()) {
        echo '<tr>
                <td>' . htmlspecialchars($row['product_name']) . '</td>
                <td>' . htmlspecialchars($row['category']) . '</td>
                <td>' . htmlspecialchars($row['price']) . '</td>
                <td>' . htmlspecialchars($row['supplier']) . '</td>
                <td>' . htmlspecialchars($row['warehouse']) . '</td>
                <td>' . htmlspecialchars($row['row_number']) . '</td>
                <td>' . htmlspecialchars($row['column_number']) . '</td>
                <td>' . htmlspecialchars($row['quantity']) . '</td>
                <td style="color: red;">Expired</td>
                <td>' . htmlspecialchars($row['created_at']) . '</td>
                <td>' . htmlspecialchars($row['expiration_date']) . '</td>
            </tr>';
    }
    echo '  </tbody>
         </table>
         </div>';
} else {
    echo '<p>No expired products found.</p>';
}

?>
