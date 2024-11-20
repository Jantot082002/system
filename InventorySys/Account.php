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

// Fetch user information
$username = $_SESSION['username'];
$stmt = $conn->prepare("SELECT * FROM registration WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Handle profile picture update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $tmp_name = $_FILES['profile_picture']['tmp_name'];
        $name = basename($_FILES['profile_picture']['name']);
        $upload_file = $upload_dir . $name;

        // Validate file type and size if necessary
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['profile_picture']['type'], $allowed_types) && $_FILES['profile_picture']['size'] < 5000000) {
            // Check if the upload directory exists
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true); // Create the directory with proper permissions
            }

            // Move the uploaded file to the designated directory
            if (move_uploaded_file($tmp_name, $upload_file)) {
                // Update profile picture path in the database
                $stmt_update_picture = $conn->prepare("UPDATE registration SET profile_picture = ? WHERE username = ?");
                $stmt_update_picture->bind_param("ss", $upload_file, $username);
                if ($stmt_update_picture->execute()) {
                    echo '<script>alert("Profile picture updated successfully!"); window.location.href = "Account.php";</script>';
                } else {
                    echo '<script>alert("Failed to update profile picture in database.");</script>';
                }
                $stmt_update_picture->close();
            } else {
                echo '<script>alert("Failed to upload profile picture. Check directory permissions.");</script>';
            }
        } else {
            echo '<script>alert("Invalid file type or size.");</script>';
        }
    } else {
        echo '<script>alert("No file uploaded or upload error.");</script>';
    }
}

// Close statement and connection
$stmt->close();
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
  
      .profile-picture-container {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 150px; /* Ensure the width matches the height */
    height: 150px; /* Ensure the height matches the width */
    border-radius: 50%;
    overflow: hidden;
    border: 2px solid #ddd; /* Optional border */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Optional shadow */
}
    .profile-picture-container img {
        display: block;
        max-width: 100%;
        height: auto;
        border-radius: 50%;
    }
    .user-info p {
        font-size: 1.1rem;
        line-height: 1.5;
    }
    .btn {
        margin-top: 10px;
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
                <b><a class="nav-link" href="Login.php">Logout</a></b>
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
                <b>
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
            </b>
            </div>

     <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
    <h3><b>Profile</b></h3>
    <div class="card mb-4">
        <div class="card-header">
            Profile Information
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Profile Picture -->
                <div class="col-md-4 text-center">
                   <div class="profile-picture-container">
    <?php if (!empty($user['profile_picture'])): ?>
        <img src="<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="img-fluid profile-picture">
    <?php else: ?>
        <img src="default-profile.png" alt="Default Profile Picture" class="img-fluid profile-picture">
    <?php endif; ?>
</div>
                 <!-- Upload Form -->
<form method="POST" action="" enctype="multipart/form-data" class="mt-3">
    <div class="form-group">
        <input type="file" id="profile_picture" name="profile_picture" class="form-control-file">
    </div>
    <div class="form-group d-flex justify-content-start">
        <button type="submit" class="btn" style="background-color: #50B498; color: white;">Upload</button>
        <a href="change_password.php" class="btn ml-2" style="background-color: #50B498; color: white;">Change Password</a>
    </div>
</form>
                </div>
                <!-- User Info -->
                <div class="col-md-8">
                    <div class="user-info">
                        <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
                        <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                        <p><strong>Role:</strong> <?php echo htmlspecialchars($user['role']); ?></p>
                        <!-- Add more user information here if needed -->
                    </div>
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
</body>
</html>