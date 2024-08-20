<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['client_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $client_id = $_SESSION['client_id'];
    $invoice_date = $_POST['invoice_date'];
    $due_date = $_POST['due_date'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];

    $sql = "INSERT INTO invoices (client_id, invoice_date, due_date, description, amount) VALUES ('$client_id', '$invoice_date', '$due_date', '$description', '$amount')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_invoices.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Create Invoice</title>
    <link rel="stylesheet" href="dashboardstyle.css">
</head>

<body>
    <div id="dashboard">
        <div class="sideNav">
            <!-- Side navigation code here -->
        </div>
        <main id="main">
            <header>
                <!-- Header code here -->
            </header>
            <section class="analytics">
                <div class="analyticsCard">
                    <h3 class="cardHeader">Create Invoice</h3>
                    <form method="POST" action="create_invoice.php">
                        <div>
                            <label for="invoice_date">Invoice Date:</label>
                            <input type="date" id="invoice_date" name="invoice_date" required>
                        </div>
                        <div>
                            <label for="due_date">Due Date:</label>
                            <input type="date" id="due_date" name="due_date" required>
                        </div>
                        <div>
                            <label for="description">Description:</label>
                            <input type="text" id="description" name="description" required>
                        </div>
                        <div>
                            <label for="amount">Amount:</label>
                            <input type="number" id="amount" name="amount" step="0.01" required>
                        </div>
                        <button type="submit">Create Invoice</button>
                    </form>
                </div>
            </section>
        </main>
    </div>
</body>

</html>


<?php
require_once('db.php'); // Assume this file connects to the database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect client information
    $client_name = $_POST['client_name'];
    $client_email = $_POST['client_email'];
    $client_address1 = $_POST['client_address1'];
    $client_address2 = $_POST['client_address2'];
    $client_phone = $_POST['client_phone'];

    // Collect invoice details
    $invoice_date = $_POST['invoice_date'];
    $due_date = $_POST['due_date'];
    $total = $_POST['total'];
    $tax_rate = $_POST['tax_rate'];
    $tax = $_POST['tax'];
    $grand_total = $_POST['grand_total'];
    $payment_method = $_POST['payment_method'];
    $message = $_POST['message'];

    // Insert invoice data
    $insert_invoice_sql = "INSERT INTO invoices (client_name, client_email, client_address1, client_address2, client_phone, invoice_date, due_date, total, tax_rate, tax, grand_total, payment_method, message) VALUES ('$client_name', '$client_email', '$client_address1', '$client_address2', '$client_phone', '$invoice_date', '$due_date', '$total', '$tax_rate', '$tax', '$grand_total', '$payment_method', '$message')";
    mysqli_query($conn, $insert_invoice_sql);

    $invoice_id = mysqli_insert_id($conn); // Get the ID of the newly created invoice

    // Insert each invoice item
    foreach ($_POST['product'] as $index => $product) {
        $qty = $_POST['qty'][$index];
        $price = $_POST['price'][$index];
        $discount = $_POST['discount'][$index];
        $subtotal = $_POST['subtotal'][$index];

        $insert_item_sql = "INSERT INTO invoice_items (invoice_id, product, qty, price, discount, subtotal) VALUES ('$invoice_id', '$product', '$qty', '$price', '$discount', '$subtotal')";
        mysqli_query($conn, $insert_item_sql);
    }

    // Redirect to a success page or back to the form with a success message
    header("Location: invoice_creation.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User | Invoice Creation</title>
    <link rel="stylesheet" href="invoice_creation.css">
    <script src="https://kit.fontawesome.com/aa7454d09f.js" crossorigin="anonymous"></script>
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
    <div id="dashboard">

        <!-- SideNav -->
        <?php include('userSideNav/nav.php'); ?>
        <main id="main">

            <!-- Header -->
            <?php include('userHeader/header.php'); ?>

            <div class="headlineContainer">
                <h1 class="headline">Invoice</h1>
            </div>

            <!-- Form to handle the entire invoice creation process -->
            <form id="invoiceForm" action="invoice_creation.php" method="POST">

                <section class="invoice-form">
                    <div class="form-container">
                        <div class="form-section">

                            <!-- Display Client Information -->
                            <h2>Client Information</h2>
                            <div class="form-group">
                                <label for="client-name">Client Name</label>
                                <input type="text" id="client-name" name="client_name" placeholder="Enter Name">
                            </div>
                            <div class="form-group">
                                <label for="client-email">E-mail Address</label>
                                <input type="email" id="client-email" name="client_email" placeholder="E-mail Address">
                            </div>
                            <div class="form-group">
                                <label for="client-address1">Address 1</label>
                                <input type="text" id="client-address1" name="client_address1" placeholder="Address 1">
                            </div>
                            <div class="form-group">
                                <label for="client-address2">Address 2</label>
                                <input type="text" id="client-address2" name="client_address2" placeholder="Address 2">
                            </div>
                            <div class="form-group">
                                <label for="client-phone">Phone Number</label>
                                <input type="text" id="client-phone" name="client_phone" placeholder="Phone Number">
                            </div>

                        </div>

                        <div class="form-section1">
                            <div class="form-group">
                                <label for="invoice_date">Invoice Date:</label>
                                <input type="date" id="invoice_date" name="invoice_date" class="form-control required" required>
                            </div>
                            <div class="form-group">
                                <label for="due_date">Due Date:</label>
                                <input type="date" id="due_date" name="due_date" class="form-control required" required>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="analytics">
                    <div class="analyticsCard">
                        <div>
                            <!-- Itemization of service and products -->
                            <h2>Invoice Items</h2>
                            <br>

                            <table class="invoice-table table table-bordered table-hover table-striped" id="invoiceTable">
                                <thead>
                                    <tr>
                                        <th width="500">
                                            <h4>Product</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Qty</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Price</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Discount</h4>
                                        </th>
                                        <th width="300">
                                            <h4>Sub Total</h4>
                                        </th>
                                        <th width="200">
                                            <h4>Remove</h4>
                                        </th>
                                        <th width="200">
                                            <h4>Add</h4>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>
                                            <input type="text" name="product[]" class="form-control product">
                                        </td>
                                        <td>
                                            <input type="text" name="qty[]" class="form-control qty">
                                        </td>
                                        <td>
                                            <input type="text" name="price[]" class="form-control price">
                                        </td>
                                        <td>
                                            <input type="text" name="discount[]" class="form-control discount">
                                        </td>
                                        <td>
                                            <input type="text" name="subtotal[]" class="form-control subtotal">
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-danger btn-xs remove"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Remove</a>
                                        </td>
                                        <td>
                                            <a href="#" class="btn btn-success btn-xs addRow"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add</a>
                                        </td>
                                    </tr>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Total</h3>
                                        </td>
                                        <td>
                                            <input type="text" name="total" class="form-control total" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Tax Rate (%)</h3>
                                        </td>
                                        <td>
                                            <input type="text" name="tax_rate" class="form-control tax-rate" value="15" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Tax</h3>
                                        </td>
                                        <td>
                                            <input type="text" name="tax" class="form-control tax" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td style="border: none;"></td>
                                        <td>
                                            <h3>Grand Total</h3>
                                        </td>
                                        <td>
                                            <input type="text" name="grand_total" class="form-control grand-total" readonly>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="payment-method-group">
                                <label for="payment-method">Payment Method</label>
                                <select id="payment-method" name="payment_method">
                                    <option value="credit-card">Credit Card</option>
                                    <option value="bank-transfer">Bank Transfer</option>
                                    <option value="paypal">PayPal</option>
                                </select>
                            </div>
                            <div class="col-xs-6">
                                <textarea name="message" id="customMessage" class="customMessageTextarea" placeholder="Enter any custom message for this invoice"></textarea>
                            </div>
                            <div class="gen">
                                <div class="col-xs-6 margin-top btn-group">
                                    <button type="submit" class="btn btn-primary" id="generate-invoice">Submit Invoice</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </main>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        //toogle
        const toggleMenu = document.getElementById("toggleMenu");
        const toggelMenuIcon = document.getElementById("toggelMenuIcon");
        const sideNav = document.getElementById("sideNav");
        const toggleTheme = document.getElementById("toggleTheme");
        const toggleThemeIcon = document.getElementById("toggleThemeIcon");

        toggleMenu.onclick = (e) => {
            sideNav.classList.toggle("showsideNav");
            toggelMenuIcon.classList.toggle("rotateToggelMenuIcon")
            toggleMenu.classList.toggle("slidetoggleMenu")
        }

        toggleTheme.onclick = () => {
            document.body.classList.toggle("darkTheme")
            e.target.classList.toggle("lightMoonIcon");
        }
        
        $(document).ready(function() {
            // Add new row
            $(document).on('click', '.addRow', function() {
                var tr = '<tr>' +
                    '<td><input type="text" name="product[]" class="form-control product"></td>' +
                    '<td><input type="text" name="qty[]" class="form-control qty"></td>' +
                    '<td><input type="text" name="price[]" class="form-control price"></td>' +
                    '<td><input type="text" name="discount[]" class="form-control discount"></td>' +
                    '<td><input type="text" name="subtotal[]" class="form-control subtotal"></td>' +
                    '<td><a href="#" class="btn btn-danger btn-xs remove"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span>Remove</a></td>' +
                    '<td><a href="#" class="btn btn-success btn-xs addRow"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Add</a></td>' +
                    '</tr>';
                $('tbody').append(tr);
            });

            // Remove row
            $(document).on('click', '.remove', function() {
                $(this).closest('tr').remove();
                calculateTotal();
            });

            // Calculate subtotal
            $(document).on('input', '.qty, .price, .discount', function() {
                var row = $(this).closest('tr');
                var qty = row.find('.qty').val();
                var price = row.find('.price').val();
                var discount = row.find('.discount').val() || 0;

                var subtotal = (qty * price) - discount;
                row.find('.subtotal').val(subtotal);

                calculateTotal();
            });

            // Calculate total, tax, and grand total
            function calculateTotal() {
                var total = 0;
                $('.subtotal').each(function() {
                    var subtotal = $(this).val() - 0;
                    total += subtotal;
                });
                $('.total').val(total);

                var taxRate = $('.tax-rate').val();
                var tax = (total * taxRate) / 100;
                $('.tax').val(tax);

                var grandTotal = total + tax;
                $('.grand-total').val(grandTotal);
            }
        });
    </script>
</body>

</html>