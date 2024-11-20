<?php
session_start();

// Handle form submissions before any HTML output
// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Handle adding a new category
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adding a category
    if (isset($_POST['add_category'])) {
        if (isset($_POST['categoryName']) && !empty(trim($_POST['categoryName']))) {
            $new_category = $conn->real_escape_string(trim($_POST['categoryName']));
            
            // Check if category already exists
            $check_query = "SELECT * FROM categories WHERE category_name = '$new_category'";
            $check_result = $conn->query($check_query);
            if ($check_result->num_rows > 0) {
                $_SESSION['error_message'] = "Category '$new_category' already exists.";
            } else {
                $insert_query = "INSERT INTO categories (category_name) VALUES ('$new_category')";
                if ($conn->query($insert_query)) {
                    $_SESSION['success_message'] = "Category '$new_category' added successfully!";
                } else {
                    $_SESSION['error_message'] = "Error adding category: " . $conn->error;
                }
            }
        } else {
            $_SESSION['error_message'] = "Category name cannot be empty.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Deleting a category
    if (isset($_POST['delete_category'])) {
        if (isset($_POST['category_to_delete']) && !empty(trim($_POST['category_to_delete']))) {
            $category_to_delete = $conn->real_escape_string(trim($_POST['category_to_delete']));
            $delete_query = "DELETE FROM categories WHERE category_name='$category_to_delete'";
            if ($conn->query($delete_query)) {
                $_SESSION['success_message'] = "Category '$category_to_delete' deleted successfully!";
            } else {
                $_SESSION['error_message'] = "Error deleting category: " . $conn->error;
            }
        } else {
            $_SESSION['error_message'] = "Invalid category selected for deletion.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Session-based messages
$success_message = '';
$error_message = '';

if (isset($_SESSION['success_message'])) {
    $success_message = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
}

// Check user session
if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: Login.php");
    exit();
}

// Check if user is an admin
$isAdmin = $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Dashboard - Categories</title>
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
            margin-left: 230px; 
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
            .navbar-brand {
                margin-left: 0;
                margin-right: 0;
                font-size: 18px; /* Reduce font size on mobile */
                padding: 5px; /* Adjust padding */
                width: 100%; /* Ensure it spans the full width */
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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" 
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                    <a href="Dashboard.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="Product.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-box"></i> Products
                    </a>
                    <a href="Categories.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-tags"></i> Categories
                    </a>
                    <a href="Supplier.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-truck"></i> Suppliers
                    </a>
                    <a href="#borrowerSubMenu" class="list-group-item list-group-item-action" data-toggle="collapse">
                        <i class="fas fa-user-friends"></i> Borrow
                    </a>
                    <div id="borrowerSubMenu" class="collapse">
                        <a href="borrower.php" class="list-group-item list-group-item-action pl-4">
                            <i class="fas fa-user"></i> Submit Details
                        </a>
                        <a href="borrow_item.php" class="list-group-item list-group-item-action pl-4">
                            <i class="fas fa-hand-holding"></i> Borrow Item
                        </a>
                    </div>
                    <a href="Account.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-user-circle"></i> Account
                    </a>
                    <a href="Order.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-shopping-cart"></i> Order
                    </a>
                    <a href="stock.php" class="list-group-item list-group-item-action">
                        <i class="fas fa-warehouse"></i> Stock
                    </a>
                     <?php if ($_SESSION['role'] === 'admin'): ?> <!-- Check if the user is an admin -->
                    <a href="Manage_users.php" class="list-group-item list-group-item-action"><i class="fas fa-users"></i> Manage User</a>
                <?php endif; ?>
                </div>
            </div>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <h3 class="mb-4"><b>Categories</b></h3>

                <!-- Display Success or Error Messages -->
                <?php if ($success_message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($success_message); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <?php if ($error_message): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($error_message); ?>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- Add Category Form -->
                <?php if ($isAdmin): ?>
                <div class="card mb-4">
                    <div class="card-header" style="background-color: #50B498; color: white;">
                        Add New Category
                    </div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="categoryName">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" name="categoryName" 
                                    placeholder="Enter category name" required>
                            </div>
                            <button type="submit" class="btn" style="background-color: #50B498; color: white;" name="add_category">Add Category</button>
                        </form>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Display and Manage Categories -->
                
                    <div class="card-bolass=">
                    <div class="card-header" style="background-color: #50B498; color: white;">
                        Category List
                    </div>
                        <div class="list-group">
                            <?php
                            // Fetch categories from the database
                            $result = $conn->query("SELECT category_name FROM categories ORDER BY category_name ASC");

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<div class="list-group-item d-flex justify-content-between align-items-center">';
                                    echo '<span>' . htmlspecialchars($row['category_name']) . '</span>';
                                    
                                    if ($isAdmin) {
                                        echo '
                                            <form method="POST" action="" class="mb-0" onsubmit="return confirmDelete(\'' . htmlspecialchars(addslashes($row['category_name'])) . '\')">
                                                <input type="hidden" name="category_to_delete" value="' . htmlspecialchars($row['category_name']) . '">
                                                <button type="submit" class="btn btn-danger btn-sm" name="delete_category">
                                                    <i class="fas fa-trash-alt"></i> Delete
                                                </button>
                                            </form>
                                        ';
                                    }

                                    echo '</div>';
                                }
                            } else {
                                echo '<div class="list-group-item">No categories found.</div>';
                            }

                            // Close connection
                            $conn->close();
                            ?>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Confirmation for delete -->
    <script>
        function confirmDelete(categoryName) {
            return confirm("Are you sure you want to delete the category '" + categoryName + "'?");
        }
    </script>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" 
        integrity="sha384-DfXdER4azH3E7FdHwx40XZRfEULvJxXLEUfdv+eK1YbN91m+WH4tfg5cM9+qHcbr" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" 
        integrity="sha384-XoVuF9rPQV9TmJ6DgWyzJv7yUvB1fNJafgdgkbjg+lQcR0uRG9IvGD+qjTm66YHY" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" 
        integrity="sha384-cfQYq5gFAT2R9FHRUp70e4YzKk6cPVlU2vryHvIiwE3/VoTCmPldE3c3w7qKg05t" crossorigin="anonymous"></script>
</body>
</html>