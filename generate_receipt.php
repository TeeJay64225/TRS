<?php
require('./copy/fpdf.php');
include('db.php');

if (!isset($_GET['receipt_id'])) {
    echo "No receipt ID provided.";
    exit();
}

$receipt_id = $_GET['receipt_id'];

$sql = "SELECT * FROM receipts WHERE id='$receipt_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Receipt not found.";
    exit();
}

$receipt = $result->fetch_assoc();

// Create instance of FPDF
$pdf = new FPDF();
$pdf->AddPage();

// Add receipt title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(0, 10, 'Receipt', 0, 1, 'C');

// Add receipt details
$pdf->SetFont('Arial', '', 12);
$pdf->Cell(0, 10, 'Receipt ID: ' . $receipt['id'], 0, 1);
$pdf->Cell(0, 10, 'Client ID: ' . $receipt['client_id'], 0, 1);
$pdf->Cell(0, 10, 'Amount: $' . $receipt['amount'], 0, 1);
$pdf->Cell(0, 10, 'Payment Date: ' . $receipt['payment_date'], 0, 1);
$pdf->Cell(0, 10, 'Payment Method: ' . $receipt['payment_method'], 0, 1);
$pdf->Cell(0, 10, 'Description: ' . $receipt['description'], 0, 1);

// Output PDF
$pdf->Output('I', 'receipt_' . $receipt_id . '.pdf');
?>
