<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $date = $_POST['date'];
    $items = $_POST['items'];
    $quantities = $_POST['quantities'];
    $unit_prices = $_POST['unit_prices'];
    $total_amount = 0;

    // Insert invoice
    $sql = "INSERT INTO invoices (client_id, date, total_amount, status) VALUES ('$client_id', '$date', 0, 'Pending')";
    if ($conn->query($sql) === TRUE) {
        $invoice_id = $conn->insert_id;

        // Insert invoice items and calculate total amount
        for ($i = 0; $i < count($items); $i++) {
            $description = $items[$i];
            $quantity = $quantities[$i];
            $unit_price = $unit_prices[$i];
            $total_price = $quantity * $unit_price;
            $total_amount += $total_price;

            $sql = "INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, total_price) VALUES ('$invoice_id', '$description', '$quantity', '$unit_price', '$total_price')";
            $conn->query($sql);
        }

        // Update total amount in invoice
        $sql = "UPDATE invoices SET total_amount='$total_amount' WHERE invoice_id='$invoice_id'";
        $conn->query($sql);


        echo "invoice created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch clients for the client selection dropdown
$sql = "SELECT * FROM clients";
$clients_result = $conn->query($sql);
?>
<?php include('subfolder/main.php'); ?>

<?php
require('./copy/fpdf.php');

// Create an instance of FPDF
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->Image('TRS.png', 0, 0,);
// Set font and add the invoice title
$pdf->SetFont('Arial', 'B', 16);
$pdf->Cell(71, 10, '', 0, 0); // Empty cell for spacing
$pdf->Cell(59, 5, 'Invoice', 0, 0);
$pdf->Cell(59, 10, '', 0, 1); // Move to the next line

// Add company name and details
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(71, 5, 'TRS', 0, 0); // Company Name
$pdf->Cell(59, 5, '', 0, 0); // Empty cell for spacing
$pdf->Cell(59, 5, 'Details', 0, 1); // Details text

// Add company address and invoice details
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(130, 5, 'Near DAV', 0, 0); // Company Address
$pdf->Cell(25, 5, 'Customer ID', 0, 0);
$pdf->Cell(34, 5, '0012', 0, 1); // Customer ID

$pdf->Cell(130, 5, 'City, 751001', 0, 0); // City and Zip Code
$pdf->Cell(25, 5, 'Invoice Date', 0, 0);
$pdf->Cell(34, 5, '12th Jan 2019', 0, 1); // Invoice Date

$pdf->Cell(130, 5, '', 0, 0); // Empty cell for spacing
$pdf->Cell(25, 5, 'Invoice Number', 0, 0);
$pdf->Cell(34, 5, ' #001', 0, 1); // Invoice Number

// Add "Bill to" section with client name
$pdf->SetFont('Arial', 'B', 15);
$pdf->Cell(130, 5, 'Bill to', 0, 0);
$pdf->Cell(59, 5, 'Quarm', 0, 0); // This should be dynamic based on client name from form submission
$pdf->Cell(189, 10, '', 0, 1); // Move to the next line

// Add table header
$pdf->Cell(50, 10, '', 0, 1); // Empty cell for spacing
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(10, 6, 'SL', 1, 0, 'C'); // Serial Number
$pdf->Cell(50, 6, 'Description', 1, 0, 'C'); // Item Description
$pdf->Cell(23, 6, 'QTY', 1, 0, 'C'); // Quantity
$pdf->Cell(30, 6, 'Unit Price', 1, 1, 'C'); // Unit Price

// Variables to store totals
$total_tax = 0;
$total_sub = 0;
$total_grand = 0;

// Add table rows with sample data using a loop
$pdf->SetFont('Arial', '', 10);
for ($i = 1; $i <= 10; $i++) {
    $qty = 1;
    $unit_price = 200.00;
    $tax = 15.00;
    $sub_total = $unit_price + $tax;
    $grand_total = $sub_total * $qty;

    $pdf->Cell(10, 6, $i, 1, 0, 'C'); // Serial Number
    $pdf->Cell(50, 6, 'Hp Laptop', 1, 0); // Item Description
    $pdf->Cell(23, 6, $qty, 1, 0, 'R'); // Quantity
    $pdf->Cell(30, 6, number_format($unit_price, 2), 1, 1, 'R'); // Unit Price

    // Accumulate totals
    $total_tax += $tax;
    $total_sub += $sub_total;
    $total_grand += $grand_total;
}

// Move to the bottom of the page
$pdf->Cell(130, 6, '', 0, 1); // Move to next line for the total row spacing

// Output totals at the bottom right of the table
$pdf->SetFont('Arial', 'B', 10);

$pdf->Cell(113, 6, '', 0, 0); // Empty cells to align the totals at the bottom

$pdf->Cell(25, 6, 'Sub Total', 1, 0, 'R'); // Subtotal label
$pdf->Cell(25, 6, number_format($total_sub, 2), 1, 1, 'R'); // Subtotal amount

$pdf->Cell(113, 6, '', 0, 0); // Empty cells to align the totals at the bottom
$pdf->Cell(25, 6, 'Tax', 1, 0, 'R'); // Tax label
$pdf->Cell(25, 6, number_format($total_tax, 2), 1, 1, 'R'); // Tax amount

$pdf->Cell(113, 6, '', 0, 0); // Empty cells to align the totals at the bottom
$pdf->Cell(25, 6, 'Grand Total', 1, 0, 'R'); // Grand Total label
$pdf->Cell(25, 6, number_format($total_grand, 2), 1, 0, 'R'); // Grand Total amount

// Output the PDF
$pdf->Output();
?>



//populated display
<?php
session_start();
include('db.php');
require('./copy/fpdf.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $date = $_POST['date'];
    $items = $_POST['items'];
    $quantities = $_POST['quantities'];
    $unit_prices = $_POST['unit_prices'];
    $total_amount = 0;

    // Insert invoice
    $sql = "INSERT INTO invoices (client_id, date, total_amount, status) VALUES ('$client_id', '$date', 0, 'Pending')";
    if ($conn->query($sql) === TRUE) {
        $invoice_id = $conn->insert_id;

        // Insert invoice items and calculate total amount
        for ($i = 0; $i < count($items); $i++) {
            $description = $items[$i];
            $quantity = $quantities[$i];
            $unit_price = $unit_prices[$i];
            $total_price = $quantity * $unit_price;
            $total_amount += $total_price;

            $sql = "INSERT INTO invoice_items (invoice_id, description, quantity, unit_price, total_price) VALUES ('$invoice_id', '$description', '$quantity', '$unit_price', '$total_price')";
            $conn->query($sql);
        }

        // Update total amount in invoice
        $sql = "UPDATE invoices SET total_amount='$total_amount' WHERE invoice_id='$invoice_id'";
        $conn->query($sql);

        // Generate PDF
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Add invoice title and details
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(59, 10, 'Invoice', 0, 1);

        // Client Details
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(130, 10, 'Bill to:', 0, 1);
        $pdf->SetFont('Arial', '', 12);

        // Fetch client details
        $client_query = "SELECT * FROM clients WHERE client_id = '$client_id'";
        $client_result = $conn->query($client_query);
        $client = $client_result->fetch_assoc();

        $pdf->Cell(130, 10, $client['name'], 0, 1);
        $pdf->Cell(130, 10, $client['email'], 0, 1);

        // Add table headers
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'SL', 1, 0, 'C');
        $pdf->Cell(80, 6, 'Description', 1, 0, 'C');
        $pdf->Cell(20, 6, 'QTY', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Unit Price', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Total', 1, 1, 'C');

        // Add items
        $pdf->SetFont('Arial', '', 10);

        for ($i = 0; $i <= count($items); $i++) {
            $pdf->Cell(10, 6, ($i+1), 1, 0, 'C');
            $pdf->Cell(80, 6, $items[$i], 1, 0, 'L');
            $pdf->Cell(20, 6, $quantities[$i], 1, 0, 'R');
            $pdf->Cell(30, 6, number_format($unit_prices[$i], 2), 1, 0, 'R');
            $pdf->Cell(20, 6, number_format($quantities[$i] * $unit_prices[$i], 2), 1, 1, 'R');
        }

        // Add totals at the bottom
        $pdf->SetFont('Arial', 'B', 10);

        // Empty cells to align the totals at the bottom
        $pdf->Cell(140, 6, '', 0, 0);
        
        // Subtotal
        $pdf->Cell(25, 6, 'Sub Total', 1, 0, 'R');
        $pdf->Cell(25, 6, number_format($total_amount, 2), 1, 1, 'R');

        // Tax (assuming 15% tax)
        $tax = $total_amount * 0.15;
        $pdf->Cell(140, 6, '', 0, 0);
        $pdf->Cell(25, 6, 'Tax', 1, 0, 'R');
        $pdf->Cell(25, 6, number_format($tax, 2), 1, 1, 'R');

        // Grand Total
        $grand_total = $total_amount + $tax;
        $pdf->Cell(140, 6, '', 0, 0);
        $pdf->Cell(25, 6, 'Grand Total', 1, 0, 'R');
        $pdf->Cell(25, 6, number_format($grand_total, 2), 1, 1, 'R');

        // Output PDF
        $pdf->Output();
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Your HTML form goes here -->
