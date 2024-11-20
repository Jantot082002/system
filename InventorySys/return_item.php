
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
                <?php endif; ?>
                </div>     
            </div>
        
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                
                <div class="container mt-4">
                    <h3><b>Return Item</b></h3>
                    <form id="returnForm" action="process_return.php" method="POST">
                        <div class="form-group">
                            <label for="borrowerId">Borrower ID</label>
                            <input type="text" class="form-control" id="borrowerId" name="borrowerId" placeholder="Enter Borrower ID" required>
                        </div>
                        <div class="form-group">
                            <label for="productId">Select Product</label>
                            <select class="form-control" id="productId" name="productId" required>
                                <option value="">Select a product</option>
                                <?php
                                // Connect to the database
                                $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
                                if ($conn->connect_error) {
                                    die("Connection Failed: " . $conn->connect_error);
                                }

                                // Fetch products from the database
                                $sql = "SELECT id, product_name FROM products";
                                $result = $conn->query($sql);

                                // Check if there are any products
                                if ($result->num_rows > 0) {
                                    // Output data for each row
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id'] . "'>" . $row['product_name'] . "</option>";
                                    }
                                } else {
                                    echo "<option>No products available</option>";
                                }

                                // Close the connection
                                $conn->close();
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="quantity">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" placeholder="Enter quantity" required>
                        </div>
                        <div class="form-group">
                            <label for="returnDate">Return Date</label>
                            <input type="date" class="form-control" id="returnDate" name="returnDate" required>
                        </div>
                        <button type="submit" class="btn" style="background-color: #50B498; color: white;">Return</button>
                    </form>
                </div>
               <div class="container mt-4">
    <h3><b>Returned Items</b></h3>
    <div class="table-responsive">
        <table class="table table-bordered">
        <thead>
            <tr>
                <th>Borrower ID</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Return Date</th>
            </tr>
        </thead>
       <tbody>
  <?php
// Connect to the database
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch returned items from the borrow_records table
$sql = "SELECT borrow_records.borrower_id, products.product_name, borrow_records.quantity, borrow_records.return_date
        FROM borrow_records
        INNER JOIN products ON borrow_records.product_id = products.id
        WHERE borrow_records.return_date IS NOT NULL";
$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}

// Check if there are any returned items
if ($result->num_rows > 0) {
    // Output data for each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['borrower_id']) . "</td>
                <td>" . htmlspecialchars($row['product_name']) . "</td>
                <td>" . htmlspecialchars($row['quantity']) . "</td>
                <td>" . htmlspecialchars($row['return_date']) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='4'>No returned items found</td></tr>";
}

// Close the connection
$conn->close();
?>
</tbody>
    </table>
</div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>