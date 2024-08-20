<?php
session_start();
require('./copy/fpdf.php');
include('db.php');

class PDF extends FPDF
{
    // Custom method to draw a rectangle with rounded corners
    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'DF' || $style == 'FD')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    // Helper function to draw an arc
    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['receipt_id'])) {
    $receipt_id = $_GET['receipt_id'];

    // Fetch receipt details
    $receipt_query = "SELECT * FROM receipts WHERE id = '$receipt_id'";
    $receipt_result = $conn->query($receipt_query);
    $receipt = $receipt_result->fetch_assoc();

    // Fetch client details
    $client_id = $receipt['client_id'];
    $client_query = "SELECT * FROM clients WHERE client_id = '$client_id'";
    $client_result = $conn->query($client_query);
    $client = $client_result->fetch_assoc();

    // Fetch receipt items
    $items_query = "SELECT * FROM receipt_items WHERE receipt_id = '$receipt_id'";
    $items_result = $conn->query($items_query);

    // Create PDF
    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Add company logo
    $pdf->Image('can.png', 10, 3, 30, 30); // Adjust the path and size as needed

    // Set font and add the invoice title with a styled font
    $pdf->SetFont('Arial', 'B', 24);
    $pdf->SetTextColor(0, 102, 204); // Custom blue color
    $pdf->Cell(80, 10, '', 0, 0); // Empty cell for spacing
    $pdf->Cell(30, 10, 'RECEIPT', 0, 1, 'C'); // Center the title
    $pdf->Ln(10); // Add some vertical space

    // Add company name and details
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetTextColor(33, 33, 33); // Dark gray color
    $pdf->Cell(130, 10, 'TRS', 0, 0); // Company Name
    $pdf->SetFont('Arial', 'I', 10);
    $pdf->SetTextColor(100, 100, 100); // Lighter gray for details
    $pdf->Cell(30, 10, 'Details', 0, 1, 'C');

    // Add company address and invoice details with a background color
    $pdf->SetFont('Arial', '', 12);
    $pdf->SetFillColor(230, 230, 230); // Light gray background
    $pdf->Cell(130, 10, 'Near DAV', 0, 0, '', true); // Company Address with background
    $pdf->Cell(30, 10, 'Customer ID:', 0, 0);
    $pdf->Cell(30, 10, $client['client_id'], 0, 1, '', true); // Customer ID with background

    $pdf->Cell(130, 10, 'City, 751001', 0, 0, '', true); // City and Zip Code with background
    $pdf->Cell(30, 10, 'Receipt Date:', 0, 0);
    $pdf->Cell(30, 10, date('d M Y', strtotime($receipt['receipt_date'])), 0, 1, '', true); // Receipt Date

    $pdf->Cell(130, 5, '', 0, 0); // Empty cell for spacing
    $pdf->Cell(25, 5, 'Receipt Number', 0, 0);
    $pdf->Cell(34, 5, '#' . $receipt['receipt_number'], 0, 1, '', true); // Receipt Number

    // Add "Bill to" section with client name
    $pdf->SetFont('Arial', 'B', 15);
    $pdf->SetTextColor(0, 102, 204); // Blue color for "Bill to"
    $pdf->Cell(130, 10, 'Bill to:', 0, 0);
    $pdf->SetTextColor(33, 33, 33); // Dark gray for client name
    $pdf->Cell(59, 10, $client['name'], 0, 1);

    // Add table header with rounded corners and background color
    $pdf->Ln(5); // Add some vertical space
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(200, 220, 255); // Light blue background
    $pdf->SetTextColor(0, 0, 0); // Black text color

    // Draw rounded rectangles for the header cells
    $pdf->RoundedRect(10, $pdf->GetY(), 10, 8, 2, 'DF'); // Serial Number
    $pdf->RoundedRect(20, $pdf->GetY(), 90, 8, 2, 'DF'); // Item Description
    $pdf->RoundedRect(110, $pdf->GetY(), 30, 8, 2, 'DF'); // Quantity
    $pdf->RoundedRect(140, $pdf->GetY(), 30, 8, 2, 'DF'); // Unit Price

    // Add the header text
    $pdf->Cell(10, 8, 'SL', 0, 0, 'C', true); // Serial Number
    $pdf->Cell(90, 8, 'Description', 0, 0, 'C', true); // Item Description
    $pdf->Cell(30, 8, 'QTY', 0, 0, 'C', true); // Quantity
    $pdf->Cell(30, 8, 'Unit Price', 0, 1, 'C', true); // Unit Price

    // Variables to store totals
    $total_sub = 0;
    $total_grand = 0;
    $sl = 1;
    $tax = $receipts['tax'];
    // Add table rows with receipt data
    $pdf->SetFont('Arial', '', 10);
    while ($item = $items_result->fetch_assoc()) {
        $qty = $item['quantity'];
        $product_id = $item['product_id'];
        $product_query = "SELECT name, price FROM products WHERE id = '$product_id'";
        $product_result = $conn->query($product_query);
        $product = $product_result->fetch_assoc();
        // Fetch receipt details
        $receipt_query = "SELECT * FROM receipts WHERE id = '$receipt_id'";
        $receipt_result = $conn->query($receipt_query);
        $receipt = $receipt_result->fetch_assoc();
        
        $description = $product['name'];
        $unit_price = $product['price'];
        $tax = $receipt['tax'];
        $discount = $item['discount'];
        $total_sub = $qty * $unit_price - $discount;

        $total_sub += $subtotal;
        $grand_total = $total_sub + $receipt['tax'];

        $pdf->Cell(10, 6, $sl++, 1, 0, 'C'); // Serial Number
        $pdf->Cell(90, 6, $description, 1, 0); // Item Description
        $pdf->Cell(30, 6, $qty, 1, 0, 'R'); // Quantity
        $pdf->Cell(30, 6, number_format($unit_price, 2), 1, 1, 'R'); // Unit Price
    }

    // Add the header text
    $pdf->Cell(10, 8, '', 0, 0, 'C', true); // Serial Number
    $pdf->Cell(90, 8, '', 0, 0, 'C', true); // Item Description
    $pdf->Cell(30, 8, '', 0, 0, 'C', true); // Quantity
    $pdf->Cell(30, 8, '', 0, 1, 'C', true); // Unit Price

    // Add a horizontal line above the totals section
    $pdf->Cell(0, 0, '', 'T'); // This adds a top border to create a horizontal line

    // Add totals at the bottom
    $pdf->Ln(5); // Add some vertical space
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->SetFillColor(230, 230, 230); // Light gray background
    $pdf->SetTextColor(0, 0, 0); // Black text color

    $pdf->Cell(110, 6, '', 0, 0); // Empty cells to align the totals at the bottom
    $pdf->Cell(25, 6, 'Subtotal', 1, 0, 'R', true); // Subtotal label
    $pdf->Cell(25, 6, number_format($total_sub, 2), 1, 1, 'R', true); // Subtotal amount

    $pdf->Cell(110, 6, '', 0, 0); // Empty cells to align the totals at the bottom
    $pdf->Cell(25, 6, 'Discount(-):', 1, 0, 'R', true); // Discount label
    $pdf->Cell(25, 6, number_format($discount, 2), 1, 1, 'R', true); // Discount amount

    $pdf->Cell(110, 6, '', 0, 0); // Empty cells to align the totals at the bottom
    $pdf->Cell(25, 6, 'Tax (+15%)', 1, 0, 'R', true); // Tax label
    $pdf->Cell(25, 6, number_format($tax, 2), 1, 1, 'R', true); // Tax amount

    $pdf->Cell(110, 6, '', 0, 0); // Empty cells to align the totals at the bottom
    $pdf->Cell(25, 6, 'Grand Total', 1, 0, 'R', true); // Grand Total label
    $pdf->Cell(25, 6, number_format($grand_total, 2), 1, 1, 'R', true); // Grand Total amount

    // Add a horizontal line above the totals section
    $pdf->Cell(0, 0, '', 'T'); // This adds a top border to create a horizontal line
    // Add a note section
    $pdf->Ln(5); // Add some vertical space
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->SetTextColor(100, 100, 100); // Lighter gray for the note
    $pdf->MultiCell(190, 10, 'Note: This is a sample note section. Thanks For make service with us(TRS).', 0, 'L');
    // Output the PDF
    $pdf->Output();
} else {
    echo "No invoice ID provided!";
}
