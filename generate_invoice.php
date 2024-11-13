

<?php
session_start();
require('./copy/fpdf.php');
include('db.php');

class PDF extends FPDF
{

    //footer
    function Footer()
    {
        $this->Image('can.png', 80, 5, 30, 30); // Example: logo at top right

        $this->SetY(-30);

        // Set the background color for the footer
        $this->SetFillColor(26, 102, 122); // deep heavy blue background

        // Draw a rounded rectangle for the footer background (with padding)
        $this->RoundedRect(10, $this->GetY(), 200, 20, 10, 'F'); // x, y, width, height, radius, 'F' for fill

        // Set the font for the text
        $this->SetFont('Arial', 'IB', 10);
        $this->SetTextColor(0, 0, 0); // Black text color

        // Add "Thank You" message
        $this->SetXY(10, $this->GetY() + 5); // Adjust Y to ensure the text is placed inside the rounded rectangle
        $this->Cell(0, 5, 'Thanks For make service with us(TRS)', 0, 1, 'C');

        // Add contact information
        $this->SetX(10); // Ensure consistent X positioning
        $this->Cell(0, 5, 'Contact us at: +123-456-7890 | hellotrs@reallygreatsite.com', 0, 1, 'C');
    }



    // Add this method to draw a rounded rectangle
    // RoundedRect function
    function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;

        if ($style == 'F') {
            $op = 'f'; // Fill
        } elseif ($style == 'FD' || $style == 'DF') {
            $op = 'B'; // Fill and stroke (border)
        } else {
            $op = 'S'; // Stroke only (border)
        }

        $MyArc = 3 / 3 * (sqrt(2) - 1); // Arc approximation for Bézier curve

        // Start from the top-left corner (without rounding)
        $this->_out(sprintf('%.2F %.2F m', ($x) * $k, ($hp - $y) * $k)); // Move to top-left corner

        // Top side: Draw a straight line to the top-right corner (without rounding on left)
        $xc = $x + $w - $r; // X-coordinate for the top-right corner
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k)); // Line to top-right corner

        // Top-right corner: Draw the arc
        $yc = $y + $r;
        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        // Right side: Draw the line down
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k)); // Right side line

        // Bottom-right corner: Draw the arc
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        // Bottom side: Draw the line from bottom-right to bottom-left (with rounding on bottom-left)
        $xc = $x + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k)); // Bottom side line

        // Bottom-left corner: Draw the arc
        $yc = $y + $h - $r;
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        // Left side: Draw the line up
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k)); // Left side line (no rounding at top-left)

        // Output the style (fill, stroke, etc.)
        $this->_out($op);
    }


    // Change the background for RoundedRect to light blue
    function Header()
    {
        // Set a new background color (deep heavy blue)
        $this->SetFillColor(26, 102, 122);

        // Draw a rounded rectangle background for the header
        $this->RoundedRect(0, 0, 110, 50, 5, 'F'); // Rounded rectangle with a 5px radius

        // Set text properties for the title
        $this->SetTextColor(255, 255, 255); // White text
        $this->SetFont('Arial', 'B', 30);

        // Position and add the TRS INVOICE text
        $this->SetXY(10, 5); // Set position to start within the rounded rect
        $this->Cell(100, 30, 'TRS INVOICE', 0, 0, 'L'); // Left aligned TRS

        // Insert an image (logo or other image)
        // Syntax: Image(file, x, y, width, height)


        // Reset text color to black for the rest of the document
        $this->SetTextColor(0, 0, 0);
        $this->Ln(1); // Move cursor down after the header
    }





    // Separate the two functions properly

    // RoundedRec function
    function RoundedRec($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));

        // Top right corner
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        // Right side
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        // Bottom side
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        // Left side
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc);
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

