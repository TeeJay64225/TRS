<?php

require_once('./copy/fpdf.php');  // Ensure the path is correct
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image('TRS.png', 10, 10, 30, 'PNG'); // Adjust the path and size as needed
$pdf->Output();
?>

include('db.php');

if (!isset($_SESSION['user_id'])) {
header("Location: login.php");
exit();
}

if (isset($_GET['invoice_id'])) {
$invoice_id = $_GET['invoice_id'];

// Fetch invoice details
$invoice_query = "SELECT * FROM invoices WHERE invoice_id = '$invoice_id'";
$invoice_result = $conn->query($invoice_query);
$invoice = $invoice_result->fetch_assoc();

// Fetch client details
$client_id = $invoice['client_id'];
$client_query = "SELECT * FROM clients WHERE client_id = '$client_id'";
$client_result = $conn->query($client_query);
$client = $client_result->fetch_assoc();

// Fetch invoice items
$items_query = "SELECT * FROM invoice_items WHERE invoice_id = '$invoice_id'";
$items_result = $conn->query($items_query);


}
// Create PDF
$pdf = new FPDF();
$pdf->AddPage();

// Set font and add the invoice title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(71, 10, '', 0, 0); // Empty cell for spacing
$pdf->Cell(59, 5, 'Invoice', 0, 0);
$pdf->Cell(59, 10, '', 0, 1); // Move to the next line



// Add company name and details
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(71, 5, 'TRS', 0, 0); // Company Name
$pdf->Image(71, 5, '../TRS copy 2/img/TRS.jpg', 0, 0); // Adjust the path and size as needed
$pdf->Cell(59, 5, '', 0, 0); // Empty cell for spacing
$pdf->Cell(59, 5, 'Details', 0, 1); // Details text

// Add company address and invoice details
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(130, 5, 'Near DAV', 0, 0); // Company Address
$pdf->Cell(25, 5, 'Customer ID', 0, 0);
$pdf->Cell(34, 5, $client['client_id'], 0, 1); // Customer ID

$pdf->Cell(130, 5, 'City, 751001', 0, 0); // City and Zip Code
$pdf->Cell(25, 5, 'Invoice Date', 0, 0);
$pdf->Cell(34, 5, date('d M Y', strtotime($invoice['date'])), 0, 1); // Invoice Date

$pdf->Cell(130, 5, '', 0, 0); // Empty cell for spacing
$pdf->Cell(25, 5, 'Invoice Number', 0, 0);
$pdf->Cell(34, 5, '#'. $invoice['invoice_number'], 0, 1); // Invoice Number

// Add "Bill to" section with client name
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(130, 5, 'Bill to', 0, 0);
$pdf->Cell(59, 5, $client['name'], 0, 0); // Dynamic client name
$pdf->Cell(189, 10, '', 0, 1); // Move to the next line

// Add table header
$pdf->Cell(50, 10, '', 0, 1); // Empty cell for spacing
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(10, 6, 'SL', 1, 0, 'C'); // Serial Number
$pdf->SetFillColor(200, 220, 255); // Light blue background
$pdf->Cell(50, 6, 'Description', 1, 0, 'C', true); // Item Description
$pdf->Cell(23, 6, 'QTY', 1, 0, 'C', true); // Quantity
$pdf->Cell(30, 6, 'Unit Price', 1, 1, 'C', true); // Unit Price

// Variables to store totals
$total_tax = 0;
$total_sub = 0;
$total_grand = 0;
$sl = 1;

// Add table rows with invoice data
$pdf->SetFont('Arial', '', 10);
while ($item = $items_result->fetch_assoc()) {
$qty = $item['quantity'];
$unit_price = $item['unit_price'];
$description = $item['description'];
$tax = $item['tax']; // Assuming there's a tax column in invoice_items
$discount = $item['discount'];
$total_sub += $unit_price * $qty - $discount;
$grand_total = $total_sub + $tax;

$pdf->Cell(10, 6, $sl++, 1, 0, 'C'); // Serial Number
$pdf->Cell(50, 6, $description, 1, 0); // Item Description
$pdf->Cell(23, 6, $qty, 1, 0, 'R'); // Quantity
$pdf->Cell(30, 6, number_format($unit_price, 2), 1, 1, 'R'); // Unit Price

// Accumulate totals


}

// Move to the bottom of the page
$pdf->Cell(130, 6, '', 0, 1); // Move to next line for the total row spacing


// Output totals at the bottom right of the table
$pdf->SetFont('Arial', 'B', 10);
$pdf->SetFillColor(255, 255, 255); // White background for totals
$pdf->SetTextColor(0, 0, 0); // Black text color

$pdf->Cell(113, 6, '', 0, 0); // Empty cells to align the totals at the bottom
$pdf->Cell(25, 6, 'Sub Total', 1, 0, 'R', true); // Subtotal label
$pdf->Cell(25, 6, number_format($total_sub, 2), 1, 1, 'R', true); // Subtotal amount

$pdf->Cell(113, 6, '', 0, 0); // Empty cells to align the totals at the bottom
$pdf->Cell(25, 6, 'Discount', 1, 0, 'R', true); // Discount label
$pdf->Cell(25, 6, number_format($discount, 2), 1, 1, 'R', true); // Discount amount

$pdf->Cell(113, 6, '', 0, 0); // Empty cells to align the totals at the bottom
$pdf->Cell(25, 6, 'Tax', 1, 0, 'R', true); // Tax label
$pdf->Cell(25, 6, number_format($tax, 2), 1, 1, 'R', true); // Tax amount

$pdf->Cell(113, 6, '', 0, 0); // Empty cells to align the totals at the bottom
$pdf->Cell(25, 6, 'Grand Total', 1, 0, 'R', true); // Grand Total label
$pdf->Cell(25, 6, number_format($grand_total, 2), 1, 0, 'R', true);
// Output the PDF