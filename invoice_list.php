<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all invoices
$sql = "SELECT invoices.*, clients.name FROM invoices JOIN clients ON invoices.client_id = clients.client_id";
$invoices_result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Invoices</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container">
        <h1>Invoices</h1>
        <table>
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($invoices_result->num_rows > 0) {
                    while ($row = $invoices_result->fetch_assoc()) {
                        echo "<tr>
                            <td>" . $row['invoice_id'] . "</td>
                            <td>" . $row['name'] . "</td>
                            <td>" . $row['date'] . "</td>
                            <td>" . $row['total_amount'] . "</td>
                            <td>" . $row['status'] . "</td>
                            <td><a href='invoice_details.php?invoice_id=" . $row['invoice_id'] . "'>View</a></td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No invoices found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>