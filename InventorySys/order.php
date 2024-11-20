<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}

// Check if the user is an admin
$is_admin = $_SESSION['role'] === 'admin';
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
          .alert-custom {
            display: none;
            margin-bottom: 20px;
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
                    <b><a class="nav-link" href="Login.php">Logout</a>
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
                <?php endif; ?>                </div>
            </div>

  <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <?php if ($is_admin): ?>
        <h2><b>Create Order</b></h2>

        <div class="container">
            <div id="message" class="alert alert-dismissible alert-custom"></div>
            <form action="create_order.php" method="post">
                <div class="form-group">
                    <label for="supplier">Supplier</label>
                    <select id="supplier" name="supplier_id" class="form-control" required>
                        <!-- PHP code to fetch suppliers from the database -->
                        <?php
                        // Connect to the database
                        $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Fetch suppliers
                        $sql = "SELECT SupplierID, SupplierName FROM suppliers";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['SupplierID'] . "'>" . htmlspecialchars($row['SupplierName']) . "</option>";
                            }
                        } else {
                            echo "<option>No suppliers found</option>";
                        }

                        $conn->close();
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="product_name">Product Name</label>
                    <input type="text" id="product_name" name="product_name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity</label>
                    <input type="number" id="quantity" name="quantity" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="delivery_duration">Delivery Duration (days)</label>
                    <input type="number" id="delivery_duration" name="delivery_duration" class="form-control" required>
                </div>
                <button type="submit" class="btn" style="background-color: #50B498; color: white;">Submit Order</button>
            </form>
        </div>

<br>
<br>

        <h2><b>Order List</b></h2>
        <form action="" method="get">
            <div class="form-group">
                <label for="search_date">Received Date</label>
                <input type="date" id="search_date" name="search_date" class="form-control">
            </div>
            <button type="submit" class="btn" style="background-color: #50B498; color: white;">Search</button>
        </form>
        
        <br>

        <?php
        // Connect to the database
        $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare the SQL query
        $sql = "SELECT orders.id, suppliers.SupplierName, orders.product_name, orders.quantity, orders.order_date, orders.received_date, orders.status, orders.delivery_duration 
                FROM orders 
                JOIN suppliers ON orders.supplier_id = suppliers.SupplierID";

        // Check if a search date is provided
        if (isset($_GET['search_date']) && !empty($_GET['search_date'])) {
            $search_date = $_GET['search_date'];
            $sql .= " WHERE orders.received_date = ?";
        }

        $stmt = $conn->prepare($sql);
        
        // Bind parameters if a search date is provided
        if (isset($search_date)) {
            $stmt->bind_param('s', $search_date);
        }
        
        $stmt->execute();
        $result = $stmt->get_result();

        echo "<h2><b>Order List</b></h2>";
        echo "<div class='table-responsive'>";
        echo '<table class="table table-bordered">';
        echo '<thead><tr>
                <th>Supplier</th>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Order Date</th>
                <th>Received Date</th>
                <th>Status</th>
                <th>Delivery Duration (days)</th>
                <th>Action</th>
              </tr></thead>';
        echo '<tbody>';

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['SupplierName']) . '</td>';
                echo '<td>' . htmlspecialchars($row['product_name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['quantity']) . '</td>';
                echo '<td>' . htmlspecialchars($row['order_date']) . '</td>';
                echo '<td>' . ($row['received_date'] ? htmlspecialchars($row['received_date']) : 'N/A') . '</td>';
                echo '<td>' . htmlspecialchars($row['status']) . '</td>';

                // Calculate the expected delivery date and the remaining days
                $expected_delivery_date = date('Y-m-d', strtotime($row['order_date'] . ' + ' . $row['delivery_duration'] . ' days'));
                $remaining_days = (strtotime($expected_delivery_date) - strtotime(date('Y-m-d'))) / (60 * 60 * 24);

                // Display the remaining days or the delivery duration
                if ($remaining_days > 0) {
                    echo '<td>' . $remaining_days . ' days remaining</td>';
                } else {
                    echo '<td>Delivery due</td>';
                }

                echo '<td>';

                // Check if the order can be marked as received
                if ($row['status'] == 'Pending' && date('Y-m-d') >= $expected_delivery_date) {
                    echo '<form action="mark_recieved.php" method="post" style="display:inline;">
                            <input type="hidden" name="order_id" value="' . $row['id'] . '">
                            <input type="date" name="received_date" required>
                            <button type="submit" class="btn btn-success btn-sm">Mark Received</button>
                          </form>';
                } elseif ($row['status'] == 'Pending') {
                    echo 'Pending';
                } else {
                    echo 'Received';
                }

                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="8">No orders found</td></tr>';
        }

        echo '</tbody>';
        echo '</table>';

        $conn->close();
        ?>
    <?php else: ?>
        <h2>Access Denied</h2>
        <p>You do not have permission to create orders.</p>
    <?php endif; ?>
</main>


        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const messageElement = document.getElementById('message');

            if (status === 'success') {
                messageElement.innerHTML = '<strong>Success!</strong> New order created successfully.';
                messageElement.classList.add('alert-success');
                messageElement.classList.remove('alert-error');
                messageElement.style.display = 'block';
            } else if (status === 'error') {
                messageElement.innerHTML = '<strong>Error!</strong> There was an error creating the order. Please try again.';
                messageElement.classList.add('alert-danger');
                messageElement.classList.remove('alert-success');
                messageElement.style.display = 'block';
            }
        });
    </script>
</body>
</html>