if (isset($_GET['invoice_id'])) {
    $invoice_id = $_GET['invoice_id'];

    // Fetch invoice details
    $stmt = $conn->prepare("SELECT * FROM invoices WHERE invoice_id = ?");
    $stmt->bind_param('i', $invoice_id);  // Use prepared statements to avoid SQL injection
    $stmt->execute();
    $invoice_result = $stmt->get_result();

    if ($invoice_result->num_rows == 0) {
        die("Invoice not found!");
    }

    $invoice = $invoice_result->fetch_assoc();

    // Fetch client details
    $client_id = $invoice['client_id'];
    $stmt = $conn->prepare("SELECT * FROM clients WHERE client_id = ?");
    $stmt->bind_param('i', $client_id);
    $stmt->execute();
    $client_result = $stmt->get_result();

    if ($client_result->num_rows == 0) {
        die("Client not found!");
    }

    $client = $client_result->fetch_assoc();

    // Fetch invoice items
    $stmt = $conn->prepare("SELECT * FROM invoice_items WHERE invoice_id = ?");
    $stmt->bind_param('i', $invoice_id);
    $stmt->execute();
    $items_result = $stmt->get_result();

    // Create PDF
    $pdf = new PDF('P', 'mm', 'A4');
    $pdf->AddPage();

    // Invoice Info with Background and Rounded Corners
    $pdf->SetFillColor(220, 220, 220); // Light gray background
    $pdf->RoundedRect(110, 0, 100, 50, 5, 'F'); // Rounded rectangle

    $pdf->SetFont('Courier', 'B', 13);
    $pdf->SetTextColor(0, 0, 0); // Black text
    $pdf->SetXY(100, 10); // Positioning
    $pdf->Cell(0, 10, "INVOICE NO:# " . $invoice['invoice_number'], 0, 1, 'R');
    $pdf->Cell(0, 10, "INVOICE DATE: " . date('d M Y', strtotime($invoice['date'])), 0, 1, 'R');
    $pdf->Cell(0, 10, 'City, 751001', 0, 1, 'R');
    $pdf->Cell(0, 10, 'Near DAV', 0, 1, 'R');
    // Invoice to section
    $pdf->SetFillColor(173, 216, 230); // Light blue background
    $pdf->RoundedRect(15, 65, 180, 50, 10, 'F');
    $pdf->SetFont('Arial', 'B', 30);
    $pdf->SetXY(20, 85);
    $pdf->Cell(100, 10, 'INVOICE TO:', 0, 1);

    $pdf->SetFont('Arial', 'B', 20);
    $pdf->SetXY(120, 80);
    $pdf->Cell(100, 10, $client['name'], 0, 1);
    $pdf->SetXY(120, 90);
    $pdf->Cell(100, 10, $client['phone'], 0, 1);
    $pdf->SetXY(120, 100);
    $pdf->Cell(100, 10, $client['client_id'], 0, 1);

    $pdf->Ln(10); // Add space after the section


    // Ensure the function invoice_info is inside the PDF class if using $this in it.




    // Table Header with Blue Background


    // Then call the function like this:
    function table_header($pdf) {}

    $pdf->SetFont('Arial', 'B', 14);
    $pdf->SetFillColor(26, 102, 122); // Deep heavy blue background
    $pdf->SetTextColor(255, 255, 255); // White text
    $pdf->Cell(15, 10, 'SL', 1, 0, 'C', true);
    $pdf->Cell(75, 10, 'DESCRIPTION', 1, 0, 'C', true);
    $pdf->Cell(45, 10, 'QTY', 1, 0, 'C', true);
    $pdf->Cell(53, 10, 'UNIT PRICE', 1, 1, 'C', true);

    // Reset text color to black for rows
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(2); // Add space after the section

    // Variables to store totals
    $total_sub = 0;
    $total_tax = 0;
    $grand_total = 0;
    $sl = 1;


    function table_row($pdf, $sl, $item, $x1 = 10, $y1 = null)
    {
        // Set the starting position for the row (use $y1 to set the position dynamically)
        if ($y1 === null) {
            $y1 = $pdf->GetY(); // Get the current Y position if not specified
        }

        // Set the background color for the row (adjust the color as needed)
        $pdf->SetFillColor(240, 240, 240); // Light gray background

        // Draw a single rounded rectangle for the entire row
        $pdf->RoundedRect($x1, $y1, 190, 12, 5, 'F');  // Whole row, width 190, height 12, with 5px radius

        // Set the font for the text
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetTextColor(0, 0, 0); // Black text

        // Add text for each column
        $pdf->SetXY($x1 + 5, $y1 + 3); // Small padding inside the rounded rectangle
        $pdf->Cell(8, 6, $sl, 0, 0, 'C');  // Serial Number column

        $pdf->SetXY($x1 + 40, $y1 + 3); // Description column with padding
        $pdf->Cell(70, 6, $item['description'], 0, 0, 'L');

        $pdf->SetXY($x1 + 105, $y1 + 3); // Quantity column with padding
        $pdf->Cell(30, 6, $item['quantity'], 0, 0, 'C');

        $pdf->SetXY($x1 + 135, $y1 + 3); // Unit Price column with padding
        $pdf->Cell(30, 6, "$" . number_format($item['unit_price'], 2), 0, 1, 'R');

        // Add spacing between rows
        $pdf->Ln(4); // Adjust this value for more or less spacing between rows
    }


    // Initialize subtotal, tax, and counter
    $total_sub = 0;
    $total_tax = 0;
    $sl = 1;

    // Add table rows for invoice items
    while ($item = $items_result->fetch_assoc()) {
        // Calculate totals
        $total_sub += $item['quantity'] * $item['unit_price'];
        $total_tax += ($item['quantity'] * $item['unit_price']) * 0.18; // Assuming 18% tax

        // Call the table_row function to add a row for each item
        table_row($pdf, $sl++, $item);
    }

    // Calculate grand total
    $grand_total = $total_sub + $total_tax;






    // Table Row with Rounded Corners for the Whole Row and Small Spacing


    $pdf->Ln(15); // Add some vertical space
    // Add a horizontal line above the totals section
    $pdf->Cell(0, 0, '', 'T'); // This adds a top border to create a horizontal line

    $pdf->Ln(2);
    $pdf->Ln(2);

    // Set background color for the subtotal and tax rows
    $pdf->SetFillColor(26, 102, 122); // deep heavy blue background
    $pdf->SetTextColor(0, 0, 0); // Black text

    // Subtotal
    $pdf->RoundedRect(110, $pdf->GetY(), 90, 10, 3, 'F'); // Rounded corners for the background
    $pdf->SetFillColor(173, 216, 230); // Light blue background
    $pdf->SetXY(55, $pdf->GetY() + 2);
    $pdf->Cell(100, 6, 'Subtotal', 0, 0, 'R');
    $pdf->Cell(40, 6, "$" . number_format($total_sub, 2), 0, 1, 'R');
    $pdf->Ln(2); // Small space after row

    // Discount
    $pdf->RoundedRect(110, $pdf->GetY(), 90, 10, 3, 'F'); // Rounded corners for the background
    $pdf->SetXY(55, $pdf->GetY() + 2);
    $pdf->Cell(100, 6, 'Discount', 0, 0, 'R');
    $pdf->Cell(40, 6, "$" . number_format($discount, 2), 0, 1, 'R');
    $pdf->Ln(2); // Small space after row

    // Tax
    $pdf->RoundedRect(110, $pdf->GetY(), 90, 10, 3, 'F'); // Same style for tax
    $pdf->SetFillColor(26, 102, 122); // deep heavy blue background
    $pdf->SetXY(55, $pdf->GetY() + 2);
    $pdf->Cell(100, 6, 'Tax (18%)', 0, 0, 'R'); // Corrected tax percentage label
    $pdf->Cell(40, 6, "$" . number_format($total_tax, 2), 0, 1, 'R');
    $pdf->Ln(2);

    // Set red background and white text for the TOTAL row
    $pdf->SetFillColor(255, 0, 0); // Red background
    $pdf->RoundedRect(110, $pdf->GetY(), 90, 12, 5, 'F'); // Rounded corners for TOTAL
    $pdf->SetXY(55, $pdf->GetY() + 3); // Adjust position slightly to center text

    // TOTAL row
    $pdf->SetFont('Arial', 'B', 15); // Bold and larger font for the total
    $pdf->SetTextColor(0, 0, 0); // Black text
    $pdf->Cell(100, 6, 'TOTAL', 0, 0, 'R');
    $pdf->Cell(40, 6, "$" . number_format($grand_total, 2), 0, 1, 'R');

    // Reset text color back to black
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln(5); // Add some space after the totals section

    // Calculate grand total
    $grand_total = $total_sub - $discount + $total_tax;








    // Output the PDF
    $pdf->Output();
} else {
    echo "No invoice ID provided!";
}
