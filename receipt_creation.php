<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_POST['client_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_method = $_POST['payment_method'];
    $description = $_POST['description'];

    $sql = "INSERT INTO receipts (client_id, amount, payment_date, payment_method, description) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idsss", $client_id, $amount, $payment_date, $payment_method, $description);

    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Receipt</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="client_mang.css">
    <style>
        .success-message {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }

        .error-message {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
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
    <div>
        <div class="toggleMenu" id="toggleMenu">
            <i class="fa-solid fa-arrow-right icon toggelMenuIcon" id="toggelMenuIcon"></i>
        </div>
        <div class="sideNav" id="sideNav">
            <div id="topNav">
                <div id="logo">
                    <span class="logoPic">TRS</span>
                    <h1 class="logoName">Truck Record Services</h1>
                </div>
                <p class="navSectionName">Main Menu</p>
                <ul class="nav">
                    <li class="navLink">
                        <i class="fa-solid fa-gauge icon"></i>
                        <a href="user_landing_page.php"> Home
                        </a>
                    </li>
                    <li class="navLink activeNavLink">
                        <i class="fa-solid fa-plus icon"></i>
                        <a href="invoice_creation.php">Invoice Creation</a>
                    </li>
                    <li class="navLink">
                        <i class="fa-solid fa-plus icon"></i>
                        <a href="receipt_management.php">Receipt Creation</a>
                    </li>
                    <li class="navLink" id="invoiceCreationNav">
                        <i class="fa-solid fa-mug-hot"></i>
                        <a href="all_invoice.php">All Invoice</a>
                    </li>
                    <li class="navLink" id="invoiceCreationNav">
                        <i class="fa-solid fa-mug-hot"></i>
                        <a href="all_receipt.php">All Receipt</a>
                    </li>
                    <li class="navLink">
                        <i class="fa-solid fa-credit-card icon"></i>
                        <a href="all_client.php">All clients</a>
                    </li>
                    <li class="navLink">
                        <i class="fa-solid fa-address-book icon"></i>
                        <a href="client_management.php">Add Client </a>
                    </li>

                </ul>
                <p class="navSectionName">Others</p>
                <ul class="nav">
                    <li class="navLink">
                        <i class="fa-solid fa-gear icon"></i>
                        Setting
                    </li>
                    <li class="navLink">
                        <i class="fa-solid fa-headset icon"></i>
                        Help Center
                    </li>
                    <li class="navLink" id="logoutNav">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <a href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>

            <div id="bottomNav">
                <h3 class="copyright">&copy; Truck Receipt Service (TRS), 2024</h3>
                <p class="copyDesc">Digital payment platform is a solution for all types of service.</p>
            </div>

        </div>
    </div>
    <div id="dashboard">
        <main id="main">
            <header>
                <h1>Create Receipt</h1>
            </header>



            <form action="receipt_creation.php" method="post">
                <div class="form-group">
                    <label for="client_id">Client ID</label>
                    <input type="number" id="client_id" name="client_id" class="form-control required" required>
                </div>
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" step="0.01" id="amount" name="amount" class="form-control required" required>
                </div>
                <div class="form-group">
                    <label for="payment_date">Payment Date</label>
                    <input type="date" id="payment_date" name="payment_date" class="form-control required" required>
                </div>
                <div class="form-group">
                    <label for="payment_method">Payment Method</label>
                    <input type="text" id="payment_method" name="payment_method" class="form-control required" required>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" class="form-control"></textarea>
                </div>
                <button type="submit">Create Receipt</button>
            </form>
        </main>

        <?php
        if ($success) {
            echo '<p class="success-message">✅ Receipt created successfully!</p>';
        } elseif ($error) {
            echo '<p class="error-message">' . $error . '</p>';
        }
        ?>
    </div>
</body>

</html>