<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $borrowerId = $_POST['borrowerId'];

    // Connect to the database
    $conn = new mysqli('localhost', 'root', '', 'inventoryproj');
    if ($conn->connect_error) {
        die("Connection Failed: " . $conn->connect_error);
    }

    // Sanitize input
    $borrowerId = $conn->real_escape_string($borrowerId);

    // Fetch borrower type
    $sql = "SELECT type FROM borrowers WHERE student_id = '$borrowerId' OR employee_id = '$borrowerId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo $row['type'];
    } else {
        echo "Invalid borrower ID.";
    }

    // Close the connection
    $conn->close();
}
?>