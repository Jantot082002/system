<?php
// Include TCPDF library
require_once('C:\Users\USER-PC\Desktop\my-xampp\htdocs\InventorySys\vendor\tecnickcom\tcpdf\tcpdf.php');

// Create a new TCPDF instance
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('CBIT_Inventory_Management_System');
$pdf->SetTitle('Product List');
$pdf->SetSubject('Products and Expired Products');

// Add a page
$pdf->AddPage();

// Set font for the header
$pdf->SetFont('helvetica', 'B', 10);

// Title of the document
$pdf->Cell(0, 10, 'Product List', 0, 1, 'C');

// Set font for the table content
$pdf->SetFont('helvetica', '', 8);

// Define the table headers with minimized space
$headers = array('Product Name', 'Category', 'Unit Price', 'Supplier', 'Warehouse', 'Row', 'Column', 'Quantity', 'Status', 'Created At', 'Expiration Date');

// Fetch all products
$conn = new mysqli('localhost', 'root', '', 'inventoryproj');
if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// Products Query
$sql = "SELECT * FROM products WHERE expiration_date >= CURDATE() ORDER BY created_at ASC";
$result = $conn->query($sql);

// Create the table header row
$pdf->Ln(5);
foreach ($headers as $header) {
    $pdf->Cell(18, 6, $header, 1, 0, 'C');
}
$pdf->Ln();

// Add product rows
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(18, 6, $row['product_name'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['category'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['price'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['supplier'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['warehouse'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['row_number'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['column_number'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['quantity'], 1, 0, 'C');
        
        // Determine product status based on quantity
        $status = '';
        if ($row['quantity'] > 50) {
            $status = 'In Stock';
        } elseif ($row['quantity'] > 1) {
            $status = 'Low Stock';
        } else {
            $status = 'Out of Stock';
        }
        $pdf->Cell(18, 6, $status, 1, 0, 'C');
        $pdf->Cell(18, 6, $row['created_at'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['expiration_date'], 1, 0, 'C');
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No products found.', 0, 1, 'C');
}

// Fetch expired products
$expiredSql = "SELECT * FROM products WHERE expiration_date < CURDATE() ORDER BY expiration_date ASC";
$expiredResult = $conn->query($expiredSql);

// Create the expired products section
$pdf->Ln(10);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(0, 10, 'Expired Products', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 8);

// Add expired product table headers
$pdf->Ln(5);
foreach ($headers as $header) {
    $pdf->Cell(18, 6, $header, 1, 0, 'C');
}
$pdf->Ln();

// Add expired product rows
if ($expiredResult->num_rows > 0) {
    while ($row = $expiredResult->fetch_assoc()) {
        $pdf->Cell(18, 6, $row['product_name'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['category'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['price'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['supplier'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['warehouse'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['row_number'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['column_number'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['quantity'], 1, 0, 'C');
        $pdf->Cell(18, 6, 'Expired', 1, 0, 'C');
        $pdf->Cell(18, 6, $row['created_at'], 1, 0, 'C');
        $pdf->Cell(18, 6, $row['expiration_date'], 1, 0, 'C');
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No expired products found.', 0, 1, 'C');
}

// Output the PDF
$pdf->Output('products_list.pdf', 'I');
?>
