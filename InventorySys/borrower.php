
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $borrowerName = $_POST['borrowerName'];
    $borrowerType = $_POST['borrowerType'];
    $borrowerEmail = $_POST['borrowerEmail'];

    // Additional fields
    $studentID = isset($_POST['studentID']) ? $_POST['studentID'] : null;
    $grade = isset($_POST['grade']) ? $_POST['grade'] : null;
    $employeeID = isset($_POST['employeeID']) ? $_POST['employeeID'] : null;
    $department = isset($_POST['department']) ? $_POST['department'] : null;

    // Database connection
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    if ($borrowerType === 'Student') {
        $stmt = $conn->prepare("INSERT INTO borrowers (name, type, email, student_id, grade) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $borrowerName, $borrowerType, $borrowerEmail, $studentID, $grade);
    } elseif ($borrowerType === 'Teacher') {
        $stmt = $conn->prepare("INSERT INTO borrowers (name, type, email, employee_id, department) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $borrowerName, $borrowerType, $borrowerEmail, $employeeID, $department);
    } else {
        $stmt = $conn->prepare("INSERT INTO borrowers (name, type, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $borrowerName, $borrowerType, $borrowerEmail);
    }

    if ($stmt->execute()) {
        echo "Borrower added successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
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
                    <h3><b>Add Borrower</h3>
                    <form id="borrowerForm" action="borrower.php" method="POST">
                        <div class="form-group">
                            <label for="borrowerName">Name</label>
                            <input type="text" class="form-control" id="borrowerName" name="borrowerName" placeholder="Enter name" required>
                        </div>
                        <div class="form-group">
                            <label for="borrowerType">Borrower Type</label>
                            <select class="form-control" id="borrowerType" name="borrowerType" required>
                                <option value="">Select Type</option>
                                <option value="Student">Student</option>
                                <option value="Teacher">Teacher</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="borrowerEmail">Email</label>
                            <input type="email" class="form-control" id="borrowerEmail" name="borrowerEmail" placeholder="Enter email" required>
                        </div>

                        <div id="studentFields" class="conditional-fields">
                            <div class="form-group">
                                <label for="studentID">Student ID</label>
                                <input type="text" class="form-control" id="studentID" name="studentID" placeholder="Enter student ID">
                            </div>
                            <div class="form-group">
                                <label for="grade">Year Level</label>
                                <input type="text" class="form-control" id="grade" name="grade" placeholder="Enter grade">
                            </div>
                        </div>

                        <div id="teacherFields" class="conditional-fields">
                            <div class="form-group">
                                <label for="employeeID">Employee ID</label>
                                <input type="text" class="form-control" id="employeeID" name="employeeID" placeholder="Enter employee ID">
                            </div>
                            <div class="form-group">
                                <label for="department">Department</label>
                                <input type="text" class="form-control" id="department" name="department" placeholder="Enter department">
                            </div>
                        </div>

                        <button type="submit" class="btn" style="background-color: #50B498; color: white;">Submit</button>
                    </form>

                    <h4 class="mt-4"><b>List of Borrowers</h4>
                    <!-- Search Box for Borrowers -->
        <div class="form-group">
            <input type="text" id="searchBorrowerID" class="form-control" placeholder="Search Borrower by ID" oninput="searchBorrowers()">
        </div>
                  
        <h5>Students</h5>
        <div class="table-responsive">
            <table class="table table-bordered" id="studentsTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Student ID</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Student data will be dynamically added here -->
                </tbody>
            </table>

            <h5>Teachers</h5>
            <table class="table table-bordered" id="teachersTable">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Employee ID</th>
                        <th>Department</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Teacher data will be dynamically added here -->
                </tbody>
            </table>
        </div>
    
                <!-- Bootstrap JS and dependencies -->
                <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
                <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

                <!-- Custom JS -->
                <script>
                    document.getElementById('borrowerType').addEventListener('change', function() {
                        var studentFields = document.getElementById('studentFields');
                        var teacherFields = document.getElementById('teacherFields');
                        var type = this.value;

                        if (type === 'Student') {
                            studentFields.style.display = 'block';
                            teacherFields.style.display = 'none';
                        } else if (type === 'Teacher') {
                            studentFields.style.display = 'none';
                            teacherFields.style.display = 'block';
                        } else {
                            studentFields.style.display = 'none';
                            teacherFields.style.display = 'none';
                        }
                    });

                    // Fetch and display borrowers
// Fetch and display borrowers
        function loadBorrowers() {
            fetch('list_borrower.php')
                .then(response => response.json())
                .then(data => {
                    const studentsTableBody = document.querySelector('#studentsTable tbody');
                    const teachersTableBody = document.querySelector('#teachersTable tbody');

                    studentsTableBody.innerHTML = '';
                    data.students.forEach(student => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${student.name}</td>
                            <td>${student.email}</td>
                            <td>${student.id}</td>
                            <td>${student.grade}</td>
                        `;
                        studentsTableBody.appendChild(row);
                    });

                    teachersTableBody.innerHTML = '';
                    data.teachers.forEach(teacher => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${teacher.name}</td>
                            <td>${teacher.email}</td>
                            <td>${teacher.id}</td>
                            <td>${teacher.department}</td>
                        `;
                        teachersTableBody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error fetching borrower data:', error));
        }

        // Search borrowers by ID
        function searchBorrowers() {
            const searchValue = document.getElementById('searchBorrowerID').value.toLowerCase();
            const studentsTableBody = document.querySelector('#studentsTable tbody');
            const teachersTableBody = document.querySelector('#teachersTable tbody');

            // Filter students
            Array.from(studentsTableBody.querySelectorAll('tr')).forEach(row => {
                const studentID = row.children[2].textContent.toLowerCase(); // Student ID is in the third column
                row.style.display = studentID.includes(searchValue) ? '' : 'none';
            });

            // Filter teachers (assuming Employee ID is in the third column)
            Array.from(teachersTableBody.querySelectorAll('tr')).forEach(row => {
                const employeeID = row.children[2].textContent.toLowerCase(); // Employee ID is in the third column
                row.style.display = employeeID.includes(searchValue) ? '' : 'none';
            });
        }

        // Initial load of borrower data
        loadBorrowers();
    </script>
</main>

        </div>
    </div>
</body>
</html>