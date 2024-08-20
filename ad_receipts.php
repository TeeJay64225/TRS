<?php
// Include your database connection
include('db.php');

//Fetch receipts from the database categorized by status
$due_receipts = $db_connection->query("SELECT * FROM receipts WHERE status = 'Due' ORDER BY due_date ASC");
$pending_receipts = $db_connection->query("SELECT * FROM receipts WHERE status = 'Pending' ORDER BY created_at ASC");
$approved_receipts = $db_connection->query("SELECT * FROM receipts WHERE status = 'Approved' ORDER BY created_at ASC");
?>
<?php
// Include your database connection
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $receipt_id = $_POST['receipt_id'];
    $new_status = $_POST['status'];

    // Update the status of the selected receipt
    $stmt = $db_connection->prepare("UPDATE receipts SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $new_status, $receipt_id);

    if ($stmt->execute()) {
        // Redirect back to the receipt management page
        header('Location: admin_dashboard.php');
        exit();
    } else {
        echo "Error updating record: " . $conn->connect_error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Receipt Management</title>
    <link rel="stylesheet" href="dashboardstyle.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <div id="receiptManagementContent" class="content activeContent">

            <main id="main">
                <header>
                    <h1 class="headline">Receipt Management</h1>
                </header>

                <!-- Due Receipts -->
                <section class="receiptSection">
                    <h2>Due Receipts</h2>
                    <div class="receiptContainer">
                        <?php while ($row = $due_receipts->fetch_assoc()) : ?>
                            <div class="receiptCard">
                                <p>Client: <?php echo $row['client_name']; ?></p>
                                <p>Amount: $<?php echo $row['amount']; ?></p>
                                <p>Due Date: <?php echo date('F j, Y', strtotime($row['due_date'])); ?></p>
                                <p>Status: <?php echo $row['status']; ?></p>
                                <form method="post" action="update_receipt_status.php">
                                    <input type="hidden" name="receipt_id" value="<?php echo $row['id']; ?>">
                                    <select name="status">
                                        <option value="Pending">Pending</option>
                                        <option value="Approved">Approved</option>
                                    </select>
                                    <button type="submit" class="btn update-btn">Update Status</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <!-- Pending Receipts -->
                <section class="receiptSection">
                    <h2>Pending Receipts</h2>
                    <div class="receiptContainer">
                        <?php while ($row = $pending_receipts->fetch_assoc()) : ?>
                            <div class="receiptCard">
                                <p>Client: <?php echo $row['client_name']; ?></p>
                                <p>Amount: $<?php echo $row['amount']; ?></p>
                                <p>Due Date: <?php echo date('F j, Y', strtotime($row['due_date'])); ?></p>
                                <p>Status: <?php echo $row['status']; ?></p>
                                <form method="post" action="update_receipt_status.php">
                                    <input type="hidden" name="receipt_id" value="<?php echo $row['id']; ?>">
                                    <select name="status">
                                        <option value="Due">Due</option>
                                        <option value="Approved">Approved</option>
                                    </select>
                                    <button type="submit" class="btn update-btn">Update Status</button>
                                </form>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>

                <!-- Approved Receipts -->
                <section class="receiptSection">
                    <h2>Approved Receipts</h2>
                    <div class="receiptContainer">
                        <?php while ($row = $approved_receipts->fetch_assoc()) : ?>
                            <div class="receiptCard">
                                <p>Client: <?php echo $row['client_name']; ?></p>
                                <p>Amount: $<?php echo $row['amount']; ?></p>
                                <p>Due Date: <?php echo date('F j, Y', strtotime($row['due_date'])); ?></p>
                                <p>Status: <?php echo $row['status']; ?></p>
                            </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>

</html>