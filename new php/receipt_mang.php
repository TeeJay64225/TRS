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

    // Prepare SQL statements
    $insertReceiptStmt = $conn->prepare("INSERT INTO receipts (client_id, date, total_amount, status) VALUES (?, ?, 0, 'Pending')");
    $insertItemStmt = $conn->prepare("INSERT INTO receipt_items (receipt_id, description, quantity, unit_price, total_price) VALUES (?, ?, ?, ?, ?)");
    $updateReceiptStmt = $conn->prepare("UPDATE receipts SET total_amount = ? WHERE receipt_id = ?");

    // Execute the insert receipt statement
    $insertReceiptStmt->bind_param("is", $client_id, $date);
    if ($insertReceiptStmt->execute()) {
        $receipt_id = $conn->insert_id;

        // Insert receipt items and calculate total amount
        foreach ($items as $i => $description) {
            $quantity = $quantities[$i];
            $unit_price = $unit_prices[$i];
            $total_price = $quantity * $unit_price;
            $total_amount += $total_price;

            $insertItemStmt->bind_param("isidd", $receipt_id, $description, $quantity, $unit_price, $total_price);
            $insertItemStmt->execute();
        }

        // Update total amount in receipt
        $updateReceiptStmt->bind_param("di", $total_amount, $receipt_id);
        $updateReceiptStmt->execute();

        echo "Receipt created successfully!";
    } else {
        echo "Error: " . $insertReceiptStmt->error;
    }

    // Close statements
    $insertReceiptStmt->close();
    $insertItemStmt->close();
    $updateReceiptStmt->close();
}

// Fetch clients for the client selection dropdown
$sql = "SELECT * FROM clients";
$clients_result = $conn->query($sql);
