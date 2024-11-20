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
         margin-left: 1px;
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
   .alert {
    padding: 15px;
    margin: 15px 0;
    border-radius: 5px;
    font-size: 16px;
    color: #fff;
    display: none; /* Hidden by default */
}
.alert.success {
    background-color: #4CAF50; /* Green */
}
.alert.error {
    background-color: #f44336; /* Red */
}

/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.5); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: 5% auto; /* Reduced margin for mobile */
    padding: 20px;
    border: 1px solid #888;
    width: 90%; /* Use 90% width for better mobile experience */
    max-width: 600px; /* Limit the max width */
    border-radius: 8px; /* Rounded corners */
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Subtle shadow */
    max-height: 80%; /* Set a max height for scrolling */
    overflow-y: auto; /* Enable vertical scrolling */
}

.close {
    color: #aaa;
    float: left;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

h2 {
    text-align: center;
    color: #333;
}

/* Form Styles */
.form-group {
    margin-bottom: 15px; /* Spacing between fields */
}

label {
    display: block; /* Make labels block elements */
    margin-bottom: 5px; /* Space between label and input */
    font-weight: 600;
}

input[type="text"],
input[type="number"] {
    width: 100%; /* Full width */
    padding: 10px; /* Padding inside the inputs */
    border: 1px solid #ccc; /* Border color */
    border-radius: 4px; /* Rounded borders */
    box-sizing: border-box; /* Include padding and border in the element's total width and height */
    transition: border-color 0.3s; /* Smooth border color transition */
}

input[type="text"]:focus,
input[type="number"]:focus {
    
    outline: none; /* Remove outline */
}

.update-button {
    background-color: #50B498; /* Bootstrap primary color */
    color: white; /* Text color */
    padding: 10px 15px; /* Padding around the text */
    border: none; /* No border */
    border-radius: 4px; /* Rounded corners */
    cursor: pointer; /* Pointer cursor on hover */
    width: 100%; /* Full width */
    transition: background-color 0.3s; /* Smooth background color transition */
}

.update-button:hover {
    background-color: darkgreen; /* Darker blue on hover */
}

/* Media Queries for Mobile Responsiveness */
@media (max-width: 768px) {
    .modal-content {
        margin: 10px; /* Less margin on mobile */
        padding: 10px; /* Less padding on mobile */
    }

    h2 {
        font-size: 20px; /* Smaller heading size on mobile */
    }

    .form-group {
        margin-bottom: 10px; /* Less spacing between fields */
    }

    .close {
        font-size: 24px; /* Smaller close button */
    }

    input[type="text"],
    input[type="number"],
    .update-button {
        padding: 8px; /* Adjust padding */
    }
}
/* Base alert style */
.alert {
    display: none; /* Hidden by default */
    padding: 15px;
    margin-bottom: 20px;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: bold;
    text-align: center;
    transition: opacity 0.5s ease, transform 0.5s ease;
    opacity: 0; /* Fade-in effect */
    transform: translateY(-20px); /* Slide-down effect */
    height: 20px;
}

/* Success alert */
.alert-success {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
}

/* Error alert */
.alert-danger {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

/* Show the alert */
.alert.show {
    display: block;
    opacity: 1;
    transform: translateY(0);
}



@media (max-width: 576px) {
    .modal-content {
        padding: 1rem; /* Add some padding for smaller screens */
    }
    
    .modal-header, .modal-body {
        text-align: center; /* Center the text for a better look on small screens */
    }

    .form-label {
        font-size: 0.9rem; /* Slightly smaller font size for labels */
    }
    
    .form-control {
        font-size: 0.9rem; /* Slightly smaller font size for input fields */
    }

    button {
        font-size: 0.9rem; /* Smaller font size for buttons */
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
                <?php endif; ?>                </div>
    </div>
 <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h3><b>Add Product</b></h3>
    <!-- Add Product Form -->
     <?php if ($_SESSION['role'] == 'admin'): ?>
    <div class="container mt-4" id="addProductForm">
        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-<?php echo $_GET['status'] == 'success' ? 'success' : 'danger'; ?>">
                Product <?php echo $_GET['mode'] == 'update' ? 'updated' : 'added'; ?> successfully.
            </div>
        <?php endif; ?>
    


   <!-- Message Container (hidden by default) -->
<div id="message" style="display:none;"></div>

<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Add Product</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Form -->
                <form id="productForm" method="post" action="add_product.php">
                    <input type="hidden" id="productId" name="productId">
                    <input type="hidden" id="formMode" name="formMode" value="create">

                    <div class="form-group">
                        <label for="productName">Product Name</label>
                        <input type="text" class="form-control" id="productName" name="productName" placeholder="Enter product name" required>
                    </div>

                    <div class="form-group">
                        <label for="productQuantity">Quantity</label>
                        <input type="number" class="form-control" id="productQuantity" name="productQuantity" placeholder="Enter quantity" required>
                    </div>

                    <div class="form-group">
                        <label for="productCategory">Category</label>
                        <select class="form-control" id="productCategory" name="productCategory" required>
                            <?php
                            $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
                            if ($conn->connect_error) {
                                die("Connection Failed: " . $conn->connect_error);
                            }
                            $sql = "SELECT category_name FROM categories";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option>" . htmlspecialchars($row['category_name']) . "</option>";
                                }
                            } else {
                                echo "<option>No categories available</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="productPrice">Unit Price</label>
                        <input type="number" class="form-control" id="productPrice" name="productPrice" placeholder="Enter product price" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="productSupplier">Supplier</label>
                        <select class="form-control" id="productSupplier" name="productSupplier" required>
                            <option value="">Select a supplier</option>
                            <?php
                            $sql = "SELECT SupplierName FROM suppliers";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option>" . htmlspecialchars($row['SupplierName']) . "</option>";
                                }
                            } else {
                                echo "<option>No suppliers available</option>";
                            }
                            $conn->close();
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="warehouse">Warehouse</label>
                        <select class="form-control" id="warehouse" name="warehouse" required>
                            <option value="">Select a warehouse level</option>
                            <option value="Level 1">Level 1</option>
                            <option value="Level 2">Level 2</option>
                            <option value="Level 3">Level 3</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="rowNumber">Row</label>
                        <input type="number" class="form-control" id="rowNumber" name="rowNumber" placeholder="Enter row number" required>
                    </div>

                    <div class="form-group">
                        <label for="columnNumber">Column</label>
                        <input type="number" class="form-control" id="columnNumber" name="columnNumber" placeholder="Enter column number" required>
                    </div>

                    <div class="form-group">
                        <label for="expirationDate">Expiration Date</label>
                        <input type="date" class="form-control" id="expirationDate" name="expirationDate" required>
                    </div>

                    <button type="submit" class="btn" style="background-color: #50B498; color: white;">Submit</button>
                    <button type="button" class="btn" style="background-color: #50B498; color: white;" data-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>



    </div>
    <?php else: ?>
    <div class="container mt-4" id="addProductForm">
        <p>You do not have permission to add or search products.</p>
    </div>
    <?php endif; ?>

    <br>

    <!-- Buttons to toggle view and add product form -->
    <div class="container mt-4 button-section">
        <div class="form-group">
            <label for="warehouseSelect">Filter by Warehouse</label>
            <select class="form-control" id="warehouseSelect" name="warehouseSelect" required>
                <option value="">Select a warehouse level</option>
                <option value="Level 1">Level 1</option>
                <option value="Level 2">Level 2</option>
                <option value="Level 3">Level 3</option>
            </select>
        </div>
       <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
            <div class="d-flex flex-column flex-md-row">
                <button id="viewProductsBtn" class="btn mb-2 mb-md-0" style="background-color: #50B498; color: white;">View Products</button>
                <form id="searchForm" class="d-flex align-items-center ml-md-2 mt-2 mt-md-0">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search products..." style="width: 100%; max-width: 160px;">
                    <button type="submit" class="btn ml-2" style="background-color: #50B498; color: white;">Search</button>
                </form>
            </div>


<!-- Edit Product Modal -->

<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProductModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

  <div id="errorAlert" class="alert alert-success alert-dismissible fade d-flex align-items-center justify-content-center" role="alert" style="display: none; "> 
    <span id="errorAlertMessage"></span>
</div>


                <form id="editProductForm">
                    <input type="hidden" id="editProductId" name="id">
                    <div class="mb-3">
                        <label for="editProductName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="editProductName" name="product_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <input type="text" class="form-control" id="editCategory" name="category" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPrice" class="form-label">Unit Price</label>
                        <input type="number" class="form-control" id="editPrice" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="editSupplier" class="form-label">Supplier</label>
                        <input type="text" class="form-control" id="editSupplier" name="supplier" required>
                    </div>
                    <div class="mb-3">
                        <label for="editWarehouse" class="form-label">Warehouse</label>
                        <input type="text" class="form-control" id="editWarehouse" name="warehouse" required>
                    </div>
                    <div class="mb-3">
                        <label for="editRowNumber" class="form-label">Row</label>
                        <input type="number" class="form-control" id="editRowNumber" name="row_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="editColumnNumber" class="form-label">Column</label>
                        <input type="number" class="form-control" id="editColumnNumber" name="column_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="editQuantity" class="form-label">Current Quantity</label>
                        <input type="number" class="form-control" id="editQuantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="editExpirationDate" class="form-label">Expiration Date</label>
                        <input type="date" class="form-control" id="editExpirationDate" name="expiration_date">
                    </div>
                    <button type="submit" class="btn "  style="background-color: #50B498; color: white;">Update Product</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Image Upload Modal -->
<div id="imageUploadModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadImageForm" enctype="multipart/form-data">
                    <input type="hidden" name="product_id" id="product_id" value="">
                    <div class="mb-3">
                        <label for="image" class="form-label">Choose an image</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn"  style="background-color: #50B498; color: white;">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>


            <?php if ($_SESSION['role'] == 'admin'): ?>
             
          <button id="addProductBtn" class="btn mt-3 mt-md-0" style="background-color: #50B498; color: white;" data-toggle="modal" data-target="#productModal">
        Add Product
    </button>
            <?php endif; ?>
        </div>
    </div>
    <br> 

    <!-- Display Products -->
    <div class="container mt-4" id="productList" style="display:none;">
        <div class="row">
            <div class="col-12">
                <div class="list-group" id="productContainer">
                    <!-- Dynamic list of products will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</main>
</div>
</div>


<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom JS -->
<script>
    document.getElementById('warehouseSelect').addEventListener('change', function() {
    const selectedWarehouse = this.value;

    if (selectedWarehouse) {
        fetch('view_products.php?warehouse=' + encodeURIComponent(selectedWarehouse))
            .then(response => response.text())
            .then(data => {
                document.getElementById('productContainer').innerHTML = data;
                document.getElementById('productList').style.display = 'block';
                document.getElementById('addProductForm').style.display = 'none';
            });
    }
});
  function fetchSuppliers() {
    fetch('get_suppliers.php')
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok ' + response.statusText);
        }
        return response.json();
      })
      .then(data => {
        console.log('Supplier data:', data); // Debugging: Check fetched data
        const supplierSelect = document.getElementById('productSupplier');
        supplierSelect.innerHTML = '<option value="">Select a supplier</option>';
        data.forEach(supplier => {
          const option = document.createElement('option');
          option.value = supplier.SupplierName; // Supplier name is used as the value
          option.textContent = `${supplier.SupplierName} `; // Supplier name and contact displayed
          supplierSelect.appendChild(option);
        });
      })
      .catch(error => console.error('Error fetching suppliers:', error));
  }

  document.addEventListener('DOMContentLoaded', fetchSuppliers);

  document.getElementById('viewProductsBtn').addEventListener('click', function() {
    document.getElementById('addProductForm').style.display = 'none';
    document.getElementById('productList').style.display = 'block';
    // Fetch and display products
    fetch('view_products.php')
      .then(response => response.text())
      .then(data => {
        document.getElementById('productContainer').innerHTML = data;
      });
  });

  document.getElementById('addProductBtn').addEventListener('click', function() {
    document.getElementById('productList').style.display = 'none';
    document.getElementById('addProductForm').style.display = 'block';
    document.getElementById('productForm').reset(); // Reset form for new product
    document.getElementById('productId').value = ''; // Clear hidden product ID

    // Make fields editable again for creating a new product
    document.getElementById('productCategory').readOnly = false;
    document.getElementById('productPrice').readOnly = false;
    document.getElementById('productSupplier').disabled = false;
    document.getElementById('warehouse').disabled = false;
    document.getElementById('rowNumber').readOnly = false;
    document.getElementById('columnNumber').readOnly = false;
    document.getElementById('productQuantity').readOnly = false;
    document.getElementById('expirationDate').readOnly = false;

    // Set the form mode to create
    document.getElementById('formMode').value = 'create';
});


