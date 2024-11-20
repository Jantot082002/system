<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            overflow-x: hidden;
        }
        .sidebar {
            height: 100vh;
           width: 230px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #50B498;
            border-right: 1px solid #50B498;
            box-shadow: 4px 0 8px rgba(0, 0, 0, 0.1);
        }
        .sidebar-heading {
            text-align: center;
            padding-bottom: 0px;
        }
        .sidebar-logo {
            width: 320px;
            height: 250px;
            margin-left: -65px;
           margin-top: -90px;
        }
        .sidebar .list-group-item {
            border-radius: 0;
            background-color: #50B498;
            color: #fff;
        }
        .sidebar .list-group-item:hover {
            background-color: #4a9b8e;
            color: #fff;
        }
        .main-content {
            margin-left: 250px; 
            padding: 20px;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-right: none;
            }
            .main-content {
                margin-left: 0;
            }
        }
  .navbar-brand {
    font-weight: bold;
    font-family: 'Arial', sans-serif;
    font-size: 24px;
    font-style: oblique;
    text-align: center;
    flex: 1;
    letter-spacing: 1px;
    line-height: 1.2;
    text-transform: uppercase;
    text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
    color: #ffffff;
    background-color: #50B498;
    padding: 10px;
    margin-left: 230px;
}

@media (max-width: 768px) {
    .navbar-brand {
        margin-left: 0;
        margin-right: 0;
        font-size: 18px; /* Reduce font size on mobile */
        padding: 5px; /* Adjust padding */
        width: 100%; /* Ensure it spans the full width */
    }
}
  
        .card-box {
            margin-bottom: 20px;
            text-align: center;
        }
        .card-box .card-body {
            padding: 20px;
        }
        @media (min-width: 768px) {
    #productList {
        padding-left: 15px;
        padding-right: 15px;
         margin-left: 220px;
    }
}

@media (max-width: 767.98px) {
    #productContainer {
        padding: 0;

    }
}
@media (max-width: 767.98px) {
    .button-section .form-group {
        margin-bottom: 1rem;
    }

    .form-control {
        font-size: 0.875rem; /* Adjust font size for better fit on small screens */
    }
}

@media (min-width: 768px) {
    .form-control {
        font-size: 1rem; /* Standard font size for larger screens */
    }
}
  .invoice-link {
    background-color: #50B498;
    color: white;
    padding: 8px 16px;
    border-radius: 5px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s ease;
    margin-right: 15px;
}

.invoice-link:hover {
    background-color: #3e8b7a;
    text-decoration: none;
    color: white;
} 

    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-md navbar-dark" style="background-color: #50B498;">
        <a class="navbar-brand" href="#">Inventory Management System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="navbar-text">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </li>
                <li class="nav-item">
                   <b> <a class="nav-link" href="Login.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

