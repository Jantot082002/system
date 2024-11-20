<?php
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

$query = $_GET['query'];
$sql = "SELECT * FROM products WHERE product_name LIKE '%" . $conn->real_escape_string($query) . "%'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-start">'; // Flexbox for mobile responsiveness

        // Display the product details
        echo '<div class="product-details" style="flex-grow: 1; margin-bottom: 10px;">'; // Margin for spacing on mobile
        echo '<h5 class="mb-1" style="font-size: 1.5em; font-weight: bold;">' . htmlspecialchars($row['product_name']) . '</h5>'; // Larger font for product name
        echo '<p class="mb-1">Category: ' . htmlspecialchars($row['category']) . '</p>';
        echo '<p class="mb-1">Price: ' . htmlspecialchars($row['price']) . '</p>';
        echo '<p class="mb-1">Supplier: ' . htmlspecialchars($row['supplier']) . '</p>';
        echo '<p class="mb-1">Row: ' . htmlspecialchars($row['row_number']) . '</p>';
        echo '<p class="mb-1">Column: ' . htmlspecialchars($row['column_number']) . '</p>';
        echo '<p class="mb-1">Quantity: ' . htmlspecialchars($row['quantity']) . '</p>';
        echo '<p class="mb-1">Warehouse: ' . htmlspecialchars($row['warehouse']) . '</p>';
        echo '<p class="mb-1">Expiration Date: ' . htmlspecialchars($row['expiration_date']) . '</p>';

        // Buttons
        echo '<div class="btn-group" role="group">';
        echo '<button class="btn btn-sm" style="background-color: #4b9a7f; color: white;" onclick="openEditModal(' 
            . htmlspecialchars($row['id']) . ', \'' 
            . htmlspecialchars($row['product_name']) . '\', \'' 
            . htmlspecialchars($row['category']) . '\', \'' 
            . htmlspecialchars($row['price']) . '\', \'' 
            . htmlspecialchars($row['supplier']) . '\', \'' 
            . htmlspecialchars($row['warehouse']) . '\', ' 
            . htmlspecialchars($row['row_number']) . ', ' 
            . htmlspecialchars($row['column_number']) . ', ' 
            . htmlspecialchars($row['quantity']) . ', \'' 
            . htmlspecialchars($row['expiration_date']) . '\')">Edit</button>';

        // Delete button
        echo '<button onclick="deleteProduct(' . htmlspecialchars($row['id']) . ')" class="btn btn-sm btn-danger" style="margin-left: 10px;">Delete</button>';

        // Add Image button
        echo '<button class="btn btn-sm" style="background-color: #4b9a7f; color: white; margin-left: 10px;" onclick="openImageUploadModal(' . htmlspecialchars($row['id']) . ')">Add Image</button>';
        echo '</div>'; // Close button group div

        echo '</div>'; // Close product details div

        // Display the product image if it exists
        if (!empty($row['image'])) {
            echo '<img src="' . htmlspecialchars($row['image']) . '" alt="Product Image" class="img-fluid" style="max-width: 200px; height: auto; margin-left: 10px;">';
        } else {
            echo '<p style="margin-left: 10px;">No image available.</p>';
        }

        echo '</div>'; // Close list group item div
    }
} else {
    echo '<p>No products found.</p>';
}

$conn->close();
?>