document.getElementById('searchForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const query = document.getElementById('searchInput').value;
    fetch('search_products.php?query=' + encodeURIComponent(query))
        .then(response => response.text())
        .then(data => {
            document.getElementById('productContainer').innerHTML = data;
            document.getElementById('productList').style.display = 'block';
            document.getElementById('addProductForm').style.display = 'none';
        });
});




  function deleteProduct(id) {
    if (confirm('Are you sure you want to delete this product?')) {
      fetch('delete-product.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams('id=' + id)
      })
      .then(response => response.text())
      .then(data => {
        alert(data);
        document.getElementById('viewProductsBtn').click(); // Refresh product list
      });
    }
  }

function openImageUploadModal(productId) {
    document.getElementById('product_id').value = productId; // Set product ID in the hidden input
    var modal = new bootstrap.Modal(document.getElementById('imageUploadModal'));
    modal.show();
}

// Handle image upload form submission
document.getElementById('uploadImageForm').onsubmit = function(e) {
    e.preventDefault(); // Prevent the form from submitting normally
    var formData = new FormData(this);
    
    fetch('upload_image.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Handle the response
        location.reload(); // Reload the page to see the new image
    })
    .catch(error => console.error('Error:', error));
};

 </script>
<script>
function cancelForm() {
    // Hide the form and possibly navigate back or reset the form
    document.getElementById('addProductForm').style.display = 'none';
    // If you want to reset the form fields, you can uncomment the next line
    // document.getElementById('productForm').reset();
}

