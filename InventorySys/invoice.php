<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}

// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch the 10 most recent purchases
$sql = "SELECT * FROM purchase_items ORDER BY id DESC LIMIT 10";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    // Fetch all recent purchases into an array
    $purchaseItems = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $purchaseItems = [];
}

$conn->close();
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom CSS -->
    <style>
   body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
}


.invoice {
    max-width: 800px;
    margin: auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff; /* Ensure background color is white */
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.invoice-header {
    text-align: center;
    margin-bottom: 20px;
}

.invoice-header h1 {
    margin-bottom: 5px;
    font-size: 24px;
    color: #333;
}

.invoice-header p {
    margin-top: 0;
    font-size: 14px;
    color: #666;
}

.invoice-details {
    margin-top: 0; /* Ensure no extra space above the table */
}

.invoice-details table {
    width: 100%;
    border-collapse: collapse;
}

.invoice-details table th, .invoice-details table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
    font-size: 14px;
}

.invoice-details table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.invoice-footer {
    margin-top: 20px;
    text-align: center;
}

.print-button {
    margin-top: 20px;
    text-align: center;
}

@media print {
    body {
        margin: 0;
        padding: 0;
        background: none;
    }
    .invoice {
        max-width: none;
        width: 100%;
        margin: 0 auto; /* Center content */
        box-shadow: none;
        position: relative;
        transform: none;
    }
    .print-button {
        display: none;
    }
    .invoice-header, .invoice-details, .invoice-footer {
        display: block;
    }

    /* Hide sidebar when printing */
    .sidebar {
        display: none;
    }

    /* Ensure main content takes full width when sidebar is hidden */
    .main-content {
        margin-left: 0;
    }
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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 1);
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
   


.invoice-header {
    display: flex;
    align-items: flex-start; /* Align items to the top */
    padding: 20px; /* Add padding around the header */
    border-bottom: 1px solid #ddd; /* Add a bottom border for separation */
    background-color: #f9f9f9; /* Light background color for the header */
}

.header-details {
    text-align: left; /* Align text to the left for better visual balance */
}

.header-details p {
    margin: 2px 0; /* Space between address lines */
    font-size: 14px;
    color: green; /* Color for the address text */
}

strong {
    font-size: 28px;
    color: green;
}

.school {
    width: 150px;
    height: 120px;
}

.invoice-footer {
    color: green;
}

/* Table Container */
.table-container {
    margin-top: 20px; /* Space above the table */
    overflow-x: auto; /* Allow horizontal scrolling if the table is too wide */
}

/* Table Styles */
.table {
    width: 100%; /* Ensure table takes full width of the container */
    border-collapse: collapse; /* Collapse table borders */
}

.table th, .table td {
    padding: 8px; /* Space within table cells */
    text-align: left; /* Align text to the left */
    border-bottom: 1px solid #ddd; /* Border for rows */
}

.table thead th {
    background-color: #f4f4f4; /* Background color for table headers */
    font-weight: bold; /* Make header text bold */
}

@media (max-width: 768px) {
    .invoice-header {
        flex-direction: column; /* Stack items vertically on small screens */
        align-items: center; /* Center items horizontally */
        text-align: center; /* Center text */
    }

    .header-content, .header-text {
        width: 100%; /* Full width for stacked items */
        margin: 10px 0; /* Adjust margin */
    }

    .school {
        width: 150px; /* Adjust logo size for mobile */
        height: 70
        margin: 0 auto; /* Center logo horizontally */
    }

    .header-text h1 {
        font-size: 18px; /* Adjust font size for mobile */

    }

    .header-details p {
        font-size: 12px; /* Adjust font size for mobile */
    }

    .table-container {
        overflow-x: auto; /* Allow horizontal scrolling on smaller screens */
    }

    .table th, .table td {
        font-size: 12px; /* Adjust font size for smaller screens */
        padding: 6px; /* Adjust padding for smaller screens */
    }
}

@media (max-width: 480px) {
    .invoice-header {
        padding: 10px; /* Reduce padding on very small screens */
    }

    .school {
        width: 100px; /* Further adjust logo size */
    }

    .header-text h1 {
        font-size: 16px; /* Further adjust font size */
    }
}

/* Print Styles */
@media print {
    body {
        margin: 0; /* Remove default margin */
        font-size: 12px; /* Adjust font size for print */
    }

    .invoice-header, .invoice-footer {
        border: none; /* Remove borders for print */
        background-color: transparent; /* Remove background color for print */
    }

    .table-container {
        margin-top: 0; /* Remove margin for print */
        overflow: visible; /* Ensure table is visible */
    }

    .table th, .table td {
        font-size: 12px; /* Adjust font size for print */
        padding: 4px; /* Adjust padding for print */
    }

    /* Ensure elements fit within the page */
    .invoice-header, .table-container, .invoice-footer {
        page-break-inside: avoid; /* Avoid breaking within these elements */
    }

    /* Position "Official Receipt" text at the top-right corner */
    .receipt-header {
        position: absolute; /* Position it absolutely */
        top: 0; /* Align to the top of the page */
        right: 0; /* Align to the right of the page */
        padding: 10px; /* Add some padding for spacing */
        font-size: 14px; /* Adjust font size for readability */
        font-weight: bold; /* Make the text bold */
        color: black; /* Set text color */
    }

    /* Position image to the left and adjust details */
    .invoice-header .header-content {
        display: flex; /* Use flexbox for alignment */
        align-items: center; /* Align items vertically centered */
        position: relative; /* Allow positioning within the container */
        padding-left: 100px; /* Add padding to create space on the left */
    }

    .school {
        position: absolute; /* Position image absolutely within the container */
        left: 50px; /* Align image to the left */
        top: 20%; /* Vertically center image */
        transform: translateY(-50%); /* Adjust vertical centering */
        width: 150px; /* Adjust image size for print */
    }

    .header-details {
        margin-left: 100px; /* Add margin to make space for the image */
        flex: 1; /* Allow details to take up remaining space */
    }
}
.navbar-nav {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
}