<!-- Sidebar and Main Content -->
<div class="container-fluid">
  <div class="row">
    <div class="sidebar">
      <div class="sidebar-heading">
        <img src="founded.png" class="sidebar-logo" alt="Sidebar Logo">
      </div>
     <div class="list-group list-group-flush">
                    <a href="Dashboard.php" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
                    <a href="Product.php" class="list-group-item list-group-item-action"><i class="fas fa-box"></i> Products</a>
                    <a href="Categories.php" class="list-group-item list-group-item-action"><i class="fas fa-tags"></i> Categories</a>
                    <a href="Supplier.php" class="list-group-item list-group-item-action"><i class="fas fa-truck"></i> Suppliers</a>
                    <a href="#borrowerSubMenu" class="list-group-item list-group-item-action" data-toggle="collapse"><i class="fas fa-user-friends"></i> Borrow</a>
                      <div id="borrowerSubMenu" class="collapse">
                         <a href="borrower.php" class="list-group-item list-group-item-action pl-4"><i class="fas fa-user"></i> 
                         Submit Details</a>
                        <a href="borrow_item.php" class="list-group-item list-group-item-action pl-4"><i class="fas fa-hand-holding"></i> Borrow Item</a>
                       
                          <!--   <a href="purchase.php" class="list-group-item list-group-item-action pl-4">
                          <i class="fas fa-shopping-cart"></i> Purchase Item
                        </a> -->
                    </div>
                    <a href="Account.php" class="list-group-item list-group-item-action"><i class="fas fa-user-circle"></i> Account</a>
                    <a href="Order.php" class="list-group-item list-group-item-action"><i class="fas fa-shopping-cart"></i> Order</a>
                    <a href="stock.php" class="list-group-item list-group-item-action"><i class="fas fa-warehouse"></i> Stock</a>
                      <?php if ($_SESSION['role'] === 'admin'): ?> <!-- Check if the user is an admin -->
                    <a href="Manage_users.php" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Manage User</a>
                <?php endif; ?>> 
                </div>
    </div>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
 
    <!-- Purchase Product Form -->
      <div class="d-flex justify-content-between align-items-center mb-3">
               <h3><b>Purchase Product</b></h3>
            <a href="invoice.php" class="invoice-link">Invoice</a>
        </div>
    <div class="container mt-4" id="purchaseProductForm">
        <form id="purchaseForm" method="post" action="purchase_product.php">
             <div class="form-group">
        <label for="idnumber">ID Number</label>
        <input type="text" class="form-control" id="idnumber" name="idnumber" placeholder="Enter ID number" required>
    </div>
    <div class="form-group">
        <label for="purchaseProductName">Product Name</label>
        <input type="text" class="form-control" id="purchaseProductName" name="purchaseProductName" placeholder="Enter product name" required>
    </div>
    <div class="form-group">
        <label for="purchaseQuantity">Quantity</label>
        <input type="number" class="form-control" id="purchaseQuantity" name="purchaseQuantity" placeholder="Enter quantity" required>
    </div>
    <div class="form-group">
        <label for="purchaseDate">Purchase Date</label>
        <input type="date" class="form-control" id="purchaseDate" name="purchaseDate" required>
    </div>
    <div class="form-group">
        <label for="unitPrice">Unit Price</label>
        <input type="number" step="0.01" class="form-control" id="unitPrice" name="unitPrice" placeholder="Enter unit price" required>
    </div>
    <div class="form-group">
        <label for="discount">Discount (%)</label>
        <input type="number" class="form-control" id="discount" name="discount" placeholder="Enter discount percentage">
    </div>
    <div class="form-group">
        <label for="paymentMethod">Payment Method</label>
        <select class="form-control" id="paymentMethod" name="paymentMethod" required>
            <option value="">Select a payment method</option>
            <option value="Cash">Cash</option>
            <option value="Credit Card">Credit Card</option>
            <option value="Bank Transfer">Bank Transfer</option>
            <option value="Mobile Payment">Mobile Payment</option>
        </select>
    </div>
    <button type="submit" class="btn" style="background-color: #50B498; color: white;">Purchase</button>
    <button type="button" class="btn" style="background-color: #50B498; color: white;" onclick="cancelForm()">Cancel</button>
</form>
    </div>

    <?php
    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Fetch purchased items from the database
    $purchasedItemsQuery = "SELECT * FROM purchase_items"; // Adjust the table name and columns as per your database schema
    $purchasedItemsResult = $conn->query($purchasedItemsQuery);
    ?>

    <!-- Display Purchased Items -->
<div class="container mt-5" id="purchasedItemsList">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3><b>Purchased Items</b></h3>
    </div>
    <?php if ($purchasedItemsResult->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID Number</th>
                        <th>Purchase Code</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Discount</th>
                        <th>Total Price</th>
                        <th>Payment Method</th>
                        <th>Purchase Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $purchasedItemsResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['purchase_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($row['unit_price']); ?></td>
                            <td><?php echo htmlspecialchars($row['discount']); ?>%</td>
                            <td><?php echo htmlspecialchars($row['total_price']); ?></td>
                            <td><?php echo htmlspecialchars($row['payment_method']); ?></td>
                            <td><?php echo htmlspecialchars($row['purchase_date']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-danger" onclick="deletePurchasedItem(<?php echo $row['id']; ?>)">Delete</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
  
        <?php else: ?>
            <p>No purchased items found.</p>
        <?php endif; ?>
    </div>
</main>

 </div>
  </div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


<script>
function deletePurchasedItem(itemId) {
    if (confirm('Are you sure you want to delete this item?')) {
        window.location.href = 'delete_purchased_items.php?id=' + itemId; // Adjust as per your actual delete script
    }
}
</script>

</body>
</html>