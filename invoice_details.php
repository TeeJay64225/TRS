<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$invoice_id = $_GET['invoice_id'];

// Fetch invoice details
$sql = "SELECT invoices.*, clients.name, clients.address, clients.contact_details 
        FROM invoices 
        JOIN clients ON invoices.client_id = clients.client_id 
        WHERE invoice_id='$invoice_id'";
$invoice_result = $conn->query($sql);
$invoice = $invoice_result->fetch_assoc();

// Fetch invoice items
$sql = "SELECT * FROM invoice_items WHERE invoice_id='$invoice_id'";
$items_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoice Details</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Invoice Details</h1>
        <h2>Client Information</h2>
        <p><strong>Name:</strong> <?php echo $invoice['name']; ?></p>
        <p><strong>Address:</strong> <?php echo $invoice['address']; ?></p>
        <p><strong>Contact Details:</strong> <?php echo $invoice['contact_details']; ?></p>

        <h2>Invoice Information</h2>
        <p><strong>Invoice ID:</strong> <?php echo $invoice['invoice_id']; ?></p>
        <p><strong>Date:</strong> <?php echo $invoice['date']; ?></p>
        <p><strong>Total Amount:</strong> <?php echo $invoice['total_amount']; ?></p>
        <p><strong>Status:</strong> <?php echo $invoice['status']; ?></p>

        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($items_result->num_rows > 0) {
                    while ($row = $items_result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row['description'] . "</td>
                            <td>" . $row['quantity'] . "</td>
                            <td>" . $row['unit_price'] . "</td>
                            <td>" . $row['total_price'] . "</td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No items found</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="invoice_list.php">Back to Invoices</a>
    </div>
</body>

</html>