.form-inline {
    flex-wrap: nowrap;
    width: 100%;
}

.input-group {
    width: 100%;
}

.form-control {
    flex: 1;
    max-width: calc(100% - 90px); /* Adjust for button width */
}

.btn {
    white-space: nowrap;
    min-width: 80px;
}

@media (max-width: 768px) {
    .navbar-nav {
        text-align: center;
    }
    .navbar-nav .nav-item {
        margin-bottom: 10px;
    }
    .form-inline {
        flex-direction: column;
    }
    .input-group {
        width: 100%;
    }
    .form-control {
        width: calc(100% - 90px); /* Adjust width for mobile */
    }
    .btn {
        width: 90px; /* Adjust button width */
    }
}

@media (max-width: 576px) {
    .form-control {
        width: calc(100% - 70px); /* Further adjust for extra-small screens */
    }
    .btn {
        width: 70px; /* Further adjust button width */
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
            <!-- Search Form -->
            <li class="nav-item">
                <form class="form-inline d-flex flex-nowrap" action="invoice.php" method="GET">
                    <div class="input-group">
                        <input class="form-control mr-sm-2" type="search" placeholder="Search by ID" aria-label="Search" name="idnumber">
                        <div class="input-group-append">
                            <button class="btn btn-outline-light" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </li>
            <li class="nav-item">
                <span class="navbar-text mx-3 d-none d-md-inline">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="Login.php">Logout</a>
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
                        <a href="borrower.php" class="list-group-item list-group-item-action pl-4"><i class="fas fa-user"></i> Submit Deatials</a>
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
 
<?php
// Assume $purchaseItems is fetched from the database and contains the purchase data

// Get the searched ID number from the query string (or set to null if not provided)
$searchedIdNumber = isset($_GET['idnumber']) ? $_GET['idnumber'] : null;

// Group items by idnumber
$groupedItems = [];
foreach ($purchaseItems as $item) {
    $groupedItems[$item['idNumber']][] = $item;
}

// Filter items based on the searched ID number if provided
if ($searchedIdNumber !== null && isset($groupedItems[$searchedIdNumber])) {
    $filteredGroupedItems = [$searchedIdNumber => $groupedItems[$searchedIdNumber]];
} else {
    $filteredGroupedItems = $groupedItems; // Show all if no specific ID number is searched
}
?>

<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <!-- Purchase Product Form -->
    <?php foreach ($filteredGroupedItems as $idnumber => $items): ?>
        <div class="invoice">
            <div class="invoice-header">
                <img src="school.png" class="school" alt="School Logo">
                <div class="header-content">
                    <div class="header-details">
                        <p><strong>Saint Joseph Institute of Technology, Inc</strong></p>
                        <p>Montilla Blvd., Cor. Rosales St, Leon Kilat Pob. (Brgy.13) 8600 Butuan City, Agusan del Norte</p>
                        <p>Website: Cbit-Inventory-Management-System</p>
                    </div>
                </div>
                <div class="receipt-header">
                    <strong>OFFICIAL<br> RECEIPT</strong>
                </div>
            </div>
            
            <div class="table-responsive">
                <h4>ID Number: <?php echo htmlspecialchars($idnumber); ?></h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Discount</th>
                            <th>Payment Method</th>
                            <th>Purchase Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPrice = 0; // Initialize total price variable
                        $recentDate = max(array_column($items, 'purchase_date')); // Get the most recent purchase date

                        // Filter items with the most recent date
                        $filteredItems = array_filter($items, function($item) use ($recentDate) {
                            return $item['purchase_date'] === $recentDate;
                        });

                        if (!empty($filteredItems)):
                            foreach ($filteredItems as $item):
                                $totalPrice += $item['total_price']; // Accumulate total price
                        ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($item['purchase_code']); ?></td>
                                    <td><?php echo htmlspecialchars($item['product_name']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars(number_format($item['unit_price'], 2)); ?></td>
                                    <td><?php echo htmlspecialchars($item['discount']); ?>%</td>
                                    <td><?php echo htmlspecialchars($item['payment_method']); ?></td>
                                    <td><?php echo htmlspecialchars($item['purchase_date']); ?></td>
                                </tr>
                        <?php
                            endforeach;
                        else:
                        ?>
                            <tr>
                                <td colspan="7">No recent purchases found.</td>
                            </tr>
                        <?php
                        endif;
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3"><b>Total:</b></td>
                            <td colspan="4"><?php echo htmlspecialchars(number_format($totalPrice, 2)); ?></td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Invoice Footer for Each ID Number -->
                <div class="invoice-footer">
                    <p><b>"THIS DOCUMENT IS NOT VALID FOR CLAIM OF INPUT TAXES"</b></p>
                    <p><b>"THIS OFFICIAL RECEIPT SHALL BE VALID FOR FIVE (5) YEARS FROM THE DATE OF ATP"</b></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Print Button -->
    <div class="print-button">
        <button onclick="window.print()" class="btn" style="background-color: #50B498; color: white;">Print Invoice</button>
    </div>
</main>
 </div>
  </div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>



</body>
</html>