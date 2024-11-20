<?php
session_start();


// Database connection
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Handle adding a new supplier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adding a supplier
    if (isset($_POST['add_supplier'])) {
        if (isset($_POST['SupplierName']) && !empty(trim($_POST['SupplierName']))) {
            $new_supplier = $conn->real_escape_string(trim($_POST['SupplierName']));
            
            // Check if supplier already exists
            $check_query = "SELECT * FROM suppliers WHERE SupplierName = '$new_supplier'";
            $check_result = $conn->query($check_query);
            if ($check_result->num_rows > 0) {
                $_SESSION['error_message'] = "Supplier '$new_supplier' already exists.";
            } else {
                $insert_query = "INSERT INTO suppliers (SupplierName) VALUES ('$new_supplier')";
                if ($conn->query($insert_query)) {
                    $_SESSION['success_message'] = "Supplier '$new_supplier' added successfully!";
                } else {
                    $_SESSION['error_message'] = "Error adding supplier: " . $conn->error;
                }
            }
        } else {
            $_SESSION['error_message'] = "Supplier name cannot be empty.";
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Deleting a supplier
    if (isset($_POST['delete_supplier'])) {
        if (isset($_POST['supplier_to_delete']) && !empty(trim($_POST['supplier_to_delete']))) {
            $supplier_to_delete = $conn->real_escape_string(trim($_POST['supplier_to_delete']));
            $delete_query = "DELETE FROM suppliers WHERE SupplierName='$supplier_to_delete'";
            if ($conn->query($delete_query)) {
                $_SESSION['success_message'] = "Supplier '$supplier_to_delete' deleted successfully!";
            } else {
                $_SESSION['error_message'] = "Error deleting supplier: " . $conn->error;
            }
        } else {
            $_SESSION['error_message'] = "Invalid supplier selected for deletion.";
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
                  <b>  <a class="nav-link" href="Login.php">Logout</a>
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
                <h3 class="mb-4"><b>Suppliers</b></h3>

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

               
<?php if ($isAdmin): ?>
<div class="card mb-4">

    <div class="card-header" style="background-color: #50B498; color: white;">
        Add New Supplier

    </div>
    <div class="card-body">
        <form method="POST" action="">
            <div class="form-group">
                <label for="SupplierName">Supplier Name</label>
                <input type="text" class="form-control" id="SupplierName" name="SupplierName" 
                    placeholder="Enter supplier name" required>
            </div>
            <div class="form-group">
                <label for="SupplierContact">Supplier Contact</label>
                <input type="text" class="form-control" id="SupplierContact" name="SupplierContact" 
                    placeholder="Enter supplier contact" required>
            </div>
            <button type="submit" class="btn" style="background-color: #50B498; color: white;" name="add_supplier">Add Supplier</button>
        </form>
    </div>
</div>
<?php endif; ?>


<div class="card">

    <div class="card-header" style="background-color: #50B498; color: white;">
        Supplier List
    </div>
   <div class="card-body">
    <div class="list-group">
        <?php
        // Fetch suppliers from the database
        $result = $conn->query("SELECT * FROM suppliers");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Check if the supplier_name and supplier_contact keys exist before accessing them
                if (isset($row['SupplierName']) && isset($row['SupplierContact'])) {
                    echo '<div class="list-group-item d-flex justify-content-between align-items-center">';
                    echo '<div>';
                    echo '<strong>' . htmlspecialchars($row['SupplierName']) . '</strong><br>';
                    echo '<small>Contact: ' . htmlspecialchars($row['SupplierContact']) . '</small>';
                    echo '</div>';
                    
                    // Check if the user is an admin
                    if ($isAdmin) {
                        echo '<form method="POST" action="" class="ml-2">';
                        echo '<input type="hidden" name="supplier_to_delete" value="' . htmlspecialchars($row['SupplierName']) . '">';
                        echo '<button type="submit" class="btn btn-danger btn-sm" name="delete_supplier"><i class="fas fa-trash-alt"></i> Delete</button>';
                        echo '</form>';
                    }

                    echo '</div>'; // Closing the list-group-item div
                }
            }
        } else {
            echo '<p>No suppliers found.</p>';
        }
        ?>
    </div>
</div>

    </div>
</div>


            </main>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JS -->
    <script>
function fetchSuppliers() {
    fetch('get_suppliers.php')
        .then(response => response.json())
        .then(data => {
            const supplierList = document.getElementById('supplierList').querySelector('.list-group');
            supplierList.innerHTML = '';
            data.forEach(supplier => {
                const supplierItem = document.createElement('div');
                supplierItem.className = 'list-group-item';
                
                // Create a delete button for each supplier
                const deleteButton = document.createElement('button');
                deleteButton.innerText = 'Delete';
                deleteButton.className = 'btn btn-danger btn-sm float-right';
                deleteButton.onclick = function() {
                    if (confirm('Are you sure you want to delete this supplier?')) {
                        deleteSupplier(supplier.SupplierID);
                    }
                };

                supplierItem.innerHTML = `<strong>${supplier.SupplierName}</strong><br>${supplier.SupplierContact}`;
                supplierItem.appendChild(deleteButton); // Add the delete button to the supplier item
                supplierList.appendChild(supplierItem);
            });
        })
        .catch(error => console.error('Error fetching suppliers:', error));
}

function deleteSupplier(id) {
    fetch(`delete_supplier.php`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ SupplierID: id })
    })
    .then(response => {
        if (response.ok) {
            alert('Supplier deleted successfully.');
            fetchSuppliers(); // Refresh the supplier list
        } else {
            alert('Failed to delete supplier.');
        }
    })
    .catch(error => console.error('Error deleting supplier:', error));
}

// Load suppliers on page load
document.addEventListener('DOMContentLoaded', fetchSuppliers);
</script>

    <script>
    async function validateSupplierContact(contact) {
        try {
            const response = await fetch('check_contact.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ contact: contact })
            });
            const data = await response.json();
            return data.exists;
        } catch (error) {
            console.error('Error validating contact:', error);
            return false;
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const form = document.querySelector('form');
        form.addEventListener('submit', async (event) => {
            const contactInput = document.getElementById('supplierContact');
            const contact = contactInput.value;

            const contactExists = await validateSupplierContact(contact);
            if (contactExists) {
                event.preventDefault();
                alert('Supplier contact already exists.');
            }
        });
    });
</script>
</body>
</html>