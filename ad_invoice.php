<?php
// Include your database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $invoice_id = $_POST['invoice_id'];
    $new_status = $_POST['status'];

    // Update the status of the selected invoice
    $stmt = $db_connection->prepare("UPDATE invoices SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $new_status, $invoice_id);

    if ($stmt->execute()) {
        // Redirect back to the invoice management page
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->connect_error;
    }
}
?>



<?php
// Include your database connection
include('db.php');

// Fetch invoices from the database categorized by status
$unpaid_invoices = $db_connection->query("SELECT * FROM invoices WHERE status = 'Unpaid' ORDER BY due_date ASC");
$paid_invoices = $db_connection->query("SELECT * FROM invoices WHERE status = 'Paid' ORDER BY created_at ASC");
$overdue_invoices = $db_connection->query("SELECT * FROM invoices WHERE status = 'Overdue' ORDER BY due_date ASC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Invoice Management</title>
    <link rel="stylesheet" href="dashboardstyle.css">
</head>
<style>
    .navLink a {
        color: var(--primaryColor);
        /* Set the text color to black */
        text-decoration: none;
        /* Remove the underline from the links */
    }

    .navLink a:hover {
        color: var(--primaryColor);
        /* Optional: Darker color on hover */
    }
</style>

<body>
    <div id="content">
        <div id="invoiceManagementContent" class="content activeContent">

            <main id="main">
                <header>
                    <h1 class="headline">Invoice Management</h1>
                </header>

                <!-- Unpaid Invoices -->
                <section class="invoiceSection">
                    <h2>Unpaid Invoices</h2>
                    <div class="invoiceContainer">
                        <?php while ($row = $unpaid_invoices->fetch_assoc()) : ?>
                            <div class="invoiceCard">
                                <p>Client: <?php echo $row['client_name']; ?></p>
                                <p>Amount: $<?php echo $row['amount']; ?></p>
                                <p>Due Date: <?php echo date('F j, Y', strtotime($row['due_date'])); ?></p>
                                <p>Status: <?php echo $row['status']; ?></p>
                                <form method="post" action="update_invoice_status.php">
                                    <input type="hidden" name="invoice_id" value="<?php echo $row['id']; ?>">
                                    <select name="status">
                                        <option value="Paid">Paid</option>
                                        <option value="Overdue">Overdue</option>
                                    </select>
                                    <button type="submit" class="btn update-btn">Update Status</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <!-- Paid Invoices -->
                <section class="invoiceSection">
                    <h2>Paid Invoices</h2>
                    <div class="invoiceContainer">
                        <?php while ($row = $paid_invoices->fetch_assoc()) : ?>
                            <div class="invoiceCard">
                                <p>Client: <?php echo $row['client_name']; ?></p>
                                <p>Amount: $<?php echo $row['amount']; ?></p>
                                <p>Due Date: <?php echo date('F j, Y', strtotime($row['due_date'])); ?></p>
                                <p>Status: <?php echo $row['status']; ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <!-- Overdue Invoices -->
                <section class="invoiceSection">
                    <h2>Overdue Invoices</h2>
                    <div class="invoiceContainer">
                        <?php while ($row = $overdue_invoices->fetch_assoc()) : ?>
                            <div class="invoiceCard">
                                <p>Client: <?php echo $row['client_name']; ?></p>
                                <p>Amount: $<?php echo $row['amount']; ?></p>
                                <p>Due Date: <?php echo date('F j, Y', strtotime($row['due_date'])); ?></p>
                                <p>Status: <?php echo $row['status']; ?></p>
                                <form method="post" action="update_invoice_status.php">
                                    <input type="hidden" name="invoice_id" value="<?php echo $row['id']; ?>">
                                    <select name="status">
                                        <option value="Paid">Paid</option>
                                    </select>
                                    <button type="submit" class="btn update-btn">Update Status</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>

</html>