document.addEventListener('DOMContentLoaded', function () {
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');
    const messageElement = document.getElementById('message');

    // Reset message container
    messageElement.style.display = 'none';
    messageElement.classList.remove('alert-success', 'alert-danger');

    // Show message based on status
    if (status === 'success') {
        messageElement.innerHTML = '<strong>Success!</strong> New product created successfully.';
        messageElement.classList.add('alert-success');
        messageElement.style.display = 'block';
    } else if (status === 'not_in_stock') {
        messageElement.innerHTML = '<strong>Error!</strong> The product is not in stock with the required quantity.';
        messageElement.classList.add('alert-danger');
        messageElement.style.display = 'block';
    } else if (status === 'duplicate_location') {
        messageElement.innerHTML = '<strong>Error!</strong> A product already exists in this warehouse at the specified location.';
        messageElement.classList.add('alert-danger');
        messageElement.style.display = 'block';
    } else if (status === 'insert_error') {
        messageElement.innerHTML = '<strong>Error!</strong> There was an error inserting the product. Please try again.';
        messageElement.classList.add('alert-danger');
        messageElement.style.display = 'block';
    }
});

</script>
<script>
function openEditModal(id, productName, category, price, supplier, warehouse, rowNumber, columnNumber, quantity, expirationDate) {
    document.getElementById('editProductId').value = id;
    document.getElementById('editProductName').value = productName;
    document.getElementById('editCategory').value = category;
    document.getElementById('editPrice').value = price;
    document.getElementById('editSupplier').value = supplier;
    document.getElementById('editWarehouse').value = warehouse;
    document.getElementById('editRowNumber').value = rowNumber;
    document.getElementById('editColumnNumber').value = columnNumber;
    document.getElementById('editQuantity').value = quantity;
    document.getElementById('editExpirationDate').value = expirationDate || '';

    // Show the modal
    var editModal = new bootstrap.Modal(document.getElementById('editProductModal'));
    editModal.show();
}

document.getElementById('editProductForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Confirmation alert before submission
    if (!confirm('Are you sure you want to update this product?')) {
        return; // Stop if user cancels
    }

    var formData = new FormData(this);

    fetch('update_product.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            var editModal = bootstrap.Modal.getInstance(document.getElementById('editProductModal'));
            editModal.hide();

            // Success feedback with a toast
            const successToast = new bootstrap.Toast(document.getElementById('successToast'));
            document.getElementById('successToastBody').textContent = 'Product updated successfully!';
            successToast.show();

            // Delay reload for better UX
            setTimeout(() => location.reload(), 2000);
        } else {
            // Display server error in the alert box
            document.getElementById('errorAlertMessage').textContent = data.message;
            document.getElementById('errorAlert').style.display = 'block';
            document.getElementById('errorAlert').classList.add('show');
        }
    })
    .catch(error => {
        console.error('Error:', error);

        // Show a fallback error message for network errors
        document.getElementById('errorAlertMessage').textContent = 'Product Updated Successfully';
        document.getElementById('errorAlert').style.display = 'block';
        document.getElementById('errorAlert').classList.add('show');
    });
});

</script>





</body>
</html>