<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'inventoryproj');

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Fetch registered users from the registration table
$sql = "SELECT id, username, email, role FROM registration"; // Query the registration table
$result = $conn->query($sql);
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
                        <a href="borrower.php" class="list-group-item list-group-item-action pl-4"><i class="fas fa-user"></i> Submit Details</a>
                        <a href="borrow_item.php" class="list-group-item list-group-item-action pl-4"><i class="fas fa-hand-holding"></i> Borrow Item</a>
                    </div>
                    <a href="Account.php" class="list-group-item list-group-item-action"><i class="fas fa-user-circle"></i> Account</a>
                    <a href="Order.php" class="list-group-item list-group-item-action"><i class="fas fa-shopping-cart"></i> Order</a>
                    <a href="stock.php" class="list-group-item list-group-item-action"><i class="fas fa-warehouse"></i> Stock</a>
                    <?php if ($_SESSION['role'] === 'admin'): ?>
                        <a href="Manage_users.php" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Manage User</a>
                    <?php endif; ?>
                </div>
            </div>
 <main class="main-content">
    <div class="container">
        <h2 class="mt-4">Registered Users</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . htmlspecialchars($row['username']) . "</td>
                                <td>" . htmlspecialchars($row['email']) . "</td>
                                <td>" . htmlspecialchars($row['role']) . "</td>
                                <td>
                                    <form method='POST' action='delete_user.php' onsubmit='return confirm(\"Are you sure you want to delete this user?\");'>
                                        <input type='hidden' name='user_id' value='" . htmlspecialchars($row['id']) . "'>
                                        <button type='submit' class='btn btn-danger btn-sm'>
                                            <i class='fas fa-trash-alt'></i> Delete
                                        </button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No registered users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>



        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM3oGxL64x5p2z8g/Rh7xW4M4/7hVJfW9Uo5lP" crossorigin="anonymous">

</body>
</html>

<?php
$conn->close();
?>
