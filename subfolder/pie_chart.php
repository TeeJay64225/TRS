<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch totals for users and clients
$sql_users = "SELECT COUNT(*) AS total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

// Count total clients
$sql_clients = "SELECT COUNT(*) AS total_clients FROM clients";
$result_clients = $conn->query($sql_clients);
$total_clients = $result_clients->fetch_assoc()['total_clients'];

// Count total receipts
$sql_receipts = "SELECT COUNT(*) AS total_receipts FROM receipts";
$result_receipts = $conn->query($sql_receipts);
$total_receipts = $result_receipts->fetch_assoc()['total_receipts'];

// Count total invoices
$sql_invoices = "SELECT COUNT(*) AS total_invoices FROM invoices";
$result_invoices = $conn->query($sql_invoices);
$total_invoices = $result_invoices->fetch_assoc()['total_invoices'];


?>
<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch totals for invoices
$sql_total_invoices = "SELECT COUNT(*) AS total_invoices FROM invoices";
$result_total_invoices = $conn->query($sql_total_invoices);
$total_invoices = $result_total_invoices->fetch_assoc()['total_invoices'];

$sql_unpaid_invoices = "SELECT COUNT(*) AS unpaid_invoices FROM invoices WHERE status='Unpaid'";
$result_unpaid_invoices = $conn->query($sql_unpaid_invoices);
$unpaid_invoices = $result_unpaid_invoices->fetch_assoc()['unpaid_invoices'];

$sql_paid_invoices = "SELECT COUNT(*) AS paid_invoices FROM invoices WHERE status='Paid'";
$result_paid_invoices = $conn->query($sql_paid_invoices);
$paid_invoices = $result_paid_invoices->fetch_assoc()['paid_invoices'];

$sql_overdue_invoices = "SELECT COUNT(*) AS overdue_invoices FROM invoices WHERE status='Overdue'";
$result_overdue_invoices = $conn->query($sql_overdue_invoices);
$overdue_invoices = $result_overdue_invoices->fetch_assoc()['overdue_invoices'];
?>
<?php
session_start();
include('db.php');
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch totals for receipts based on payment methods
$sql_credit_card_receipts = "SELECT COUNT(*) AS credit_card_receipts FROM receipts WHERE payment_method='credit-card'";
$result_credit_card_receipts = $conn->query($sql_credit_card_receipts);
$credit_card_receipts = $result_credit_card_receipts->fetch_assoc()['credit_card_receipts'];

$sql_bank_transfer_receipts = "SELECT COUNT(*) AS bank_transfer_receipts FROM receipts WHERE payment_method='bank-transfer'";
$result_bank_transfer_receipts = $conn->query($sql_bank_transfer_receipts);
$bank_transfer_receipts = $result_bank_transfer_receipts->fetch_assoc()['bank_transfer_receipts'];

$sql_paypal_receipts = "SELECT COUNT(*) AS paypal_receipts FROM receipts WHERE payment_method='paypal'";
$result_paypal_receipts = $conn->query($sql_paypal_receipts);
$paypal_receipts = $result_paypal_receipts->fetch_assoc()['paypal_receipts'];

?>