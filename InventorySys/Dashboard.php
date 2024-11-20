<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}
$isAdmin = $_SESSION['role'] === 'admin';
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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.4);
}

.margin-adjustment {
    margin-top: -250px; /* Default margin for larger screens */
}

/* Mobile-specific Styles */
@media (max-width: 768px) {
    .margin-adjustment {
        margin-top: 0; /* Adjust or reset margin for mobile screens */
    }
    
    .navbar-nav .nav-link {
        font-size: 16px; /* Adjust font size for mobile */
    }
    
    .navbar-text {
        font-size: 14px; /* Adjust font size for mobile */
    }
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
                <h1 class="mb-4"><b>Overview</h1>
                <!-- Content goes here -->
               
            <?php   
          // Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Query to get total products
$totalProductsQuery = "SELECT COUNT(*) AS total_products FROM products WHERE expiration_date > NOW()";
$productResult = $conn->query($totalProductsQuery);

// Fetch the total count of non-expired products
$totalProducts = $productResult->fetch_assoc()['total_products'];
// Query to get total borrowers
$totalBorrowersQuery = "SELECT COUNT(*) AS total_borrowers FROM borrowers";
$borrowerResult = $conn->query($totalBorrowersQuery);
$totalBorrowers = $borrowerResult->fetch_assoc()['total_borrowers'];

// Query to get total categories
$totalCategoriesQuery = "SELECT COUNT(*) AS total_categories FROM categories";
$categoriesResult = $conn->query($totalCategoriesQuery);
$totalCategories = $categoriesResult->fetch_assoc()['total_categories'];

// Query to get total suppliers
$totalSuppliersQuery = "SELECT COUNT(*) AS total_suppliers FROM suppliers";
$suppliersResult = $conn->query($totalSuppliersQuery);
$totalSuppliers = $suppliersResult->fetch_assoc()['total_suppliers'];


// Query to get total distinct stock items (unique products)
$totalStockQuery = "SELECT COUNT(DISTINCT orders.product_name) AS total_stock 
                     FROM orders 
                     WHERE orders.status = 'Received'";
$stockResult = $conn->query($totalStockQuery);
$totalStock = $stockResult->fetch_assoc()['total_stock'];

// Close the connection
$conn->close();
?>
<div class="row">
   <div class="col-md-3 card-box">
    <div class="card text-white" style="background-color: #4b9a7f;">
        <div class="card-body">
            <h5 class="card-title">Total Products</h5>
            <p class="card-text" id="total-products"><?php echo $totalProducts; ?></p>
        </div>
    </div>
</div>
    <div class="col-md-3 card-box">
        <div class="card text-white" style="background-color: #3a8f6f;">
            <div class="card-body">
                <h5 class="card-title">Total Borrowers</h5>
                <p class="card-text" id="total-borrowers"><?php echo $totalBorrowers; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 card-box">
        <div class="card text-white" style="background-color: #2e7b58;">
            <div class="card-body">
                <h5 class="card-title">Total Categories</h5>
                <p class="card-text" id="total-categories"><?php echo $totalCategories; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 card-box">
        <div class="card text-white" style="background-color: #267d52;">
            <div class="card-body">
                <h5 class="card-title">Total Suppliers</h5>
                <p class="card-text" id="total-suppliers"><?php echo $totalSuppliers; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-3 card-box">
        <div class="card text-white" style="background-color: #1f6f4f;">
            <div class="card-body">
                <h5 class="card-title">Total Stock</h5>
                <p class="card-text" id="total-stock"><?php echo $totalStock; ?></p>
            </div>
        </div>
    </div>
    </div>
<br>
<br>

    <div class="row recent-activities">

    <!-- Recent Products Chart -->
    <div class="col-md-6 card-box">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Recent Products</h5>
                <canvas id="productChart"></canvas>
              <?php
// PHP code for the Recent Products chart
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Select only non-expired products (assuming expiration_date column exists)
$productDataQuery = "SELECT product_name, quantity FROM products WHERE expiration_date > NOW()";
$productDataResult = $conn->query($productDataQuery);

$productNames = [];
$productQuantities = [];

if ($productDataResult->num_rows > 0) {
    while ($row = $productDataResult->fetch_assoc()) {
        $productNames[] = $row['product_name'];
        $productQuantities[] = $row['quantity'];
    }
}
$conn->close();
?>

                <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                <script>
                    var ctx = document.getElementById('productChart').getContext('2d');
                    var productChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: <?php echo json_encode($productNames); ?>,
                            datasets: [{
                                label: 'Product Quantities',
                                data: <?php echo json_encode($productQuantities); ?>,
                                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Expired Products Chart -->
<div class="col-md-6 card-box">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Expired Products</h5>
            <canvas id="expiredChart"></canvas>
            <?php
            // PHP code for expired items chart
            $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
            if ($conn->connect_error) {
                die("Connection Failed: " . $conn->connect_error);
            }

            // Get current date for expiration comparison
            $currentDate = date('Y-m-d');

            // Query to fetch expired products (expired date is less than current date)
            $expiredDataQuery = "SELECT product_name, quantity FROM products WHERE expiration_date < '$currentDate'";
            $expiredDataResult = $conn->query($expiredDataQuery);

            $expiredNames = [];
            $expiredQuantities = [];

            if ($expiredDataResult->num_rows > 0) {
                while ($row = $expiredDataResult->fetch_assoc()) {
                    $expiredNames[] = $row['product_name'];
                    $expiredQuantities[] = $row['quantity'];
                }
            }
            $conn->close();
            ?>
            <script>
                var ctx = document.getElementById('expiredChart').getContext('2d');
                var expiredChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: <?php echo json_encode($expiredNames); ?>,
                        datasets: [{
                            label: 'Expired Product Quantities',
                            data: <?php echo json_encode($expiredQuantities); ?>,
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
</div>


<!-- Stock Level Chart -->
<div class="col-md-6 card-box">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Stock Levels</h5>
            <canvas id="stockChart"></canvas>
            <?php
            // PHP code for stock levels chart
            $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $data = [];
            $labels = [];

            // Fetch stock levels for each product
            $sql = "SELECT product_name, SUM(quantity) as total_quantity 
                    FROM orders 
                    WHERE status = 'Received' 
                    GROUP BY product_name";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $labels[] = htmlspecialchars($row['product_name']);
                    $data[] = (int)$row['total_quantity'];
                }
            }

            // Convert PHP arrays to JSON
            $labels_json = json_encode($labels);
            $data_json = json_encode($data);
            ?>
            <script>
                var ctx = document.getElementById('stockChart').getContext('2d');
                var stockChart = new Chart(ctx, {
                    type: 'doughnut', // Change to doughnut chart
                    data: {
                        labels: <?php echo $labels_json; ?>,
                        datasets: [{
                            label: 'Stock Levels',
                            data: <?php echo $data_json; ?>,
                            backgroundColor: [
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)'
                            ],
                            borderColor: [
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)',
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        cutoutPercentage: 50, // Adjust the cutout percentage as needed
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
</div>


    <!-- Orders Line Chart -->
    <div class="col-md-6 card-box">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Orders Overview</h5>
                <canvas id="ordersChart"></canvas>
                <?php
                // PHP code for orders line chart
                $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
                if ($conn->connect_error) {
                    die("Connection Failed: " . $conn->connect_error);
                }

                $ordersQuery = "SELECT DATE(order_date) as date, COUNT(id) as count FROM orders GROUP BY DATE(order_date) ORDER BY DATE(order_date)";
                $ordersResult = $conn->query($ordersQuery);

                $orderDates = [];
                $orderCounts = [];

                if ($ordersResult->num_rows > 0) {
                    while ($row = $ordersResult->fetch_assoc()) {
                        $orderDates[] = $row['date'];
                        $orderCounts[] = $row['count'];
                    }
                }
                $conn->close();
                ?>
                <script>
                    var ctx = document.getElementById('ordersChart').getContext('2d');
                    var ordersChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($orderDates); ?>,
                            datasets: [{
                                label: 'Number of Orders',
                                data: <?php echo json_encode($orderCounts); ?>,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 2,
                                fill: true
                            }]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    }
                                },
                                y: {
                                    beginAtZero: true,
                                    title: {
                                        display: true,
                                        text: 'Number of Orders'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>

    <!-- Purchase Line Chart -->
   <!-- 
   <div class="col-md-6 offset-md-6 card-box margin-adjustment">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Purchase Overview</h5>
                <canvas id="purchaseChart"></canvas>
                <?php
                // PHP code for purchase line chart
                $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
                if ($conn->connect_error) {
                    die("Connection Failed: " . $conn->connect_error);
                }

                $ordersQuery = "SELECT DATE(purchase_date) as date, 
                                   MAX(unit_price) as high, 
                                   MIN(unit_price) as low 
                                FROM purchase_items 
                                GROUP BY DATE(purchase_date) 
                                ORDER BY DATE(purchase_date)";
                $ordersResult = $conn->query($ordersQuery);

                $purchaseDates = [];
                $purchaseHighs = [];
                $purchaseLows = [];

                if ($ordersResult->num_rows > 0) {
                    while ($row = $ordersResult->fetch_assoc()) {
                        $purchaseDates[] = $row['date'];
                        $purchaseHighs[] = $row['high'];
                        $purchaseLows[] = $row['low'];
                    }
                }
                $conn->close();
                ?>
                <script>
                    var ctx = document.getElementById('purchaseChart').getContext('2d');
                    var purchaseChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo json_encode($purchaseDates); ?>,
                            datasets: [
                                {
                                    label: 'High Purchase Price',
                                    data: <?php echo json_encode($purchaseHighs); ?>,
                                    borderColor: 'rgba(255, 99, 132, 1)',
                                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                                    borderWidth: 2,
                                    fill: true
                                },
                                {
                                    label: 'Low Purchase Price',
                                    data: <?php echo json_encode($purchaseLows); ?>,
                                    borderColor: 'rgba(54, 162, 235, 1)',
                                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                                    borderWidth: 2,
                                    fill: true
                                }
                            ]
                        },
                        options: {
                            scales: {
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Date'
                                    }
                                },
                                y: {
                                    title: {
                                        display: true,
                                        text: 'Purchase Price'
                                    }
                                }
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
-->
               
            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>